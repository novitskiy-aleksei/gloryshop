<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentTimeline extends Controller {  
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
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_blog'),
			'href'      => $this->url->link('content/timeline'),
       		'separator' => false
   		);	
			
				
	  		$this->document->setTitle($this->language->get('text_blog'));
			$this->document->setDescription($this->language->get('text_blog'));
			$this->document->setKeywords($this->language->get('text_blog'));			
			$this->document->addLink($this->url->link('content/timeline'), 'canonical');
			
			
			$data['heading_title'] = $this->language->get('text_timeline');
		
			
			$this->document->addStyle('assets/theme/widget/isotope_filter.css');
			$this->document->addScript('assets/plugins/isotope/isotope.min.js');
			
			
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
			
					$data['articles'] = array();
					
					$filter_data = array(
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
						$icon = 'pencil';
					   $image_width = $this->config->get('ave_cms_blog_list_image_width');			
						$image_height = $this->config->get('ave_cms_blog_list_image_height');
						
						$popup_width = $this->config->get('ave_cms_blog_details_image_height');			
						$popup_height = $this->config->get('ave_cms_blog_details_image_height');
			
						if($result['item_display']=='project'){
							$icon = 'rocket';
							$image_width = $this->config->get('ave_cms_project_list_image_width');			
							$image_height = $this->config->get('ave_cms_project_list_image_height');
							$popup_width = $this->config->get('ave_cms_project_popup_width');			
							$popup_height = $this->config->get('ave_cms_project_popup_height');
						}
						if($result['item_display']=='gallery'){
							$icon = 'image';
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
						if(!empty($result['icon'])){
							$icon = $result['icon'];
						}
										
						$data['articles'][] = array(
							'article_id'  => $result['article_id'],
							'icon'       => $icon,
							'thumb'       => $image,
							'popup'       => $popup,
							'name'        => $result['name'],
							'time' => strtotime($result['date_added']),
							'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($result['date_added'])),
							'author'        => $result['author'],
							'author_href'    	 => $this->url->link('content/author/info', 'author_id=' . $result['author_id']),
							'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'rating'      => (int)$result['rating'],
							'viewed'     => sprintf($this->language->get('text_viewed'), (int)$result['viewed']),
							'comments'     => (int)$result['comments'],
							'comments_text'     => sprintf($this->language->get('text_comments'), (int)$result['comments']),
							'href'        => $this->url->link('content/article', 'article_id=' . $result['article_id'])
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
				'href'  => $this->url->link('content/timeline', 'sort=p.date_added&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('content/timeline', 'sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('content/timeline', 'sort=pd.name&order=DESC' . $url)
			);
						
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('content/timeline', 'sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('content/timeline', 'sort=p.sort_order&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('content/timeline', 'sort=p.viewed&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('content/timeline', 'sort=p.viewed&order=DESC' . $url)
			);
			
			if ($this->config->get('ave_cms_comment_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('content/timeline', 'sort=rating&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('content/timeline', 'sort=rating&order=ASC' . $url)
				);
			}
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_asc'),
				'value' => 'na.author-ASC',
				'href'  => $this->url->link('content/timeline', 'sort=na.author&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_desc'),
				'value' => 'na.author-DESC',
				'href'  => $this->url->link('content/timeline', 'sort=na.author&order=DESC' . $url)
			);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$config_limit = ($this->config->get('ave_cms_content_limit'))?$this->config->get('ave_cms_content_limit'):12;	
			$data['limit_href'] = $this->url->link('content/timeline', $url . '&limit=' . $this->config->get('ave_cms_content_limit'));
			
			$data['limits'] = array();
			
			$data['limits'][] = array(
				'text'  => $this->config->get('ave_cms_content_limit'),
				'value' => $this->config->get('ave_cms_content_limit'),
				'href'  => $this->url->link('content/timeline', $url . '&limit=' . $this->config->get('ave_cms_content_limit'))
			);
			$data['limits'][] = array(
				'text'  => $config_limit*2,
				'value' => $config_limit*2,
				'href'  => $this->url->link('content/timeline', $url . '&limit='.$config_limit*2)
			);
			
			$data['limits'][] = array(
				'text'  => $config_limit*5,
				'value' => $config_limit*5,
				'href'  => $this->url->link('content/timeline', $url . '&limit='.$config_limit*5)
			);

			$data['limits'][] = array(
				'text'  => $config_limit*10,
				'value' => $config_limit*10,
				'href'  => $this->url->link('content/timeline', $url . '&limit='.$config_limit*10)
			);
			
			$data['limits'][] = array(
				'text'  => $config_limit*20,
				'value' => $config_limit*20,
				'href'  => $this->url->link('content/timeline', $url . '&limit='.$config_limit*20)
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
			$pagination->url = $this->url->link('content/timeline', $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		
		
			$data['config_sort'] = $this->config->get('ave_cms_sort');
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
		
			$data['continue'] = $this->url->link('common/home');
			
			
			$template='timeline';
			
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
    	
  	}
}