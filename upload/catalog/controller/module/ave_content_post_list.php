<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveContentPostList extends Controller {
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
		
        $this->load->model('avethemes/category');
        $this->load->model('avethemes/article');	
        $this->load->model('tool/image');
		
		if (!empty($setting['display'])) {	
			$template = $setting['display'];
		}else{
			$template='post-grid';
		}
			
		if(strpos($template, 'gallery-') !== false){
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/skin/smooth-skin/skin.css');
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/lightbox.css');
			$this->document->addScript('assets/plugins/jquery-mousewheel/jquery.mousewheel.js');
			$this->document->addScript('assets/plugins/jquery-lightbox/js/lightbox.min.js');
		}
			$this->document->addStyle('assets/theme/widget/isotope_filter.css');
		if(strpos($template, 'mixup') !== false){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
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
				
		/*sub category*/ 	
		$colors = $this->ave->getColors();
		$color = array();
		foreach ($colors as $key=>$value) {					
				$color[] = $key;
		}	
		
		$categories = array();

		$i = 0;
		$category_group_info = $this->model_avethemes_category->getCategoryGroup($category_group);
				$image_width = $this->config->get('ave_cms_blog_list_image_width');
				$image_height = $this->config->get('ave_cms_blog_list_image_height');
				$popup_width =	$this->config->get('ave_cms_article_popup_width');
				$popup_height = $this->config->get('ave_cms_article_popup_height');
		foreach ($category_group_info as $category_info) {			
			if($category_info['item_display']=='gallery'){
				$image_width = $this->config->get('ave_cms_gallery_list_image_width');
				$image_height = $this->config->get('ave_cms_gallery_list_image_height');
				$popup_width =	$this->config->get('ave_cms_gallery_popup_width');
				$popup_height = $this->config->get('ave_cms_gallery_popup_height');
			}
			if($category_info['item_display']=='project'){
				$image_width = $this->config->get('ave_cms_project_list_image_width');
				$image_height = $this->config->get('ave_cms_project_list_image_height');
				$popup_width =	$this->config->get('ave_cms_project_popup_width');
				$popup_height = $this->config->get('ave_cms_project_popup_height');
			}						
				
				if ($category_info['image']) {
							$category_image = $this->model_tool_image->resize($category_info['image'], 60, 60);
					} else {
							$category_image = $this->model_tool_image->resize('no_image.png', 60, 60);
				}		
				$filter_data = array(
					'filter_content_id' => $category_info['content_id'], 
					'sort'               => $sort_by,
					'order'              => $order_by,
					'start'              => 0,
					'limit'              => $limit
				);
				$article_total = $this->model_avethemes_article->getTotalArticles($filter_data); 	

       			$articles_data=array();	
				$articles_infos = $this->model_avethemes_article->getArticles($filter_data);
				foreach ($articles_infos as $article_info) {				
						if ($article_info['image']) {
							$image = $this->model_tool_image->resize($article_info['image'], $image_width,$image_height);
							$popup = $this->model_tool_image->resize($article_info['image'], $popup_width,$popup_height);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', $image_width,$image_height);
							$popup = $this->model_tool_image->resize('no_image.png', $popup_width,$popup_height);
						}
										
						if ($this->config->get('ave_cms_comment_status')) {
							$rating = (int)$article_info['rating'];
						} else {
							$rating = false;
						}	
						if(empty($article_info['icon'])){
							$icon='fa fa-clock-o';
						}else{
							$icon=$article_info['icon'];
						}
						$articles_data[] = array(
							'article_id' => $article_info['article_id'],
							'color' => $article_info['color'],
							'icon' => $icon,
							'category'       => 'mix-'.$this->ave->stripUnicode(html_entity_decode($category_info['name'])),
							'full_image'   	 => HTTPS_SERVER.'image/'.$article_info['image'],
							'popup'   	 => $popup,
							'thumb'   	 => $image,
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
							'comments'    => (int)$article_info['comments'],
							'viewed'    => sprintf($this->language->get('text_viewed'), (int)$article_info['viewed']),
							'href'    	 => $this->url->link('content/article', 'article_id=' . $article_info['article_id']),
						);
				}
				
				$categories[] = array(
					'content_id' => $category_info['content_id'],
					'name'        => $category_info['name'],
					'color'     => $category_info['color'],
					'tab_id'     => $i.'_'.$category_info['content_id'],
					'section'        => 'mix-'.$this->ave->stripUnicode(html_entity_decode($category_info['name'])),
					'articles'        => $articles_data,
					'image'=>$category_image,
					'total'        => $article_total,
					'description' => utf8_substr(strip_tags(html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8')), 0, $category_description_limit) . '..',
					'href'  => $this->url->link('content/category', 'content_id='  . $category_info['content_id'])
				);
					$i++;
		}	
		
		$articles = array();
		if($template=='post-mixup'||$template=='project-mixup'||$template=='gallery-mixup'){
				foreach ($categories as $category) {	 
						foreach ($category['articles'] as $article) {	
							$article_id= $article['article_id'];
							$articles[$article_id] = array(
								'article_id'	 => $article['article_id'],
								'article_category' => array(),
								'color'			 => $article['color'],
								'icon' 			 => $article['icon'],
								'category'       => $article['category'],
								'full_image'   	 => $article['full_image'],
								'popup'   	 	 => $article['popup'],
								'thumb'   	 	 => $article['thumb'],
								'date_added' 	 => $article['date_added'],
								'date' => date('d', strtotime($article['date_added'])),
								'month' => date('M', strtotime($article['date_added'])),
								'ddate' => date('d/m/Y', strtotime($article['date_added'])),
								'dtime' => date('h:i', strtotime($article['date_added'])),
								'name'    	 	 => $article['name'],
								'author'    	 => $article['author'],
								'author_href'    => $article['author_href'],
								'description'    => $article['description'],
								'rating'    	 => $article['rating'],
								'comments'   	 => $article['comments'],
								'viewed'    	 => $article['viewed'],
								'href'    	 	 => $article['href'],
							);
						}
				} 
				foreach ($categories as $category) {	 
							$content_id= $category['content_id'];
						foreach ($category['articles'] as $article) {	
							$article_id= $article['article_id'];
							$articles[$article_id]['article_category'][]= $article['category'];
						}	
		
				} 
			$article_sort = array();		
			foreach ($articles as $key=>$value) {	
				$article_sort[$key] = $value['article_id'];
			}
			array_multisort($article_sort, SORT_ASC, $articles);		
		}//post-mixup
		
		$data['articles'] = $articles;	
	
		$data['categories'] = $categories; 	
	
		
		
				
		$data['grid_limit'] = $grid_limit;
		$data['carousel_limit'] = $carousel_limit;
				
		$data['template'] = $template;
		$data['carousel_nav'] = isset($setting['carousel_nav'])?$setting['carousel_nav']:'top';
		$data['num_row'] = isset($setting['num_row'])?$setting['num_row']:1;
		$data['carousel_autoplay'] = isset($setting['carousel_autoplay'])?$setting['carousel_autoplay']:'false';	
		
		$data['item_image']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_image'); 
		$data['item_desc']		=	($position=='column_left'||$position=='column_right')?12:$this->ave->get('item_desc'); 
					
		if($position=='column_left'||$position=='column_right'){
			$data['grid_limit'] = 12;	
			$data['carousel_limit'] = 1;	
		}	
			
		$data['module'] = 'post_type_category_'.$template.'_'.$module++; 	
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/post_by_category/'.$template.'.tpl')) {
            $this_template = $this->config->get('config_template') . '/avethemes/template/post_by_category/'.$template.'.tpl';
        } else {
            $this_template = 'default/avethemes/template/post_by_category/'.$template.'.tpl';
        }
        return $this->load->view($this_template, $data);
		}
    }
}

?>