<?php    
class ControllerAveAuthor extends Controller { 
	private $error = array();
	public function index() {		
    	$this->getList();
  	}
  
  	public function insert() {
		$author_lang = $this->load->language('avethemes/author');
		foreach($author_lang as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/author');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_author->addAuthor($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
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
			
			$this->response->redirect($this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		$author_lang = $this->load->language('avethemes/author');
		foreach($author_lang as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/author');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_author->editAuthor($this->request->get['author_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			$this->response->redirect($this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$author_lang = $this->load->language('avethemes/author');
		foreach($author_lang as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/author');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $author_id) {
				$this->model_avethemes_author->deleteAuthor($author_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
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
			
			$this->response->redirect($this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}  
    
  	private function getList() {
		$author_lang = $this->load->language('avethemes/author');
		foreach($author_lang as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('avethemes/author');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'author';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
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

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$data['insert'] = $this->url->link('ave/author/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/author/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['authors'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$author_total = $this->model_avethemes_author->getTotalAuthors();
	
		$results = $this->model_avethemes_author->getAuthors($filter_data);
 
			$this->load->model('tool/image');
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'target' => '_self',			
				'href' => $this->url->link('ave/author/update', 'token=' . $this->session->data['token'] . '&author_id=' . $result['author_id'] . $url, 'SSL')
			);
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'target' => '_blank',				
				'href' => HTTP_CATALOG.'index.php?route=content/author/info&author_id='.$result['author_id']
			);
			$action[] = array(
				'text' => $this->language->get('text_filter'),
				'target' => '_self',				
				'href' => $this->url->link('ave/article', 'token=' . $this->session->data['token'] . '&filter_author=' . $result['author_id'].$url, 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 64, 64);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 64, 64);
			}			
			$data['authors'][] = array(
				'author_id' => $result['author_id'],
				'author'            => $result['author'],
				'image'      => $image,
				'sort_order'      => $result['sort_order'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['author_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}	
 
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_author'] = $this->url->link('ave/author', 'token=' . $this->session->data['token'] . '&sort=author' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('ave/author', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $author_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

$data['results'] = sprintf($this->language->get('text_pagination'), ($author_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($author_total - $this->config->get('config_limit_admin'))) ? $author_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $author_total, ceil($author_total / $this->config->get('config_limit_admin')));
	

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/content/author_list.tpl';
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
  
  	private function getForm() {
		$author_lang = $this->load->language('avethemes/author');
		foreach($author_lang as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


 		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}
		
 		if (isset($this->error['competence'])) {
			$data['error_competence'] = $this->error['competence'];
		} else {
			$data['error_competence'] = '';
		}
		
 		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		   
 		if (isset($this->error['author_description'])) {
			$data['error_description'] = $this->error['author_description'];
		} else {
			$data['error_description'] = '';
		} 
		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		} 
		   
		if (isset($this->error['link'])) {
			$data['error_link'] = $this->error['link'];
		} else {
			$data['error_link'] = array();
		} 
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
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['author_id'])) {
			$data['action'] = $this->url->link('ave/author/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/author/update', 'token=' . $this->session->data['token'] . '&author_id=' . $this->request->get['author_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/author', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['author_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$author_info = $this->model_avethemes_author->getAuthor($this->request->get['author_id']);
    	}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['author_id'])) {
			$data['author_id'] = $this->request->get['author_id'];
		} elseif (isset($this->request->post['author_id'])) {
			$data['author_id'] = $this->request->post['author_id'];
		} else{
			$data['author_id'] = FALSE;			
		}
		
    	if (isset($this->request->post['author'])) {
      		$data['author'] = $this->request->post['author'];
    	} elseif (!empty($author_info)) {
			$data['author'] = $author_info['author'];
		} else {	
      		$data['author'] = '';
    	}
		
    	if (isset($this->request->post['competence'])) {
      		$data['competence'] = $this->request->post['competence'];
    	} elseif (!empty($author_info)) {
			$data['competence'] = $author_info['competence'];
		} else {	
      		$data['competence'] = '';
    	}
		
    	if (isset($this->request->post['socials'])) {
      		$data['socials'] = $this->request->post['socials'];
    	} elseif (!empty($author_info)) {
			$data['socials'] = json_decode($author_info['socials'], true);
		} else {	
      		$data['socials'] = array(
									0 => array (
											'social' => 'fa fa-facebook',
											'title' => 'Facebook',
											'href' => 'https://www.facebook.com',
											'target' => '_blank',
										),
								
									1 => array (
											'social' => 'fa fa-google-plus',
											'title' => 'Google Plus',
											'href' => 'https://plus.google.com',
											'target' => '_blank'
										),
								
									2 => array (
											'social' => 'fa fa-instagram',
											'title' => 'Instagram',
											'href' => 'http://instagram.com',
											'target' => '_blank'
										),
								
									3 => array (
											'social' => 'fa fa-dropbox',
											'title' => 'Dropbox',
											'href' => 'http://www.dropbox.com',
											'target' => '_blank',
										),
								
									4=> array (
											'social' => 'fa fa-pinterest-square',
											'title' => 'Pinterest',
											'href' => 'http://www.pinterest.com',
											'target' => '_blank',
										),
								
									5 => array (
											'social' => 'fa fa-youtube-square',
											'title' => 'Youtube',
											'href' => 'http://www.youtube.com',
											'target' => '_blank'
										)

		);
    	} 
			
			
    	if (isset($this->request->post['author_description'])) {
      		$data['author_description'] = $this->request->post['author_description'];
    	} elseif (!empty($author_info)) { 
			$data['author_description'] = $author_info['author_description'];
		} else {
      		$data['author_description'] = '';
    	}
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($author_info)) {
			$data['keyword'] = $author_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($author_info)) {
			$data['image'] = $author_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($author_info) && $author_info['image'] && file_exists(DIR_IMAGE . $author_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($author_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['sort_order'])) {
      		$data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($author_info)) {
			$data['sort_order'] = $author_info['sort_order'];
		} else {
      		$data['sort_order'] = '';
    	}
		
		$this_template = 'avethemes/content/author_form.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}  
	 
  	private function validateForm() {
	
    	if (!$this->user->hasPermission('modify', 'ave/author')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
      		$this->error['author'] = $this->language->get('error_author');
    	}
    	if ((utf8_strlen($this->request->post['competence']) < 3) || (utf8_strlen($this->request->post['competence']) > 64)) {
      		$this->error['competence'] = $this->language->get('error_competence');
    	}
		
		/*SEO Keyword*/ 
		$this->load->model('avethemes/article');
		if (isset($this->request->post['author_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeywordByObjectID($this->request->post['keyword'],'author_id',$this->request->post['author_id']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}				
		}elseif (!isset($this->request->post['author_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeyword($this->request->post['keyword']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}	
		}	
		
		
		if (isset($this->request->post['socials'])) {
			foreach ($this->request->post['socials'] as $key => $value) {
				if (!$value['href']) {
					$this->error['link'][$key] = $this->language->get('error_link_empty');
				}		
				if (!$value['title']) {
					$this->error['title'][$key] = $this->language->get('error_title_empty');
				}			
			}
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'ave/author')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	}	
		
		$this->load->model('avethemes/article');

		foreach ($this->request->post['selected'] as $author_id) {
  			$article_total = $this->model_avethemes_article->getTotalArticlesByAuthorId($author_id);
    
			if ($article_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_article'), $article_total);	
			}	
	  	} 
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	}
}
?>