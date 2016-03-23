<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProduct extends Controller {
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;	
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
		if (!empty($setting['custom_title'][$this->config->get('config_language_id')])) {
      		$heading_title = html_entity_decode($setting['custom_title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$heading_title = $this->language->get('text_'.$setting['product_type'].'_product');		
		}	
		$data['heading_title'] = $heading_title;
		$data['smartSpeed']     = (isset($setting['smartSpeed'])&&!empty($setting['smartSpeed']))?$setting['smartSpeed']:'900';
		$data['slideBy']     = (isset($setting['slideBy'])&&!empty($setting['slideBy']))?$setting['slideBy']:3;
		
		static $module = 0;
		
		if(isset($setting['product_type'])){
			$type = $product_type = $setting['product_type'];
		}
		
		if(isset($setting['display'])){
			$template = $setting['display'];				
		}
		if(empty($template)){
			$template = 'item-grid';
		}	
		 
		$display = $setting['display'];
		
		if (!empty($setting['image_width'])&&!empty($setting['image_height'])) {			
			$image_width = $setting['image_width'];
			$image_height = $setting['image_height'];
		} else {		
			$image_width = $this->config->get('config_image_product_width');
			$image_height = $this->config->get('config_image_product_height');
		}
		
		
		if (!empty($setting['description_limit'])) {	
			$description_limit = $setting['description_limit'];
		}else{
			$description_limit=160;
		}
		
		if (!empty($setting['limit'])) {	
			$limit = $setting['limit'];
		}else{
			$limit = 4;
		}
		
		
		if (!empty($setting['grid_limit'])) {	
			$grid_limit = $setting['grid_limit'];
		}elseif($this->config->get('ave_catalog_grid_limit')){
			$grid_limit=$this->config->get('ave_catalog_grid_limit');
		}else{
			$grid_limit=4;
		}
		
		if (!empty($setting['carousel_limit'])) {	
			$carousel_limit = $setting['carousel_limit'];
		}else{
			$carousel_limit='2';
		}

		if (!empty($setting['custom_description'][$this->config->get('config_language_id')])) {
			$description = html_entity_decode($setting['custom_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
			$description='';
		}
				
				
		
		$this->load->model('avethemes/global'); 	
		$this->load->model('tool/image');

		$data['products'] = array();
		$products = array();
					
		/*product related*/ 
		if ($setting['product_type']=='related') {
			if(isset($setting['products'])){
				$products = $setting['products'];
			}
			if(isset($this->request->get['product_id'])){
				$products = $this->model_avethemes_global->getProductRelated($this->request->get['product_id'],$setting['limit']);
			}
				$product_type = 'related';
		}
		
		/*latest*/ 
		if ($setting['product_type']=='latest') {
		$latest_data = array(
					'sort'  => 'p.date_added',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $setting['limit']
				);
				$products = $this->model_avethemes_global->getProducts($latest_data);
				$product_type = 'latest';
		}
		/*bestseller*/ 
		if ($setting['product_type']=='bestseller') {
			$products = $this->model_avethemes_global->getBestSellerProducts($setting['limit']);
			$product_type = 'bestseller';
		}
		/*special*/ 
		if ($setting['product_type']=='special') {
			$special_data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting['limit']
			);
			$products = $this->model_avethemes_global->getProductSpecials($special_data);
			$product_type = 'special';
		}
		/*custom_item*/ 
		if ($setting['product_type']=='custom_item'&&!empty($setting['custom_item'])) {		
					$custom_product = $setting['custom_item'];	
					$custom_limit = array_slice($custom_product, 0, (int)$limit);
					$products = $this->model_avethemes_global->getProductsGroup(array('id_group'=>$custom_limit));					
					$product_type = 'featured';
		}
		/*random*/ 
		else if ($setting['product_type']=='random') {
				$rand = array("DESC", "ASC");
				$rand_order = array_rand($rand, 1);
				$random_filter = array(
					'sort'  => 'Rand()',
					'order' => $rand[$rand_order],
					'start' =>rand(1,9),
					'limit' => $limit,
					'time' => time()
				);
				$products = $this->model_avethemes_global->getProducts($random_filter);
				$product_type = false;
		}
		/*popular*/ 
		if ($setting['product_type']=='popular') {
			$products = $this->model_avethemes_global->getPopularProducts($setting['limit']);
			$product_type = false;
		}
		/*most_viewed*/ 
		if ($setting['product_type']=='most_viewed') {
			$most_filter = array(
					'sort'  => 'p.viewed',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
			);
			$products = $this->model_avethemes_global->getProducts($most_filter);
			$product_type = false;
		}
		/*product type*/ 
		foreach ($products as $result) {
			if ($result['image']&&file_exists(DIR_IMAGE.$result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				$sales_percent = str_replace('.00','',number_format((100-(($result['special']*100)/$result['price'])),0));
			} else {
				$special = false;
				$sales_percent = false;
			}	
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
							
			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,	
				'name'    	 => $result['name'],
				'tax'   	 => $tax,	
				'price'   	 => $price,
				'special' 	 => $special,
				'sales_percent'     => $sales_percent,
				'rating'     => $rating,
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
		
			$config =	$this->ave->get($position.'_binding'); 
			 			    
			if($position=='content_top'||$position=='content_bottom'){
				$config =	$this->ave->get('content_binding');  
			}
		
		$data['description'] = $description;
		$data['grid_limit'] = $grid_limit;
		$data['carousel_limit'] = $carousel_limit;
		$data['template'] = $display;
		
		$data['image_width'] = $image_width;
		$data['image_height'] = $image_height;
		
		$data['product_type'] = $product_type;
		
		
		$data['btn_cart'] = $this->ave->get('btn_cart');
		$data['btn_whistlist'] = $this->ave->get('btn_whistlist'); 
		$data['btn_compare'] = $this->ave->get('btn_compare');

		$data['carousel_autoplay'] = isset($setting['carousel_autoplay'])?$setting['carousel_autoplay']:'false';				
			
		$data['item_image']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_image'); 
		$data['item_desc']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_desc'); 
	
		$data['carousel_nav'] = isset($setting['carousel_nav'])?$setting['carousel_nav']:'top';
		$data['num_row'] = isset($setting['num_row'])?$setting['num_row']:1;
		$data['product_total'] = count($products);
		
		$data['ribbon_bg']		=	 false;
		$data['ribbon_label']	=	 false;
		
		if($setting['product_type']=='custom_item'){
			$data['ribbon_bg']		=	 'featured_bg';
			$data['ribbon_label']	=	 $this->ave->text('featured_label');
		}
		if (in_array($setting['product_type'], array('bestseller','special','latest'))&&$this->ave->get('ribbon_'.$type.'_status')==true) {
			$data['ribbon_bg']		=	 $type.'_bg ';
			$data['ribbon_label']	=	 $this->ave->text($type.'_label');
		}
		$data['module'] = 'product_by_'.$type.$template.'_'.$module++; 	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/product_by_type/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/product_by_type/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/product_by_type/'.$template.'.tpl';
		}
        return $this->load->view($this_template, $data);
		}
	}
}
?>