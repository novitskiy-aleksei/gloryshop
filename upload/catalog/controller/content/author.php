<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentAuthor extends Controller {  
	public function index() { 
		$language_data = $this->load->language('avethemes/author');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
			$data['ave'] = $this->ave;	
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['breadcrumbs'] = array();
		
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_authors'),
			'href'      => $this->url->link('content/author'),
			'separator' => $this->language->get('text_separator')
		);
		
		$this->load->model('tool/image');	
		$this->load->model('avethemes/author');
		$this->load->model('avethemes/article');
		
		$data['authors'] = array();
									
		$results = $this->model_avethemes_author->getAuthors();
		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['author'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['author']), 0, 1);
			}
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 320, 320);
			} else {
				$image = 'assets/theme/img/avatar.jpg';
			}
			
			$total = $this->model_avethemes_article->getTotalArticlesByAuthorId($result['author_id']);
			$data['authors'][] = array(
				'author_id' => $result['author_id'],
				'author' => $result['author'],
				'competence' => $result['competence'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['author_description'], ENT_QUOTES, 'UTF-8')), 0, 64) . '..',
				'socials' => json_decode($result['socials'], true),
				'total' => $total,
				'image' => $image,
				'href' => $this->url->link('content/author/info', 'author_id=' . $result['author_id'])
			);
		}
		
		$data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/author_list.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content/author_list.tpl';
		} else {
			$this_template = 'default/avethemes/template/content/author_list.tpl';
		}			

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));										
  	}
	
	public function info() {
	
				$this->document->addStyle('assets/theme/widget/isotope_filter.css');
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
		$language_data = $this->load->language('avethemes/author');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave_cms_project_grid_limit'] = $this->config->get('ave_cms_project_grid_limit'); 
			$data['ave'] = $this->ave; 
		$this->load->model('avethemes/author');
		
		$this->load->model('avethemes/article');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['author_id'])) {
			$author_id = (int)$this->request->get['author_id'];
		} else {
			$author_id = 0;
		} 
					
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
   		
		$data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_authors'),
			'href'      => $this->url->link('content/author'),
      		'separator' => $this->language->get('text_separator')
   		);
		
		$author_info = $this->model_avethemes_author->getAuthor($author_id);
	
		if ($author_info) {
			$this->document->setTitle($author_info['author']);
			
			$url = '';
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
       			'text'      => $author_info['author'],
				'href'      => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url),
      			'separator' => $this->language->get('text_separator')
   			);
		
			$data['heading_title'] = $this->language->get('text_about_author');
			$data['author'] = $author_info['author'];
			$data['competence'] = $author_info['competence'];
			
			if (!empty($author_info)) {
				$data['socials'] = json_decode($author_info['socials'], true);
			} else {	
				$data['socials'] = '';
			}
			if ($author_info['image']) {
				$data['thumb'] = 'image/'.$author_info['image'];
			} else {
				$data['thumb'] = '';
			}
							
			$data['description'] = html_entity_decode($author_info['author_description'], ENT_QUOTES, 'UTF-8');
			
			$data['width'] = $this->config->get('ave_cms_blog_list_image_width');
			
			$data['compare'] = $this->url->link('content/compare');			
		
			if($this->config->get('ave_cms_post_grid_limit')){
				$data['grid_limit'] = $this->config->get('ave_cms_post_grid_limit');
			}else{			
				$data['grid_limit'] = 4;
			}
			$data['articles'] = array();
			
			$filter_data = array(
				'filter_author_id' => $author_id, 
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);
					
			$article_total = $this->model_avethemes_article->getTotalArticles($filter_data);
								
			$results = $this->model_avethemes_article->getArticles($filter_data);
					
			if($this->config->get('ave_cms_content_description_limit')){
				$description_limit=$this->config->get('ave_cms_content_description_limit');
			}			else{
				$description_limit=160;
			}
			foreach ($results as $result) {
				
				$image_width = $this->config->get('ave_cms_blog_list_image_width');			
				$image_height = $this->config->get('ave_cms_blog_list_image_height');
				
				$popup_width = $this->config->get('ave_cms_blog_details_image_height');			
				$popup_height = $this->config->get('ave_cms_blog_details_image_height');
	
				if($result['item_display']=='project'){
					$image_width = $this->config->get('ave_cms_project_list_image_width');			
					$image_height = $this->config->get('ave_cms_project_list_image_height');
					$popup_width = $this->config->get('ave_cms_project_popup_width');			
					$popup_height = $this->config->get('ave_cms_project_popup_height');
				}
				if($result['item_display']=='gallery'){
					$image_width = $this->config->get('ave_cms_gallery_list_image_width');			
					$image_height = $this->config->get('ave_cms_gallery_list_image_height');
					$popup_width = $this->config->get('ave_cms_article_popup_width');			
					$popup_height = $this->config->get('ave_cms_article_popup_height');
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
						$services = array();			
					
						
						if($result['item_display']=='blog'){	
							$services = 'blog';
							$data['filter_services']['blog'] =array(
									'name' =>		$this->language->get('text_blog'),
									'section' =>	'blog',
							);
						}
						if($result['item_display']=='project'){	
							$services = 'project';
							$data['filter_services']['project'] =array(
									'name' =>		$this->language->get('text_project'),
									'section' =>	'project',
							);
						
						}
						if($result['item_display']=='gallery'){	
							$services = 'gallery';
							$data['filter_services']['gallery'] =array(
									'name' =>		$this->language->get('text_gallery'),
									'section' =>	'gallery',
							);
						
						}
			
				$data['articles'][] = array(
					'article_id'  => $result['article_id'],
					'services'       => $services,
					'thumb'       => $image,
					'popup'       => $popup,
					'name'        => $result['name'],
					'author'        => $result['author'],
					'author_href'    	 => $this->url->link('content/author/info', 'author_id=' . $result['author_id']),
					'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($result['date_added'])),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'rating'      => $result['rating'],
					'viewed'     => sprintf($this->language->get('text_viewed'), (int)$result['viewed']),
					'comments'     => sprintf($this->language->get('text_comments'), (int)$result['comments']),
					'href'        => $this->url->link('content/article','author_id='.$author_id.'&article_id=' . $result['article_id']. $url )
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
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=p.date_added&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=pd.name&order=ASC' . $url)
			); 
			
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=pd.name&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('content/author/info','author_id=' . $this->request->get['author_id'] . '&sort=p.sort_order&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=p.viewed&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=p.viewed&order=DESC' . $url)
			);
	
			if ($this->config->get('ave_cms_comment_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=rating&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=rating&order=ASC' . $url)
				);
			}
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_asc'),
				'value' => 'na.author-ASC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=na.author&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_desc'),
				'value' => 'na.author-DESC',
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=na.author&order=DESC' . $url)
			);
	
			$url = '';
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			$data['limit_href'] = $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=' . $this->config->get('ave_cms_content_limit'));
			
			$data['limits'] = array();
			
			$data['limits'][] = array(
				'text'  => $this->config->get('ave_cms_content_limit'),
				'value' => $this->config->get('ave_cms_content_limit'),
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=' . $this->config->get('ave_cms_content_limit'))
			);
						
			$data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=25')
			);
			
			$data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=50')
			);
	
			$data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=75')
			);
			
			$data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=100')
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
			$pagination->url = $this->url->link('content/author/info','author_id=' . $this->request->get['author_id'] .  $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
			
			$data['config_sort'] = $this->config->get('ave_cms_sort');
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			
			$data['continue'] = $this->url->link('common/home');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/author_info.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/content/author_info.tpl';
			} else {
				$this_template = 'default/avethemes/template/content/author_info.tpl';
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
			
			if (isset($this->request->get['author_id'])) {
				$url .= '&author_id=' . $this->request->get['author_id'];
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
	public function widget($setting=array()) {
		if(defined('ave_check')){
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		$this->load->language('avethemes/global_lang');
		
		if (!empty($setting['title'][$this->config->get('config_language_id')])) {
      		$heading_title = html_entity_decode($setting['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$heading_title = $this->language->get('author_title');		
		}
    	$data['heading_title'] = $heading_title;
		
		if (!empty($setting['description'][$this->config->get('config_language_id')])) {
      		$description = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$description = '';		
		}
		
		$data['heading_align'] = !empty($setting['heading_align'])?$setting['heading_align']:'';
    	$data['description'] = $description;
    	$data['text_all_author'] = $this->language->get('text_all_author');
    	$data['text_viewmore'] = $this->language->get('text_viewmore');
    	$data['text_full_profile'] = $this->language->get('text_full_profile');
		
		$this->load->model('avethemes/author');
		$data['type'] = $setting['display'];
		$data['author_list'] = $this->url->link('content/author');
		
		if (isset($this->request->get['author_id'])) {
			$data['author_id'] = $this->request->get['author_id'];
		}else{
			$data['author_id'] = FALSE;		
		}
		$this->load->model('tool/image');	
		$this->load->model('avethemes/author');
		$this->load->model('avethemes/article');
		$data['authors'] = array();
			if($setting['display']=='author_profile'){
				$filter_data = array('start'=>0,'limit'=>12);
			}else{
				$filter_data = array();
			}	
		
		if($setting['display']=='author_featured'){
			$featured_id = $setting['author_id'];
			$author_info = $this->model_avethemes_author->getAuthor($featured_id);
			$data['href'] = $this->url->link('content/author/info', 'author_id=' . $featured_id);
			$data['thumb'] = 'image/'.$author_info['image'];
			$data['author'] = $author_info['author'];
			$data['competence'] = $author_info['competence'];
			$data['socials'] = json_decode($author_info['socials'], true);
		}else{
							
			$results = $this->model_avethemes_author->getAuthors($filter_data);
		
			foreach ($results as $result) {
				if (is_numeric(utf8_substr($result['author'], 0, 1))) {
					$key = '0 - 9';
				} else {
					$key = utf8_substr(utf8_strtoupper($result['author']), 0, 1);
				}
				
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 320, 320);
				} else {
					$image = 'assets/theme/img/avatar.jpg';
				}
				
				$total = $this->model_avethemes_article->getTotalArticlesByAuthorId($result['author_id']);
				$data['authors'][] = array(
					'author_id' => $result['author_id'],
					'author' => $result['author'],
					'competence' => $result['competence'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['author_description'], ENT_QUOTES, 'UTF-8')), 0, 64) . '..',
					'socials' => json_decode($result['socials'], true),
					'total' => $total,
					'image' => $image,
					'href' => $this->url->link('content/author/info', 'author_id=' . $result['author_id'])
				);
			}
		}
		if($setting['display']=='author_featured'){
			$template = 'author_featured';
		}elseif($setting['display']=='author_carousel'){
			$template = 'author_carousel';
		}elseif($setting['display']=='author_profile'){
			$template = 'author_profile';
		}elseif($setting['display']=='author_profile2'){
			$template = 'author_profile2';
		}else{
			$template = 'author_team';
		}
		$data['module'] = 'author_team_module';		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/shortcodes/'.$template.'.tpl';
		}
		
        return $this->load->view($this_template, $data);
		}
	}
}
?>