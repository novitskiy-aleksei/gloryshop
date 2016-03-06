<?php 
class ControllerAveService extends Controller { 
	private $error = array();
	public function index() {		 
		$this->getList();
	}

	public function insert() {
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/service');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_service->addService($this->request->post);

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
			
			$this->response->redirect($this->url->link('ave/service', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/service');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_service->editService($this->request->get['service_id'], $this->request->post);
			
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
			
			$this->response->redirect($this->url->link('ave/service', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/service');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $service_id) {
				$this->model_avethemes_service->deleteService($service_id);
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

			$this->response->redirect($this->url->link('ave/service', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	
	private function getList() {
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/service');
		
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
			'href'      => $this->url->link('ave/service', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$data['insert'] = $this->url->link('ave/service/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/service/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['services'] = array();
	
		$service_total = $this->model_avethemes_service->getTotalServices();
		
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$results = $this->model_avethemes_service->filterServices($filter_data);

		$this->load->model('avethemes/category');		
		$data['categories'] = $this->model_avethemes_category->getCategories(0);
		
		$this->load->model('tool/image');
		foreach ($results as $result) {			
			$service_name = $this->model_avethemes_service->getPath($result['service_id']);
			$this->load->model('avethemes/article');
			$article_total = ' (' . $this->model_avethemes_article->getTotalArticles(array('filter_service_group'  => $result['service_id'])).')' ;
			$action = array();			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'target' => '_self',			
				'href' => $this->url->link('ave/service/update', 'service_id=' . $result['service_id'].'&token=' . $this->session->data['token'] . $url, 'SSL')
			);
			$action[] = array(
				'text' => $this->language->get('text_filter'),
				'target' => '_self',				
				'href' => $this->url->link('ave/article', 'filter_service_group=' . $result['service_id'].'&token=' . $this->session->data['token'] . $url, 'SSL')
			);
			
			$href = false;
			if(!empty($result['link_id'])){
				$href = HTTP_CATALOG.'index.php?route=content/category&content_id=' . $result['link_id'];
			}
							
			$data['services'][] = array(
				'service_id' => $result['service_id'],
				'link_id' => $result['link_id'],
				'href' => $href,
				'total'        => $article_total,
				'name'        => $service_name,
				'icon'      => $result['icon'],
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['service_id'], $this->request->post['selected']),
				'action'      => $action
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
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $service_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/service', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
$data['results'] = sprintf($this->language->get('text_pagination'), ($service_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($service_total - $this->config->get('config_limit_admin'))) ? $service_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $service_total, ceil($service_total / $this->config->get('config_limit_admin')));

		$this_template = 'avethemes/service/service_list.tpl';
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function getForm() {
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
			
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	
 		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
 		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/service', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['service_id'])) {
			$data['action'] = $this->url->link('ave/service/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/service/update',  'service_id=' . $this->request->get['service_id']. '&token=' . $this->session->data['token'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/service', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['service_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$service_info = $this->model_avethemes_service->getService($this->request->get['service_id']);
    	}
		
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['service_description'])) {
			$data['service_description'] = $this->request->post['service_description'];
		} elseif (isset($this->request->get['service_id'])) {
			$data['service_description'] = $this->model_avethemes_service->getServiceDescriptions($this->request->get['service_id']);
		} else {
			$data['service_description'] = array();
		}
		$this->load->model('avethemes/category');
		
		$categories = $this->model_avethemes_category->getCategories(0);

		// Remove own id from list
		if (!empty($category_info)) {
			foreach ($categories as $key => $category) {
				if ($category['content_id'] == $category_info['content_id']) {
					unset($categories[$key]);
				}
			}
		}

		$data['categories'] = $categories;
		
		$services = $this->model_avethemes_service->getServices(0);

		// Remove own id from list
		if (!empty($service_info)) {
			foreach ($services as $key => $service) {
				if ($service['service_id'] == $service_info['service_id']) {
					unset($services[$key]);
				}
			}
		}

		$data['services'] = $services;

		if (isset($this->request->get['service_id'])) {
			$data['service_id'] = $this->request->get['service_id'];
		} elseif (isset($this->request->post['service_id'])) {
			$data['service_id'] = $this->request->post['service_id'];
		} else{
			$data['service_id'] = FALSE;			
		}
		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($service_info)) {
			$data['parent_id'] = $service_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}
			
		if (isset($this->request->post['link_id'])) {
			$data['link_id'] = $this->request->post['link_id'];
		} elseif (!empty($service_info)) {
			$data['link_id'] = $service_info['link_id'];
		} else {
			$data['link_id'] = 0;
		}
					
		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['service_store'])) {
			$data['service_store'] = $this->request->post['service_store'];
		} elseif (isset($this->request->get['service_id'])) {
			$data['service_store'] = $this->model_avethemes_service->getServiceStores($this->request->get['service_id']);
		} else {
			$data['service_store'] = array(0);
		}			
				
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($service_info)) {
			$data['sort_order'] = $service_info['sort_order'];
		} else {
			$data['sort_order'] = 999;
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($service_info)) {
			$data['status'] = $service_info['status'];
		} else {
			$data['status'] = 1;
		}
		
		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($service_info)) {
			$data['color'] = $service_info['color'];
		} else {
			$data['color'] = 'blue-sky';
		}
		
		if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (!empty($service_info)) {
			$data['icon'] = $service_info['icon'];
		} else {
			$data['icon'] = '';
		}
					
		$data['setcolors'] = $this->ave->getColors();
			
		$this_template = 'avethemes/service/service_form.tpl';
		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'ave/service')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['service_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
			if ((utf8_strlen($value['description']) > 255)) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ave/service')) {
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
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('avethemes/service');
			
			$filter = array(
				'parent_id' => 0,
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_avethemes_service->filterServices($filter);
				
			foreach ($results as $result) {
				$json[] = array(
					'service_id' => $result['service_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}
?>