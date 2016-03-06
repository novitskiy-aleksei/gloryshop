<?php 
class ControllerAveArticle extends Controller {
	private $error = array();
	
	public function index() {
		$this->getList();
  	}
  
  	public function insert() {
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('avethemes/article');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_article->addArticle($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}	
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}
			
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/article');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_article->editArticle($this->request->get['article_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
					
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/article');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_avethemes_article->deleteArticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/article');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_avethemes_article->copyArticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			
			$this->response->redirect($this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {	

		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('avethemes/article');
		
		$this->load->model('avethemes/category');
		
		$data['categories'] = $this->model_avethemes_category->getCategories(0);	
		
		$this->load->model('avethemes/service');
		
		$data['services'] = $this->model_avethemes_service->getServices(0);	
		
			
		$this->load->model('avethemes/author');
		$data['authors'] = $this->model_avethemes_author->getAuthors(0);
					
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
			
		//filter category start//
		if (isset($this->request->get['filter_content_category'])) {
			$filter_content_category = $this->request->get['filter_content_category'];
		} else {$filter_content_category = NULL;}
		//filter service start//
		if (isset($this->request->get['filter_service_group'])) {
			$filter_service_group = $this->request->get['filter_service_group'];
		} else {$filter_service_group = NULL;}
		//filter_author
		if (isset($this->request->get['filter_author'])) {
			$filter_author = $this->request->get['filter_author'];
		} else {$filter_author = NULL;}
		//filter_date
		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {$filter_date = NULL;}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
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
						
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}		
		
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$data['insert'] = $this->url->link('ave/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('ave/article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$data['delete'] = $this->url->link('ave/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$data['articles'] = array();
		$filter_data = array(
			'filter_name'	  => $filter_name, 
			'filter_content_category'=> $filter_content_category,
			'filter_service_group'=> $filter_service_group,
			'filter_author'=> $filter_author,
			'filter_date'	  => $filter_date,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('tool/image');
		
		$article_total = $this->model_avethemes_article->getTotalArticles($filter_data);
			
		$results = $this->model_avethemes_article->getArticles($filter_data);
				    	
		foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'target' => $this->language->get('_self'),
				'href' => $this->url->link('ave/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $result['article_id'] . $url, 'SSL')
			);
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'target' => $this->language->get('_blank'),
				'href' => HTTP_CATALOG.'index.php?route=content/article&article_id=' . $result['article_id']
			);
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
		
		//filter category start//			
      $category =  $this->model_avethemes_article->getArticleCategories($result['article_id']);
	  //filter category end//
	  $type=$this->language->get('text_content');
	  if($result['item_display']=='gallery'){
	  	$type=$this->language->get('text_gallery');
	  }elseif($result['item_display']=='project'){
	  	$type=$this->language->get('text_project');
	  }else{
	  	$type=$this->language->get('text_content');
	  }
      		$data['articles'][] = array(
				'article_id' => $result['article_id'],
				'name'       => $result['name'],
				'type'       => $type,
				'category'   => $category,
				'service'   =>  explode(',', $result['article_service']),
				'author_id'=>$result['author_id'],
				'date'      => date('Y-d-m',strtotime($result['date_added'])),
				'image'      => $image,
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'sort_order'=>$result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['article_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		 
 		$data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';
			/*category*/
			if (isset($this->request->get['filter_content_category'])) {
			$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
			/*author*/
			if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . $this->request->get['filter_author'];}
			/*filter_date*/ 
			if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$data['sort_name'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_author'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&sort=na.author' . $url, 'SSL');
		$data['sort_date'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		/*category*/
		if (isset($this->request->get['filter_content_category'])) {
		$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
			/*service*/
			if (isset($this->request->get['filter_service_group'])) {
			$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
			}
		/*author*/
		if (isset($this->request->get['filter_author'])) {
		$url .= '&filter_author=' . $this->request->get['filter_author'];}
		/*filter_date*/ 
		if (isset($this->request->get['filter_date'])) {
		$url .= '&filter_date=' . $this->request->get['filter_date'];}
				
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($article_total - $this->config->get('config_limit_admin'))) ? $article_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $article_total, ceil($article_total / $this->config->get('config_limit_admin')));
	

	
		$data['filter_content_category'] = $filter_content_category;
		$data['filter_service_group'] = $filter_service_group;
		$data['filter_author'] = $filter_author;
		$data['filter_date'] = $filter_date;
		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this_template = 'avethemes/content/article_list.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
  	}

  	private function getForm() {
		
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}		

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$data['error_title'] = $this->error['name'];
		} else {
			$data['error_title'] = array();
		}
 		if (isset($this->error['related_description'])) {
			$data['error_related_description'] = $this->error['related_description'];
		} else {
			$data['error_related_description'] = array();
		}
		
		

 		if (isset($this->error['meta_description'])) {
			$data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$data['error_meta_description'] = array();
		}		
   
   		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}	
		
   		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}		
 		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		/*category*/
		if (isset($this->request->get['filter_content_category'])) {
		$url .= '&filter_content_category=' . $this->request->get['filter_content_category'];}
		/*service*/
		if (isset($this->request->get['filter_service_group'])) {
		$url .= '&filter_service_group=' . $this->request->get['filter_service_group'];
		}
		/*author*/
		if (isset($this->request->get['filter_author'])) {
		$url .= '&filter_author=' . $this->request->get['filter_author'];}
		/*filter_date*/ 
		if (isset($this->request->get['filter_date'])) {
		$url .= '&filter_date=' . $this->request->get['filter_date'];}

		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['article_id'])) {
			$data['action'] = $this->url->link('ave/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $this->request->get['article_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$article_info = $this->model_avethemes_article->getArticle($this->request->get['article_id']);
    	}

		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['article_description'])) {
			$data['article_description'] = $this->request->post['article_description'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_description'] = $this->model_avethemes_article->getArticleDescriptions($this->request->get['article_id']);
		} else {
			$data['article_description'] = array();
		}
		if (isset($this->request->get['article_id'])) {
			$data['article_id'] = $this->request->get['article_id'];
		} elseif (isset($this->request->post['author_id'])) {
			$data['article_id'] = $this->request->post['article_id'];
		} else{
			$data['article_id'] = FALSE;			
		}

		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['article_store'])) {
			$data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_store'] = $this->model_avethemes_article->getArticleStores($this->request->get['article_id']);
		} else {
			$data['article_store'] = array(0);
		}	
		
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($article_info)) {
			$data['keyword'] = $article_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		
		if (isset($this->request->post['item_display'])) {
			$data['item_display'] = $this->request->post['item_display'];
		} elseif (!empty($article_info)) {
			$data['item_display'] = $article_info['item_display'];
		} else {
			$data['item_display'] = 'blog';
		}

		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($article_info)) {
			$data['color'] = $article_info['color'];
		} else {
			$data['color'] = 'blue-sky';
		}
		
		if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (!empty($article_info)) {
			$data['icon'] = $article_info['icon'];
		} else {
			$data['icon'] = '';
		}
		
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($article_info)) {
			$data['image'] = $article_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($article_info) && $article_info['image'] && file_exists(DIR_IMAGE . $article_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
	
		$this->load->model('avethemes/author');
		
    	$data['authors'] = $this->model_avethemes_author->getAuthors();

    	if (isset($this->request->post['author_id'])) {
      		$data['author_id'] = $this->request->post['author_id'];
		} elseif (!empty($article_info)) {
			$data['author_id'] = $article_info['author_id'];
		} else {
      		$data['author_id'] = 0;
    	} 
		
		
		
		$this->load->model('avethemes/poll');
		$data['polls'] = $this->model_avethemes_poll->getPolls();
		
    	if (isset($this->request->post['poll_id'])) {
      		$data['poll_id'] = $this->request->post['poll_id'];
		} elseif (!empty($article_info)) {
			$data['poll_id'] = $article_info['poll_id'];
		} else {
      		$data['poll_id'] = 0;
    	} 
		
		if (isset($this->request->post['sort_order'])) {
      		$data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($article_info)) {
      		$data['sort_order'] = $article_info['sort_order'];
    	} else {
			$data['sort_order'] = 999;
		}
		if (isset($this->request->post['date_added'])) {
			$data['date_added'] = $this->request->post['date_added'];
		} elseif (!empty($article_info)) {
			$data['date_added'] = $article_info['date_added'];
		} else {
			$data['date_added'] = date('Y-m-d h:i:s A');
		}		
    	if (isset($this->request->post['status'])) {
      		$data['status'] = $this->request->post['status'];
    	} elseif (!empty($article_info)) {
			$data['status'] = $article_info['status'];
		} else {
      		$data['status'] = 1;
    	}

		/*downloads*/ 
		$this->load->model('avethemes/download');
		if (isset($this->request->post['article_download'])) {
			$article_downloads = $this->request->post['article_download'];
		} elseif (!empty($article_info)) {
			$article_downloads = explode(',', $article_info['article_download']);
		} else {
			$article_downloads = array();
		}
		$data['downloads'] = array();
		
		foreach ($article_downloads as $download_id) {
			$download_info = $this->model_avethemes_download->getDownload($download_id);
			
			if ($download_info) {
				$data['downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}	
		/*article_image*/ 
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
	
	
		
		if (isset($this->request->post['article_image'])) {
			$article_images = $this->request->post['article_image'];
		} elseif (isset($this->request->get['article_id'])) {
			$article_images = $this->model_avethemes_article->getArticleImages($this->request->get['article_id']);	
		} else {
			$article_images = array();
		}
		
		$data['article_images'] = array();
		
		foreach ($article_images as $article_image) {
		
			if ($article_image['image'] && file_exists(DIR_IMAGE . $article_image['image'])) {
				$image = $article_image['image'];
			} else {
				$image = 'no_image.png';
			}			
			
			$data['article_images'][] = array(
				'description' => $article_image['description'],
				'image'                    => $image,
				'sort_order'                     => $article_image['sort_order'],
				'thumb'                    => $this->model_tool_image->resize($image, 100, 100)
			);	
		} 
		
		
		/*category*/ 				
		$this->load->model('avethemes/category');	
		
		if (isset($this->request->post['article_category'])) {
			$categories = $this->request->post['article_category'];
		} elseif (isset($this->request->get['article_id'])) {		
			$categories = $this->model_avethemes_article->getArticleCategories($this->request->get['article_id']);
		} else {
			$categories = array();
		}	
		$data['article_categories'] = array();		
		foreach ($categories as $content_id) {
			$category_info = $this->model_avethemes_category->getCategory($content_id);
			
			if ($category_info) {			
				$category_name = $this->model_avethemes_category->getPath($category_info['content_id']);
				$data['article_categories'][] = array(
					'content_id' => $category_info['content_id'],
					'name'        => $category_name
				);
			}
		}

		/*service*/ 				
		$this->load->model('avethemes/service');	
		
		if (isset($this->request->post['article_service'])) {
			$services = $this->request->post['article_service'];
		} elseif (!empty($article_info)) {				
			$services = explode(',', $article_info['article_service']);
		} else {
			$services = array();
		}	
		$data['article_services'] = array();		
		foreach ($services as $service_id) {
			$service_info = $this->model_avethemes_service->getService($service_id);
			
			if ($service_info) {			
				$service_name = $this->model_avethemes_service->getPath($service_info['service_id']);
				$data['article_services'][] = array(
					'service_id' => $service_info['service_id'],
					'name'        => $service_name
				);
			}
		}
		
		/*related_article*/ 		
		if (isset($this->request->post['related_article'])) {
			$articles = $this->request->post['related_article'];
		} elseif (isset($this->request->get['article_id'])) {		
			$articles = $this->model_avethemes_article->getArticleRelated($this->request->get['article_id']);
		} else {
			$articles = array();
		}
	
		$data['related_article'] = array();
		foreach ($articles as $article_id) {
			$related_article_info = $this->model_avethemes_article->getArticle($article_id);
			
			if ($related_article_info) {
				$data['related_article'][] = array(
					'article_id' => $related_article_info['article_id'],
					'name'       => $related_article_info['name']
				);
			}
		}
		
		/*related_product*/ 
		if (isset($this->request->post['related_product'])) {
			$products = $this->request->post['related_product'];
		} elseif (isset($this->request->get['article_id'])) {		
			$products = $this->model_avethemes_article->getProductRelated($this->request->get['article_id']);
		} else {
			$products = array();
		}
	
		$data['related_product'] = array();
			$this->load->model('catalog/product');
		foreach ($products as $product_id) {
			$related_product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_product_info) {
				$data['related_product'][] = array(
					'product_id' => $related_product_info['product_id'],
					'name'       => $related_product_info['name']
				);
			}
		}
		/*Layout*/ 
		
		if (isset($this->request->post['article_layout'])) {
			$data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_layout'] = $this->model_avethemes_article->getArticleLayouts($this->request->get['article_id']);
		} else {
			$data['article_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
										
		$data['setcolors'] = $this->ave->getColors();
		
		$data['ave_cms_blog_details_image_width'] = $this->config->get('ave_cms_blog_details_image_width');
		$data['ave_cms_blog_details_image_height'] = $this->config->get('ave_cms_blog_details_image_height');
		$data['ave_cms_project_details_image_width'] = $this->config->get('ave_cms_project_details_image_width');
		$data['ave_cms_project_details_image_height'] = $this->config->get('ave_cms_project_details_image_height');
		$data['ave_cms_gallery_details_image_width'] = $this->config->get('ave_cms_gallery_details_image_width');
		$data['ave_cms_gallery_details_image_height'] = $this->config->get('ave_cms_gallery_details_image_height');
		
		$this_template = 'avethemes/content/article_form.tpl';
				$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
  	} 
	
  	private function validateForm() { 
	
    	if (!$this->user->hasPermission('modify', 'ave/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['article_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_title');
      		}
    	}
    	
    	if ($this->request->post['author_id']==0) {
      		$this->error['author'] = $this->language->get('error_author');
    	}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		/*SEO Keyword*/ 
		if (isset($this->request->post['article_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeywordByObjectID($this->request->post['keyword'],'article_id',$this->request->post['article_id']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}				
		}elseif (!isset($this->request->post['article_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeyword($this->request->post['keyword']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}	
		}		
		/*SEO Keyword*/ 	
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'ave/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'ave/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_content_category'])) {
			$this->load->model('avethemes/article');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
						
			if (isset($this->request->get['filter_content_category'])) {
				$filter_content_category = $this->request->get['filter_content_category'];
			} else {
				$filter_content_category = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$filter_data = array(
				'filter_name'         => $filter_name,
				'filter_content_category'  => $filter_content_category,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_avethemes_article->getArticles($filter_data);
			
			foreach ($results as $result) {					
				$json[] = array(
					'article_id' => $result['article_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function product_autocomplete() {
	
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])|| isset($this->request->get['filter_store'])) {
			$this->load->model('avethemes/global');
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['filter_store'])) {
				$filter_store = $this->request->get['filter_store'];
			} else {
				$filter_store = 0;
			}
			
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_store'  => $filter_store,
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_avethemes_global->getProducts($data);
			
			foreach ($results as $result) {				
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'price'      => $result['price']
				);	
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	
	}	
}
?>