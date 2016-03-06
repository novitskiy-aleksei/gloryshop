<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProductTabs extends Controller {
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['tabs_title'] = $this->language->get('product_tabs_title');
		$data['tabs_icon'] = $this->language->get('product_tabs_icon');
		$data['special_label'] = $this->ave->get('ribbon_special_status');
		$data['ave'] = $this->ave;
		$tabs = $setting['tabs_status'];
		$tabs_status = array(
			'featured'=>false,
			'bestseller'=>false,
			'special'=>false,
			'latest'=>false,
			'most_viewed'=>false,
			'popular'=>false,
			'random'=>false		
		);
		foreach ($tabs_status as $key => $value){
			if (!isset($tabs[$key])) {
				$tabs[$key] = $value;
			}
		}
		$data['products_sort'] = explode(',', $setting['product_sort']);
		
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
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
		
		if(isset($setting['display'])){
			$template = $setting['display'];				
		}
		if(empty($template)){
			$template = 'item-grid';
		}	
		$display = $setting['display'];		
		
		if (!empty($setting['limit'])) {	
			$limit = $setting['limit'];
		}else{
			$limit = 4;
		}
		
		if (!empty($setting['image_width'])&&!empty($setting['image_height'])) {			
			$image_width = $setting['image_width'];
			$image_height = $setting['image_height'];
		} else {		
			$image_width = $this->config->get('config_image_product_width');
			$image_height = $this->config->get('config_image_product_height');
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
		
		if (!empty($setting['custom_description'])) {	
			$description = html_entity_decode($setting['custom_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
			$description='';
		}
		$this->load->model('avethemes/global'); 	
		$this->load->model('tool/image');

		$data['product_tabs'] = array();
		$data['label'] = array();
		/*product type*/ 
		/*latest*/ 
		if ($tabs['latest']) {
		$latest_data = array(
					'sort'  => 'p.date_added',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $setting['limit']
				);
				$latest_products = $this->model_avethemes_global->getProducts($latest_data);
				$data['product_tabs']['latest'] = $this->product_data($setting,$latest_products);
				$data['label']['latest'] = $this->ave->text('latest_label');
		}
		/*bestseller*/
		if ($tabs['bestseller']) {
			$bestseller_products = $this->model_avethemes_global->getBestSellerProducts($setting['limit']);
			$data['product_tabs']['bestseller'] = $this->product_data($setting,$bestseller_products);
			$data['label']['bestseller'] = $this->ave->text('bestseller_label');
		}
		/*special*/ 
		if ($tabs['special']) {
			$special_data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting['limit']
			);
			$special_products = $this->model_avethemes_global->getProductSpecials($special_data);
			$data['product_tabs']['special'] = $this->product_data($setting,$special_products);
			$data['label']['special'] = $this->ave->text('special_label');
		}
		/*custom_item*/ 
		if ($tabs['featured']&&!empty($setting['custom_item'])) {
					$custom_product = $setting['custom_item'];	
					$custom_limit = array_slice($custom_product, 0, (int)$limit);
					$featured_products = $this->model_avethemes_global->getProductsGroup(array('id_group'=>$custom_limit));		
					$data['product_tabs']['featured'] = $this->product_data($setting,$featured_products);
					$data['label']['featured'] = $this->ave->text('featured_label');
		}
		/*random*/
		if ($tabs['random']) {
				$rand = array("DESC", "ASC");
				$rand_order = array_rand($rand, 1);
				$random_filter = array(
					'sort'  => 'Rand()',
					'order' => $rand[$rand_order],
					'start' =>rand(1,9),
					'limit' => $limit,
					'time' => time()
				);
				$random_products = $this->model_avethemes_global->getProducts($random_filter);
				$data['product_tabs']['random'] = $this->product_data($setting,$random_products);
				$data['label']['random'] = $this->ave->text('random_label');
		}
		/*popular*/
		if ($tabs['popular']) {
			$popular_products = $this->model_avethemes_global->getPopularProducts($setting['limit']);
			$data['product_tabs']['popular'] = $this->product_data($setting,$popular_products);
			$data['label']['popular'] = $this->ave->text('popular_label');
		}
		/*most_viewed*/ 
		if ($tabs['most_viewed']) {
			$most_filter = array(
					'sort'  => 'p.viewed',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
			);
			$most_viewed_products = $this->model_avethemes_global->getProducts($most_filter);
			$data['product_tabs']['most_viewed'] = $this->product_data($setting,$most_viewed_products);
			$data['label']['most_viewed'] = $this->ave->text('most_viewed_label');
		}
		$data['description'] = $description;
		$data['grid_limit'] = $grid_limit;
		$data['carousel_limit'] = $carousel_limit;
		$data['template'] = $display;
		
		$data['image_width'] = $image_width;
		$data['image_height'] = $image_height;
		
		$data['btn_cart'] = $this->ave->get('btn_cart');
		$data['btn_whistlist'] = $this->ave->get('btn_whistlist'); 
		$data['btn_compare'] = $this->ave->get('btn_compare');
		
		$data['carousel_nav'] = isset($setting['carousel_nav'])?$setting['carousel_nav']:'top';
		$data['num_row'] = isset($setting['num_row'])?$setting['num_row']:1;
		$data['carousel_autoplay'] = isset($setting['carousel_autoplay'])?$setting['carousel_autoplay']:'false';				
			
		$data['item_image']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_image'); 
		$data['item_desc']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_desc'); 

		
		$data['module'] = 'product_tabs_'.$template.'_'.$module++; 	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/product_tabs/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/product_tabs/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/product_tabs/'.$template.'.tpl';
		}
        return $this->load->view($this_template, $data);
		}
	}
	private function product_data($setting,$products){
		
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
		
		$products_data = array();
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
							
			$products_data[] = array(
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
		return $products_data;
		
	}
}
?>