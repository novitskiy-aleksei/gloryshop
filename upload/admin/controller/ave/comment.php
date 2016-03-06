<?php
class ControllerAveComment extends Controller {
	private $error = array();
	
	public function index() {
		$this->getList();
	} 

	public function insert() {
		$language_data = $this->load->language('avethemes/comment');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_comment->addComment($this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$language_data = $this->load->language('avethemes/comment');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_comment->editComment($this->request->get['comment_id'], $this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$language_data = $this->load->language('avethemes/comment');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $comment_id) {
				$this->model_avethemes_comment->deleteComment($comment_id);
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
						
			$this->response->redirect($this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {		
				
		$language_data = $this->load->language('avethemes/comment');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/comment');
		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
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
			'href'      => $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$data['insert'] = $this->url->link('ave/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['comments'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$comment_total = $this->model_avethemes_comment->getTotalComments();
	
		$results = $this->model_avethemes_comment->getComments($filter_data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'] . $url, 'SSL')
			);
						
			$data['comments'][] = array(
				'comment_id'  => $result['comment_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
				'rating'     => $result['rating'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['comment_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_error_install']=$this->language->get('text_error_install');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_article'] = $this->language->get('column_article');
		$data['column_author'] = $this->language->get('column_author');
		$data['column_rating'] = $this->language->get('column_rating');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');		
		
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
 
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
		
		$data['sort_article'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_author'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . '&sort=r.author' . $url, 'SSL');
		$data['sort_rating'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($comment_total - $this->config->get('config_limit_admin'))) ? $comment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $comment_total, ceil($comment_total / $this->config->get('config_limit_admin')));
	

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/content/comment_list.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function getForm() {
		$language_data = $this->load->language('avethemes/comment');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
 		
		if (isset($this->error['article'])) {
			$data['error_article'] = $this->error['article'];
		} else {
			$data['error_article'] = '';
		}
		
 		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}
		
 		if (isset($this->error['text'])) {
			$data['error_text'] = $this->error['text'];
		} else {
			$data['error_text'] = '';
		}
		
 		if (isset($this->error['rating'])) {
			$data['error_rating'] = $this->error['rating'];
		} else {
			$data['error_rating'] = '';
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
			'href'      => $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['comment_id'])) { 
			$data['action'] = $this->url->link('ave/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$comment_info = $this->model_avethemes_comment->getComment($this->request->get['comment_id']);
		}
		
		$data['token'] = $this->session->data['token'];
			
		$this->load->model('avethemes/article');
		
		if (isset($this->request->post['article_id'])) {
			$data['article_id'] = $this->request->post['article_id'];
		} elseif (!empty($comment_info)) {
			$data['article_id'] = $comment_info['article_id'];
		} else {
			$data['article_id'] = '';
		}

		if (isset($this->request->post['article_name'])) {
			$data['article_name'] = $this->request->post['article_name'];
		} elseif (!empty($comment_info)) {
			$data['article_name'] = $comment_info['article'];
		} else {
			$data['article_name'] = '';
		}
				
		if (isset($this->request->post['author'])) {
			$data['author'] = $this->request->post['author'];
		} elseif (!empty($comment_info)) {
			$data['author'] = $comment_info['author'];
		} else {
			$data['author'] = '';
		}

		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} elseif (!empty($comment_info)) {
			$data['text'] = $comment_info['text'];
		} else {
			$data['text'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($comment_info)) {
			$data['rating'] = $comment_info['rating'];
		} else {
			$data['rating'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$data['status'] = $comment_info['status'];
		} else {
			$data['status'] = '';
		}

		$this_template = 'avethemes/content/comment_form.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	private function validateForm() {
	
		if (!$this->user->hasPermission('modify', 'ave/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['article_id']) {
			$this->error['article'] = $this->language->get('error_article');
		}
		
		if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
				
		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ave/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
}
?>