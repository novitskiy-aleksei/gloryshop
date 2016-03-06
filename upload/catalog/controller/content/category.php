<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentCategory extends Controller {  
	public function index() { 
		$language_data = $this->load->language('avethemes/category');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
			$data['ave'] = $this->ave;
		
		$this->load->model('avethemes/category');
		
		$this->load->model('avethemes/article');
		
		$this->load->model('tool/image'); 
		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = $this->config->get('ave_cms_sort');
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = $this->config->get('ave_cms_order');
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('ave_cms_content_limit');
		}
					
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		if (isset($this->request->get['content_id'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['content_id']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
									
				$category_info = $this->model_avethemes_category->getCategory($path_id);
				
				if ($category_info) {
	       			$data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('content/category', 'content_id=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			
			$content_id = (int)array_pop($parts);
			$full_path = $this->request->get['content_id'];
		} else {
			$content_id = 0;
			$full_path = 0;
		}
				
		$category_info = $this->model_avethemes_category->getCategory($content_id);
	
		if ($category_info&&($category_info['type']=='category'||$category_info['type']=='faq')) {
	  		$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);			
			$this->document->addLink($this->url->link('content/category', 'content_id=' . $content_id), 'canonical');
			
			
			$data['heading_title'] = $category_info['name'];
			$data['icon'] = $category_info['icon'];
			$data['content_id'] = $category_info['content_id'];
			$data['description'] = ($category_info['description']!='&lt;p&gt;&lt;br&gt;&lt;/p&gt;')?html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8'):'';		
			
			$template=$category_info['item_display'];
			
			// category start	
			if($category_info['type']=='category'){
				
			if($template=='project'){
				$this->document->addStyle('assets/theme/widget/isotope_filter.css');
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			if($template=='gallery'){
				$this->document->addStyle('assets/theme/widget/isotope_filter.css');
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			
			if($this->config->get('ave_cms_post_grid_limit')){
				$data['ave_cms_post_grid_limit'] = $this->config->get('ave_cms_post_grid_limit');
			}else{			
				$data['ave_cms_post_grid_limit'] = 3;
			}
			
			if($this->config->get('ave_cms_gallery_grid_limit')){
				$data['ave_cms_gallery_grid_limit'] = $this->config->get('ave_cms_gallery_grid_limit');
			}else{			
				$data['ave_cms_gallery_grid_limit'] = 3;
			}
			
			if($this->config->get('ave_cms_project_grid_limit')){
				$data['ave_cms_project_grid_limit'] = $this->config->get('ave_cms_project_grid_limit');
			}else{			
				$data['ave_cms_project_grid_limit'] = 3;
			}
			
			
			$data['category_width'] =$this->config->get('ave_cms_category_width');
					
			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('ave_cms_category_width'), $this->config->get('ave_cms_category_height'));
			} else {
				$data['thumb'] = '';
			}
									
		
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
								
			$data['categories'] = array();
			
			$results = $this->model_avethemes_category->getCategories($content_id);
			
			foreach ($results as $result) {
				$filter_data = array(
					'filter_content_id'  => $result['content_id'],
					'filter_sub_category' => true
				);
				
				if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], 60, 60);
				} else {
						$image = $this->model_tool_image->resize('no_image.png', 60, 60);
				}
				$article_total = $this->model_avethemes_article->getTotalArticles($filter_data);				
				
				$data['categories'][] = array(	
					'name'  => $result['name'] . ($this->config->get('config_article_count') ? ' (' . $article_total . ')' : ''),
					'image'=>$image,
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 128) . '..',
					'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '_' . $result['content_id'] . $url)
				);
			}
			
			if ($category_info['display']) {
				$data['display'] = $category_info['display'];			
			}else{			
				$data['display'] = 'item-list';
			}
						
			$image_width = $this->config->get('ave_cms_blog_list_image_width');			
			$image_height = $this->config->get('ave_cms_blog_list_image_height');
			
			$popup_width = $this->config->get('ave_cms_blog_details_image_height');			
			$popup_height = $this->config->get('ave_cms_blog_details_image_height');

			if($template=='project'){
				$image_width = $this->config->get('ave_cms_project_list_image_width');			
				$image_height = $this->config->get('ave_cms_project_list_image_height');
				$popup_width = $this->config->get('ave_cms_project_popup_width');			
				$popup_height = $this->config->get('ave_cms_project_popup_height');
			}
			if($template=='gallery'){
				$image_width = $this->config->get('ave_cms_gallery_list_image_width');			
				$image_height = $this->config->get('ave_cms_gallery_list_image_height');
				$popup_width = $this->config->get('ave_cms_article_popup_width');			
				$popup_height = $this->config->get('ave_cms_article_popup_height');
			}

			
			
			$data['image_width'] = $image_width;			
			$data['image_height'] =  $image_height;
			
					$data['articles'] = array();
					
					$filter_data = array(
						'filter_content_id' => $content_id, 
						'sort'               => $sort,
						'order'              => $order,
						'start'              => ($page - 1) * $limit,
						'limit'              => $limit
					);
							
					$article_total = $this->model_avethemes_article->getTotalArticles($filter_data); 
					
					$results = $this->model_avethemes_article->getArticles($filter_data);
					
					if($this->config->get('ave_cms_content_description_limit')){
						$description_limit=$this->config->get('ave_cms_content_description_limit');
					}			else{
						$description_limit=255;
					}
					$data['filter_services'] = array();
					
					foreach ($results as $result) {	
					
						$services = array();		
						
						if(($template=='project'||$template=='gallery')&&!empty($result['article_service'])){					
							$this->load->model('avethemes/service');
							$services = $this->model_avethemes_service->getServiceGroup(explode(',', $result['article_service']));
							foreach ($services as $service) {					
								$data['filter_services'][$service['section']] =array(
									'name' =>		$service['name'],
									'section' =>	$service['section'],
									'class' =>		$service['color'],
									'icon' =>		$service['icon']
								);
							}
						}
						
						if ($result['image']&&file_exists(DIR_IMAGE.$result['image'])) {
							$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
							$popup = $this->model_tool_image->resize($result['image'], $popup_width, $popup_height);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', $image_width, $image_height);
							$popup = $this->model_tool_image->resize('no_image.png', $popup_width, $popup_height);
						}		
						
						if ($this->config->get('ave_cms_comment_status')) {
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}
										
						$data['articles'][] = array(
							'article_id'  => $result['article_id'],
							'thumb'       => $image,
							'popup'       => $popup,
							'services'       => $services,
							'name'        => $result['name'],
							'time' => strtotime($result['date_added']),
							'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($result['date_added'])),
							'author'        => $result['author'],
							'author_href'    	 => $this->url->link('content/author/info', 'author_id=' . $result['author_id']),
							'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'rating'      => (int)$result['rating'],
							'viewed'     => sprintf($this->language->get('text_viewed'), (int)$result['viewed']),
							'comm_count'     => (int)$result['comments'],
							'comments'     => sprintf($this->language->get('text_comments'), (int)$result['comments']),
							'href'        => $this->url->link('content/article', 'content_id=' . $full_path .'&article_id=' . $result['article_id'])
						);
					}
			
			$url = '';
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=p.date_added&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=pd.name&order=DESC' . $url)
			);
						
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=p.sort_order&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=p.viewed&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=p.viewed&order=DESC' . $url)
			);
			
			if ($this->config->get('ave_cms_comment_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=rating&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=rating&order=ASC' . $url)
				);
			}
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_asc'),
				'value' => 'na.author-ASC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=na.author&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_desc'),
				'value' => 'na.author-DESC',
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . '&sort=na.author&order=DESC' . $url)
			);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$config_limit = ($this->config->get('ave_cms_content_limit'))?$this->config->get('ave_cms_content_limit'):12;	
			$data['limit_href'] = $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit=' . $this->config->get('ave_cms_content_limit'));
			
			$data['limits'] = array();
			
			$data['limits'][] = array(
				'text'  => $this->config->get('ave_cms_content_limit'),
				'value' => $this->config->get('ave_cms_content_limit'),
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit=' . $this->config->get('ave_cms_content_limit'))
			);
			$data['limits'][] = array(
				'text'  => $config_limit*2,
				'value' => $config_limit*2,
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit='.$config_limit*2)
			);
			
			$data['limits'][] = array(
				'text'  => $config_limit*5,
				'value' => $config_limit*5,
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit='.$config_limit*5)
			);

			$data['limits'][] = array(
				'text'  => $config_limit*10,
				'value' => $config_limit*10,
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit='.$config_limit*10)
			);
			
			$data['limits'][] = array(
				'text'  => $config_limit*20,
				'value' => $config_limit*20,
				'href'  => $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&limit='.$config_limit*20)
			);
						
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('content/category', 'content_id=' . $this->request->get['content_id'] . $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		
		
			}//category type
			// faq start
			if($category_info['type']=='faq'){
				
				$template='faq';	
				$data['fcategories'] = array();
				
				$fcategories =  $this->model_avethemes_category->getAllCategories();
				foreach ($fcategories as $fcategory){	
					if($fcategory['type']=='faq'){		
						$data['fcategories'][] = array(
							'content_id'    => $fcategory['content_id'],
							'name'     		=> $fcategory['name'],
							'href'     		=> $this->url->link('content/category', 'content_id=' . $fcategory['content_id'])
						);
					}
				}		
					$data['faqs'] = array();
					$faqs_info = $this->model_avethemes_category->getFAQs($content_id);
					
					foreach ($faqs_info as $faq) {	
							$data['faqs'][] = array(
								'sort_order' => $faq['sort_order'],
								'question' => $faq['question'],
								'answer' => html_entity_decode($faq['answer'], ENT_QUOTES, 'UTF-8'),	
								'color' => $faq['color'],	
							);
					}	
			}//faq type
			
			$data['config_sort'] = $this->config->get('ave_cms_sort');
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
		
			$data['continue'] = $this->url->link('common/home');
			
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/category_'.$template.'.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/content/category_'.$template.'.tpl';
			} else {
				$this_template = 'default/avethemes/template/content/category_'.$template.'.tpl';
			}
			
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
			$this->response->setOutput($this->load->view($this_template, $data));										
    	} else {
			$url = '';
			
			if (isset($this->request->get['content_id'])) {
				$url .= '&path=' . $this->request->get['content_id'];
			}
									
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('content/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this_template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this_template = 'default/template/error/not_found.tpl';
			}
			
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
					
			$this->response->setOutput($this->load->view($this_template, $data));
		}
  	}
	
	public function info() { 
		$language_data = $this->load->language('avethemes/category');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$data['ave'] = $this->ave;
		$this->load->model('avethemes/category');
		if (isset($this->request->get['info_id'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['info_id']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
				
			}		
			
			$content_id = (int)array_pop($parts);
			$full_path = $this->request->get['info_id'];
		} else {
			$content_id = 0;
			$full_path = 0;
		}	
		$category_info = $this->model_avethemes_category->getCategory($content_id);

		$output = '<div class="content-info">';
		if ($category_info) {
			$output .= html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}
		$output .= '</div>';
		$this->response->setOutput($output);
		
  	}
}