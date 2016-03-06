<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveContentTabs extends Controller {
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['tabs_title'] = $this->language->get('content_tabs_title');
		$data['tabs_icon'] = $this->language->get('content_tabs_icon');
		$data['special_label'] = $this->ave->get('ribbon_special_status');
		$data['ave'] = $this->ave;
		$tabs = $setting['tabs_status'];
		$tabs_status = array(
			'featured'=>false,
			'latest'=>false,
			'most_viewed'=>false,
			'random'=>false		
		);
		foreach ($tabs_status as $key => $value){
			if (!isset($tabs[$key])) {
				$tabs[$key] = $value;
			}
		}
		$data['articles_sort'] = explode(',', $setting['article_sort']);
		
		$data['post_type'] = $post_type = isset($setting['post_type'])?$setting['post_type']:'blog';
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
		$this->load->model('avethemes/article'); 	
		$this->load->model('tool/image');

		$data['content_tabs'] = array();
		$data['label'] = array();
		/*product type*/ 
		/*latest*/ 
		if ($tabs['latest']) {
		$latest_data = array(
					'sort'  => 'p.date_added',
					'item_display'  => $post_type,
					'order' => 'DESC',
					'start' => 0,
					'limit' => $setting['limit']
				);
				$latest_articles = $this->model_avethemes_article->getArticles($latest_data);
				$data['content_tabs']['latest'] = $this->content_data($setting,$latest_articles);
				$data['label']['latest'] = $this->ave->text('latest_label');
		}
		/*custom_item*/ 
		if ($tabs['featured']&&!empty($setting['custom_item'])) {
					$custom_product = $setting['custom_item'];	
					$custom_limit = array_slice($custom_product, 0, (int)$limit);
					$featured_articles = $this->model_avethemes_article->getArticlesGroup(array('id_group'=>$custom_limit,'item_display'  => $post_type));		
					$data['content_tabs']['featured'] = $this->content_data($setting,$featured_articles);
					$data['label']['featured'] = $this->ave->text('featured_label');
		}
		/*random*/
		if ($tabs['random']) {
				$rand = array("DESC", "ASC");
				$rand_order = array_rand($rand, 1);
				$random_filter = array(
					'sort'  => 'Rand()',
					'item_display'  => $post_type,
					'order' => $rand[$rand_order],
					'start' =>rand(1,9),
					'limit' => $limit,
					'time' => time()
				);
				$random_articles = $this->model_avethemes_article->getArticles($random_filter);
				$data['content_tabs']['random'] = $this->content_data($setting,$random_articles);
				$data['label']['random'] = $this->ave->text('random_label');
		}
		/*most_viewed*/ 
		if ($tabs['most_viewed']) {
			$most_filter = array(
					'sort'  => 'p.viewed',
					'item_display'  => $post_type,
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
			);
			$most_viewed_articles = $this->model_avethemes_article->getArticles($most_filter);
			$data['content_tabs']['most_viewed'] = $this->content_data($setting,$most_viewed_articles);
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

		
		$data['module'] = 'content_tabs_'.$template.'_'.$module++; 	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content_tabs/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content_tabs/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/content_tabs/'.$template.'.tpl';
		}
        return $this->load->view($this_template, $data);
		}
	}
	private function content_data($setting,$articles){
		
		$this->load->language('avethemes/global_lang');
		$articles_data = array();
		if (!empty($setting['description_limit'])) {	
			$description_limit = $setting['description_limit'];
		}elseif($this->config->get('ave_cms_content_description_limit')){
			$description_limit=$this->config->get('ave_cms_content_description_limit');
		}			else{
			$description_limit=160;
		}
		foreach ($articles as $article_info) {
			
			if($article_info['item_display']=='gallery'){
				$image_width = $this->config->get('ave_cms_gallery_list_image_width');
				$image_height = $this->config->get('ave_cms_gallery_list_image_height');
				$popup_width =	$this->config->get('ave_cms_gallery_popup_width');
				$popup_height = $this->config->get('ave_cms_gallery_popup_height');
			}elseif($article_info['item_display']=='project'){
				$image_width = $this->config->get('ave_cms_project_list_image_width');
				$image_height = $this->config->get('ave_cms_project_list_image_height');
				$popup_width =	$this->config->get('ave_cms_project_popup_width');
				$popup_height = $this->config->get('ave_cms_project_popup_height');
			}else{
				$image_width = $this->config->get('ave_cms_blog_list_image_width');
				$image_height = $this->config->get('ave_cms_blog_list_image_height');
				$popup_width =	$this->config->get('ave_cms_article_popup_width');
				$popup_height = $this->config->get('ave_cms_article_popup_height');
			}			
			
							$href = $this->url->link('content/article', 'article_id=' . $article_info['article_id']);
						if ($article_info['image']&&file_exists(DIR_IMAGE.$article_info['image'])) {
							$image = $this->model_tool_image->resize($article_info['image'], $image_width,$image_height);
							$popup = $this->model_tool_image->resize($article_info['image'], $popup_width,$popup_height);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
							$popup = $this->model_tool_image->resize('no_image.png', $popup_width,$popup_height);
						}
										
						if ($this->config->get('ave_cms_comment_status')) {
							$rating = (int)$article_info['rating'];
						} else {
							$rating = false;
						}	
						if(empty($article_info['icon'])){
							$icon='fa fa-image';
						}else{
							$icon=$article_info['icon'];
						}
						$filter_services = array();		
						
						
						$articles_data[] = array(
							'article_id' => $article_info['article_id'],
							'filter_services'       => $filter_services,
							'color' => $article_info['color'],
							'icon' => $icon,
							'full_image'   	 => HTTPS_SERVER.'image/'.$article_info['image'],
							'popup'   	 => $popup,
							'thumb'   	 => $image,
							'strtotime'   	 => strtotime($article_info['date_added']),
							'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($article_info['date_added'])),
							'date' => date('d', strtotime($article_info['date_added'])),
							'month' => date('M', strtotime($article_info['date_added'])),
							'ddate' => date('d/m/Y', strtotime($article_info['date_added'])),
							'dtime' => date('h:i', strtotime($article_info['date_added'])),
							'name'    	 => $article_info['name'],
							'author'    	 => $article_info['author'],
							'author_href'    	 => $this->url->link('content/author/info', 'author_id=' . $article_info['author_id']),
							'description'    	 => utf8_substr(strip_tags(html_entity_decode($article_info['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'rating'     => $rating,
							'button'     => true,
							'comments'    => (int)$article_info['comments'],
							'comments_text'    => sprintf($this->language->get('text_comments_text'), (int)$article_info['comments']),
							'viewed'    => sprintf($this->language->get('text_viewed'), (int)$article_info['viewed']),
							'href'    	 => $href,
						);
			}
		return $articles_data;
		
	}
}
?>