<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentSearch extends Controller { 	
	public function index() { 
		$language_data = $this->load->language('avethemes/search');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
			$data['ave'] = $this->ave;
		
		$this->load->model('avethemes/category');
		
		$this->load->model('avethemes/article');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['search'])) {
			$filter_name = $this->request->get['search'];
		} else {
			$filter_name = '';
		} 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['search'])) {
			$filter_tag = $this->request->get['search'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		} 
				
		if (isset($this->request->get['filter_content_id'])) {
			$filter_content_id = $this->request->get['filter_content_id'];
		} else {
			$filter_content_id = 0;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
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
		
		if (isset($this->request->get['search'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['search']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		
		$url = '';
		
		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
		}
				
		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		}
				
		if (isset($this->request->get['filter_content_id'])) {
			$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
		}
		
		if (isset($this->request->get['filter_sub_category'])) {
			$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
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
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('content/search', $url),
      		'separator' => $this->language->get('text_separator')
   		);
		
		if (isset($this->request->get['search'])) {
    		$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['search'];
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}
		
		$data['width'] = $this->config->get('ave_cms_blog_list_image_width');
		$data['height'] = $this->config->get('ave_cms_blog_list_image_height');
		
		$this->load->model('avethemes/category');
		
		// 3 Level Category Search
		$data['categories'] = array();
					
		$categories_1 = $this->model_avethemes_category->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_avethemes_category->getCategories($category_1['content_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_avethemes_category->getCategories($category_2['content_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'content_id' => $category_3['content_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'content_id' => $category_2['content_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$data['categories'][] = array(
				'content_id' => $category_1['content_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
					
		if($this->config->get('ave_cms_post_grid_limit')){
			$data['grid_limit'] = $this->config->get('ave_cms_post_grid_limit');
		}else{			
			$data['grid_limit'] = 4;
		}
			
			
		$data['articles'] = array();
		
		if (isset($this->request->get['search']) || isset($this->request->get['filter_tag'])) {
			$filter_data = array(
				'filter_name'         => $filter_name, 
				'filter_tag'          => $filter_tag, 
				'filter_description'  => $filter_description,
				'filter_content_id'  => $filter_content_id, 
				'filter_sub_category' => $filter_sub_category, 
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);
					
			$article_total = $this->model_avethemes_article->getTotalArticles($filter_data);
								
			$results = $this->model_avethemes_article->getArticles($filter_data);
					
			if($this->config->get('ave_cms_content_description_limit')){
				$description_limit=$this->config->get('ave_cms_content_description_limit');
			}			else{
				$description_limit=160;
			}
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('ave_cms_blog_list_image_width'), $this->config->get('ave_cms_blog_list_image_height'));
				} else {
					$image = false;
				}
				
				if ($this->config->get('ave_cms_comment_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
				$data['articles'][] = array(
					'article_id'  => $result['article_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'author'        => $result['author'],
					'author_href'    	 => $this->url->link('content/author/info', 'author_id=' . $result['author_id']),
					'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($result['date_added'])),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'rating'      => $result['rating'],
					'viewed'     => sprintf($this->language->get('text_viewed'), (int)$result['viewed']),
					'comments'     => sprintf($this->language->get('text_comments'), (int)$result['comments']),
					'href'        => $this->url->link('content/article', $url . '&article_id=' . $result['article_id'])
				);
			}
					
			$url = '';
			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}
					
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
			}
					
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('content/search', 'sort=p.date_added&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('content/search', 'sort=pd.name&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('content/search', 'sort=pd.name&order=DESC' . $url)
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('content/search','sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_sort_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('content/search', 'sort=p.sort_order&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('content/search', '&sort=p.viewed&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_viewed_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('content/search', '&sort=p.viewed&order=DESC' . $url)
			);
				
			if ($this->config->get('ave_cms_comment_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('content/search', 'sort=rating&order=DESC' . $url)
				); 
				
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('content/search', 'sort=rating&order=ASC' . $url)
				);
			}
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_asc'),
				'value' => 'na.author-ASC',
				'href'  => $this->url->link('content/search', 'sort=na.author&order=ASC' . $url)
			); 
	
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_author_desc'),
				'value' => 'na.author-DESC',
				'href'  => $this->url->link('content/search', 'sort=na.author&order=DESC' . $url)
			);
	
			$url = '';
			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}
					
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$data['limits'] = array();
			
			$data['limits'][] = array(
				'text'  => $this->config->get('ave_cms_content_limit'),
				'value' => $this->config->get('ave_cms_content_limit'),
				'href'  => $this->url->link('content/search', $url . '&limit=' . $this->config->get('ave_cms_content_limit'))
			);
						
			$data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('content/search', $url . '&limit=25')
			);
			
			$data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('content/search', $url . '&limit=50')
			);
	
			$data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('content/search', $url . '&limit=75')
			);
			
			$data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('content/search', $url . '&limit=100')
			);
					
			$url = '';
	
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . urlencode(html_entity_decode($this->request->get['filter_tag'], ENT_QUOTES, 'UTF-8'));
			}
					
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
			}
										
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
			$pagination->url = $this->url->link('content/search', $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		}	
		
		$data['search'] = $filter_name;
		$data['filter_description'] = $filter_description;
		$data['filter_content_id'] = $filter_content_id;
		$data['filter_sub_category'] = $filter_sub_category;
		
		$data['config_sort'] = $this->config->get('ave_cms_sort');		
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/search.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content/search.tpl';
		} else {
			$this_template = 'default/avethemes/template/content/search.tpl';
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
?>