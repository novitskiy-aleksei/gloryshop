<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveContentPostType extends Controller {
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;
		$data['link_type'] =  $link_type = (isset($setting['link_type']))?$setting['link_type']:'';
		
		$data['timeline'] = $this->url->link('content/timeline');
		
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
		if (!empty($setting['custom_title'][$this->config->get('config_language_id')])) {
      		$heading_title = html_entity_decode($setting['custom_title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$heading_title = $this->language->get('text_'.$setting['article_type']);		
		}
		$data['heading_title'] = isset($setting['heading_title'])?$setting['heading_title']:$heading_title;
		$data['smartSpeed']     = (isset($setting['smartSpeed'])&&!empty($setting['smartSpeed']))?$setting['smartSpeed']:'900';
		$data['slideBy']     = (isset($setting['slideBy'])&&!empty($setting['slideBy']))?$setting['slideBy']:3;
		
		$data['btn_more'] = isset($setting['btn_more'])?$setting['btn_more']:false;
		
		static $module = 0;	
		
			$this->document->addStyle('assets/theme/widget/isotope_filter.css');
			
		$this->load->model('avethemes/article'); 		
		$this->load->model('tool/image');
		
		 
		 
		
		if (!empty($setting['display'])) {	
			$template = $setting['display'];
		}else{
			$template='post-grid';
		}
					
		$dir=$this->ave->layout('dir');
		
		
		if (!empty($setting['limit'])) {	
			$limit = $setting['limit'];
		}else{
			$limit = 4;
		}
		if (!empty($setting['description_limit'])) {	
			$description_limit = $setting['description_limit'];
		}elseif($this->config->get('ave_cms_content_description_limit')){
			$description_limit=$this->config->get('ave_cms_content_description_limit');
		}			else{
			$description_limit=160;
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
		
		if (!empty($setting['custom_description'][$this->config->get('config_language_id')])) {
			$description = html_entity_decode($setting['custom_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
			$description='';
		}
		if($template=='project-filter'||$template=='project-filter-fullwidth'||$template=='blog-masonry'||$template=='blog-timeline'){
			$this->document->addScript('assets/plugins/isotope/isotope.min.js');
		}
		
		
		if($template=='gallery-carousel'||$template=='project-cover-photo'){
			$this->document->addStyle('assets/theme/widget/featured_slide.css');
		}
		if($template=='gallery-popup'){
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/skin/smooth-skin/skin.css');
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/lightbox.css');
			$this->document->addScript('assets/plugins/jquery-mousewheel/jquery.mousewheel.js');
			$this->document->addScript('assets/plugins/jquery-lightbox/js/lightbox.min.js');
		}
			
		
		$data['articles'] = array();
		$articles = array();
		/*article type*/ 
		
		
		if ($setting['article_type']=='same_author'&&isset($this->request->get['article_id'])) {
			$articles = $this->model_avethemes_article->getArticleSame($this->request->get['article_id'],$post_type,(int)$limit);
		}
		/*related_article*/ 
		if ($setting['article_type']=='relate_article') {
			$articles = $this->model_avethemes_article->getArticleRelated($setting['parent_id'],$post_type, (int)$limit);
			
		}
		/*featured_article*/ 
		if ($setting['article_type']=='featured_article'&&$this->config->get('featured_article')) {
				$featured_article = $this->config->get('featured_article');	
				$featured_group = array_slice($featured_article, 0, (int)$limit);//limit
				$featured_filter = array(
					'id_group'  => $featured_group,
					'item_display'  => $post_type,
					'sort'  => 'p.article_id',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
				);
				$articles = $this->model_avethemes_article->getArticlesGroup($featured_filter);	
		}
		/*custom_item*/ 
		if ($setting['article_type']=='custom_item'&&!empty($setting['custom_item'])) {
				$custom_article = $setting['custom_item'];	
				$custom_group = array_slice($custom_article, 0, (int)$limit);//limit
				$custom_filter = array(
					'id_group'  => $custom_group,
					'item_display'  => $post_type,
					'sort'  => 'p.article_id',
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
				);
				$articles = $this->model_avethemes_article->getArticlesGroup($custom_filter);	
		}
		/*recent_article*/ 
		if ($setting['article_type']=='recent_article') {
				$recent_filter = array(
					'sort'  => 'p.article_id',
					'item_display'  => $post_type,
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
				);
		
				$articles = $this->model_avethemes_article->getArticles($recent_filter);
		}
		/*most_viewed*/ 
		if ($setting['article_type']=='most_viewed') {
				$most_filter = array(
					'sort'  => 'p.viewed',
					'item_display'  => $post_type,
					'order' => 'DESC',
					'start' => 0,
					'limit' => $limit
				);
				$articles = $this->model_avethemes_article->getArticles($most_filter);
		}
		/*random*/ 
		if ($setting['article_type']=='random_post') {
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
				$articles = $this->model_avethemes_article->getArticles($random_filter);
		}
		/*end !=*/ 	
		$this->load->model('avethemes/service');
		$data['filter_services'] = array();
		/*article type*/ 
				$image_width = $this->config->get('ave_cms_blog_list_image_width');
				$image_height = $this->config->get('ave_cms_blog_list_image_height');
				$popup_width =	$this->config->get('ave_cms_article_popup_width');
				$popup_height = $this->config->get('ave_cms_article_popup_height');
				
		foreach ($articles as $article_info) {
			
			if($article_info['item_display']=='gallery'){
				$image_width = $this->config->get('ave_cms_gallery_list_image_width');
				$image_height = $this->config->get('ave_cms_gallery_list_image_height');
				$popup_width =	$this->config->get('ave_cms_gallery_popup_width');
				$popup_height = $this->config->get('ave_cms_gallery_popup_height');
			}
			if($article_info['item_display']=='project'){
				$image_width = $this->config->get('ave_cms_project_list_image_width');
				$image_height = $this->config->get('ave_cms_project_list_image_height');
				$popup_width =	$this->config->get('ave_cms_project_popup_width');
				$popup_height = $this->config->get('ave_cms_project_popup_height');
			}			
			
						if($link_type == 'modalbox'&&($template=='carousel-image-top'||$template=='image-top')){
							$href = $this->url->link('content/article/info', 'info_id=' . $article_info['article_id']);
						}else{
							$href = $this->url->link('content/article', 'article_id=' . $article_info['article_id']);
						}
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
									
							$services = $this->model_avethemes_service->getServiceGroup(explode(',', $article_info['article_service']));
							foreach ($services as $service) {	
								$filter_services[] =	$service['section'];			
								$data['filter_services'][$service['section']] =array(
									'name' =>		$service['name'],
									'section' =>	$service['section'],
									'class' =>		$service['color'],
									'icon' =>		$service['icon']
								);
							}
						$data['articles'][] = array(
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
							'comments_text'    => sprintf($this->language->get('text_comments'), (int)$article_info['comments']),
							'viewed'    => sprintf($this->language->get('text_viewed'), (int)$article_info['viewed']),
							'href'    	 => $href,
						);
			}
			
		//	print('<pre>');print_r($data['articles']);print('</pre>'); 
		$data['module'] = 'post_by_type'.$template.'_'.$module++; 				
		$data['description'] = $description;
		$data['grid_limit'] = $grid_limit;
		$data['carousel_limit'] = $carousel_limit;
		$data['template'] = $template;
		$data['image_width'] = $image_width;
		$data['image_height'] = $image_height;
		$data['item_type'] = $setting['article_type'];
		$data['num_row'] = isset($setting['num_row'])?$setting['num_row']:1;
		$data['carousel_nav'] = isset($setting['carousel_nav'])?$setting['carousel_nav']:'top';
		
			$data['item_image']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_image'); 
			$data['item_desc']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_desc'); 
						
		if($position=='column_left'||$position=='column_right'){
			$data['carousel_limit'] = 1;	
		}		
		if($position=='column_left'&&$template!='gallery-popup'||$position=='column_right'&&$template!='gallery-popup'){
				$data['grid_limit'] = 12;	
		}	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/post_by_type/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/post_by_type/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/post_by_type/'.$template.'.tpl';
		}

        return $this->load->view($this_template, $data);
		}
	}
}
?>