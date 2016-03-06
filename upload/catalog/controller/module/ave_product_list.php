<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProductList extends Controller {
    public function index($setting=array()) {
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;
		$sort_by = isset($setting['sort_by'])?$setting['sort_by']:'p.date_added';
		$order_by = isset($setting['order_by'])?$setting['order_by']:'DESC';
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		$data['special_label'] = $this->ave->get('ribbon_special_status');
		
		/*Section Data*/ 
		$data['animation']     = !empty($setting['animation'])?$setting['animation']:'none';
		$data['icon']     = !empty($setting['icon'])?$setting['icon']:false;
		$data['heading_size'] = !empty($setting['heading_size'])?$setting['heading_size']:'';
		$data['heading_align'] = !empty($setting['heading_align'])?$setting['heading_align']:'';
		$data['section_image'] = !empty($setting['section_image'])?$setting['section_image']:false;
		$data['bgmode'] = !empty($setting['bgmode'])?$setting['bgmode']:'';
		$data['bgcolor'] = !empty($setting['bgcolor'])?$setting['bgcolor']:false;
		$data['bgimage'] = !empty($setting['bgimage'])?$setting['bgimage']:false;
		$data['paralax_class'] = isset($setting['paralax_class'])?$setting['paralax_class']:'';
		$heading_title = false;
		if (!empty($setting['custom_title'][$this->config->get('config_language_id')])) {
      		$heading_title = html_entity_decode($setting['custom_title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}
		$data['heading_title'] = $heading_title;
		
		$data['smartSpeed']     = (isset($setting['smartSpeed'])&&!empty($setting['smartSpeed']))?$setting['smartSpeed']:'900';
		$data['slideBy']     = (isset($setting['slideBy'])&&!empty($setting['slideBy']))?$setting['slideBy']:3;
		
		
		static $module = 0;
		
        $this->load->model('avethemes/global');
        $this->load->model('tool/image');
		
		if (!empty($setting['display'])) {	
			$template = $setting['display'];
		}else{
			$template='product-grid';
		}
			
		if (!empty($setting['parent_id'])) {
			$category_group = $setting['parent_id'];	
		} else {
			$category_group = array();
		}
										
		if (!empty($setting['limit'])) {
			$limit = $setting['limit'];
		} else {
			$limit = 4;
		}								
							
		if (!empty($setting['image_width'])&&!empty($setting['image_height'])) {			
			$image_width = $setting['image_width'];
			$image_height = $setting['image_height'];
		} else {		
			$image_width = $this->config->get('ave_image_product_width');
			$image_height = $this->config->get('ave_image_product_height');
		}
		
		if (!empty($setting['description_limit'])) {	
			$description_limit = $setting['description_limit'];
		}elseif($this->config->get('ave_cms_content_description_limit')){
			$description_limit=$this->config->get('ave_cms_content_description_limit');
		}else{
			$description_limit=160;
		}
		
		if (!empty($setting['category_description_limit'])) {	
			$category_description_limit = $setting['category_description_limit'];
		}else{
			$category_description_limit=160;
		}
		
		if (!empty($setting['grid_limit'])) {	
			$grid_limit = $setting['grid_limit'];
		}else{
			$grid_limit='6';
		}
		
		if (!empty($setting['carousel_limit'])) {	
			$carousel_limit = $setting['carousel_limit'];
		}else{
			$carousel_limit='2';
		}
			
		$colors = $this->ave->getColors();
		$color = array();
			foreach ($colors as $key=>$value) {					
				$color[] = $key;
			}
		/*sub category*/ 		
		
		$category_group_info = $this->model_avethemes_global->getProductCategoryGroup($category_group);
		$categories = array();
		$i = 0;
		foreach ($category_group_info as $category_info) {		
			$category_id = $category_info['category_id'];
				$i++;
				$filter_data = array(
					'filter_category_id' => $category_info['category_id'], 
					'sort'               => $sort_by,
					'order'              => $order_by,
					'start'              => 0,
					'limit'              => $limit
				);
				$product_total = $this->model_avethemes_global->getTotalProductsByCategory($filter_data);

       			$products_data=array();	
				$products_infos = $this->model_avethemes_global->getProducts($filter_data);
				foreach ($products_infos as $product_info) {	
							$product_id = $product_info['product_id'];				 
							if ($product_info['image']&&file_exists(DIR_IMAGE.$product_info['image'])) {
								$image = $this->model_tool_image->resize($product_info['image'], $image_width, $image_height);
							} else {
								$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
							}
							
							if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
								$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$price = false;
							}
									
							if ((float)$product_info['special']) {
								$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
								$sales_percent = str_replace('.00','',number_format((100-(($product_info['special']*100)/$product_info['price'])),0));
							} else {
								$special = false;
								$sales_percent = false;
							}
							
							if ($this->config->get('config_tax')) {
								$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
							} else {
								$tax = false;
							}	
							
							if ($this->config->get('config_review_status')) {
								$rating = $product_info['rating'];
							} else {
								$rating = false;
							}
						$products_data[$product_id] = array(
							'product_id' => $product_info['product_id'],
							'category'        => 'mix-'.$this->ave->stripUnicode(html_entity_decode($category_info['name'])),
							'thumb'   	 => $image,	
							'name'    	 => $product_info['name'],
							'price'   	 => $price,
							'tax'   	 => $tax,
							'special' 	 => $special,
							'sales_percent'     => $sales_percent,
							'rating'     => $rating,
							'description'=> utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
							'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						);
				}
				
				$color_rand = array_rand($color, 1);
				$categories[] = array(
					'category_id' => $category_info['category_id'],
					'name'        => $category_info['name'],
					'tab_id'     => $i.'_'.$category_info['category_id'],
					'color'     => $color[$color_rand],
					'section'        => 'mix-'.$this->ave->stripUnicode(html_entity_decode($category_info['name'])),
					'products'        => $products_data,
					'total'        => $product_total,
					'description' => utf8_substr(strip_tags(html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8')), 0, $category_description_limit) . '..',
					'href'  => $this->url->link('product/category', 'path='  . $category_info['category_id'])
				);	
		}	
		
		$data['categories'] = $categories;
		
		$data['grid_limit'] = $grid_limit;
		$data['carousel_limit'] = $carousel_limit;
		$data['carousel_nav'] = isset($setting['carousel_nav'])?$setting['carousel_nav']:'top';
		$data['num_row'] = isset($setting['num_row'])?$setting['num_row']:1;
		
		$data['template'] = $template;
		$data['image_width'] = $image_width;
		$data['image_height'] = $image_height;
		
		$data['btn_cart'] = $this->ave->get('btn_cart');
		$data['btn_whistlist'] = $this->ave->get('btn_whistlist'); 
		$data['btn_compare'] = $this->ave->get('btn_compare');
		
		$data['item_image']		=	$this->ave->get('item_image'); 
		$data['item_desc']		=	$this->ave->get('item_desc'); 
		
				
		if($position=='column_left'||$position=='column_right'){
			$data['grid_limit'] = 12;	
			$data['carousel_limit'] = 1;	
		}	
			
		$data['module'] = 'product_by_category'.$template.$module++; 
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/product_by_category/'.$template.'.tpl')) {
            $this_template = $this->config->get('config_template') . '/avethemes/template/product_by_category/'.$template.'.tpl';
        } else {
            $this_template = 'default/avethemes/template/product_by_category/'.$template.'.tpl';
        }
        return $this->load->view($this_template, $data);
		}
    }
	
}

?>