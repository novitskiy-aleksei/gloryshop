<?php
class ControllerAveTestimonial extends Controller {
	private $error = array(); 
	public function index() {
		$this->getList();
	} 

	public function insert() {
		$language_data = $this->load->language('avethemes/testimonial');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/testimonial');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_testimonial->addTestimonial($this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$language_data = $this->load->language('avethemes/testimonial');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/testimonial');
		$this->model_avethemes_testimonial->setRead($this->request->get['testimonial_id']);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_testimonial->editTestimonial($this->request->get['testimonial_id'],$this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$language_data = $this->load->language('avethemes/testimonial');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/testimonial');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $testimonial_id) {
				$this->model_avethemes_testimonial->deleteTestimonial($testimonial_id);
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
						
			$this->response->redirect($this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
		$language_data = $this->load->language('avethemes/testimonial');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->load->model('avethemes/testimonial');
		$this->load->model('avethemes/service');

		$this->document->setTitle($this->language->get('heading_title'));
		
		
		$this->load->model('avethemes/service');
		
		$data['services'] = $this->model_avethemes_service->getServices(0);	
		
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
			'href'      => $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$data['insert'] = $this->url->link('ave/testimonial/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/testimonial/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['testimonials'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$quote_total = $this->model_avethemes_testimonial->getTotalTestimonials();
	
		$results = $this->model_avethemes_testimonial->getTestimonials($filter_data);
 
			$this->load->model('tool/image');
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/testimonial/update', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $result['testimonial_id'] . $url, 'SSL')
			);
			if ($result['avatar'] && file_exists(DIR_IMAGE . $result['avatar'])) {
				$avatar = $this->model_tool_image->resize($result['avatar'], 64, 64);
			} else {
				$avatar = $this->model_tool_image->resize('no_image.png', 64, 64);
			}	
			$service_selection = 	$this->model_avethemes_testimonial->getTestimonialServices($result['testimonial_id']);	
			$data['testimonials'][] = array(
				'testimonial_id'  => $result['testimonial_id'],
				'competence'     => $result['competence'],
				'customer_name'     => $result['customer_name'],
				'rating'     => $result['rating'],
				'status'     =>($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'avatar'     => $avatar,
				'service_selection'   =>  $service_selection,
				'read'     => ($result['read'] ? $this->language->get('text_read') : $this->language->get('text_unread')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['testimonial_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$data['text_warning'] = sprintf($this->language->get('text_warning'),$this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL'));
 
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
		$data['sort_customer'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.customer_name' . $url, 'SSL');
		$data['sort_service'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.service_id' . $url, 'SSL');
		$data['sort_read'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.read' . $url, 'SSL');
		$data['sort_rating'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $quote_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

$data['results'] = sprintf($this->language->get('text_pagination'), ($quote_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($quote_total - $this->config->get('config_limit_admin'))) ? $quote_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $quote_total, ceil($quote_total / $this->config->get('config_limit_admin')));
	

		$data['sort'] = $sort;
		$data['order'] = $order;

		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$this_template = 'avethemes/service/testimonial_list.tpl';
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function getForm() {	
		$language_data = $this->load->language('avethemes/service');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$this->load->model('setting/store');
		
		$this->load->model('avethemes/service');
		
			$data['services'] = array();
			
			$services = $this->model_avethemes_service->getServices(0);
			
			$data['services'][] = array(
				'service_id' => '0',
				'name'  => ' --None-- ',
				'name_sub'  => ' --None-- ',
			);
			foreach ($services as $service) {								
				$data['services'][] = array(	
					'service_id'  => $service['service_id'],
					'name'  => strip_tags(html_entity_decode($service['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		$data['text_warning'] = sprintf($this->language->get('text_warning'),$this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL'));

		

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		/*customer*/ 
 		if (isset($this->error['customer_name'])) {
			$data['error_customer_name'] = $this->error['customer_name'];
		} else {
			$data['error_customer_name'] = '';
		}
 		if (isset($this->error['customer_telephone'])) {
			$data['error_customer_telephone'] = $this->error['customer_telephone'];
		} else {
			$data['error_customer_telephone'] = '';
		}
 		if (isset($this->error['customer_email'])) {
			$data['error_customer_email'] = $this->error['customer_email'];
		} else {
			$data['error_customer_email'] = '';
		}
				
 		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
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
			'href'      => $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['testimonial_id'])) { 
			$data['action'] = $this->url->link('ave/testimonial/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$data['send'] = FALSE;
		} else {
			$data['action'] = $this->url->link('ave/testimonial/update', 'token=' . $this->session->data['token'].'&send_email=0&testimonial_id=' . $this->request->get['testimonial_id']. $url, 'SSL');			
			$data['send'] = $this->url->link('ave/testimonial/update', 'token=' . $this->session->data['token'] .'&send_email=1&testimonial_id=' . $this->request->get['testimonial_id']. $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['testimonial_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$testimonial_info = $this->model_avethemes_testimonial->getTestimonial($this->request->get['testimonial_id']);
		}
		
		if (isset($this->request->post['avatar'])) {
			$data['avatar'] = $this->request->post['avatar'];
		} elseif (!empty($testimonial_info)) {
			$data['avatar'] = $testimonial_info['avatar'];
		} else {
			$data['avatar'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['avatar']) && file_exists(DIR_IMAGE . $this->request->post['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['avatar'], 100, 100);
		} elseif (!empty($testimonial_info) && $testimonial_info['avatar'] && file_exists(DIR_IMAGE . $testimonial_info['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($testimonial_info['avatar'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['store_id'])) {
			$data['store_id'] = $this->request->post['store_id'];
		} else {
			$data['store_id'] = '';
		}
		/*service*/ 	
		if (isset($this->request->post['service_selection'])) {
			$service_selection = $this->request->post['service_selection'];
		}elseif(isset($testimonial_info)){				
			$service_selection =  $this->model_avethemes_testimonial->getTestimonialServices($testimonial_info['testimonial_id']);
		}else {
			$service_selection = array();
		}	
		
		$data['service_selections'] =  $this->model_avethemes_service->getServiceGroup($service_selection);
			
		/*customer*/ 
		if (isset($this->request->post['customer_name'])) {
			$data['customer_name'] = $this->request->post['customer_name'];
		} elseif (!empty($testimonial_info)) {
			$data['customer_name'] = $testimonial_info['customer_name'];
		} else {
			$data['customer_name'] = '';
		}
		if (isset($this->request->post['customer_telephone'])) {
			$data['customer_telephone'] = $this->request->post['customer_telephone'];
		} elseif (!empty($testimonial_info)) {
			$data['customer_telephone'] = $testimonial_info['customer_telephone'];
		} else {
			$data['customer_telephone'] = '';
		}
		if (isset($this->request->post['customer_email'])) {
			$data['customer_email'] = $this->request->post['customer_email'];
		} elseif (!empty($testimonial_info)) {
			$data['customer_email'] = $testimonial_info['customer_email'];
		} else {
			$data['customer_email'] = '';
		}
		
		if (isset($this->request->post['customer_company'])) {
			$data['customer_company'] = $this->request->post['customer_company'];
		} elseif (!empty($testimonial_info)) {
			$data['customer_company'] = $testimonial_info['customer_company'];
		} else {
			$data['customer_company'] = '';
		}
		
		if (isset($this->request->post['competence'])) {
			$data['competence'] = $this->request->post['competence'];
		} elseif (!empty($testimonial_info)) {
			$data['competence'] = $testimonial_info['competence'];
		} else {
			$data['competence'] = '';
		}
		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (!empty($testimonial_info)) {
			$data['message'] = $testimonial_info['message'];
		} else {
			$data['message'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($testimonial_info)) {
			$data['rating'] = $testimonial_info['rating'];
		} else {
			$data['rating'] = '';
		}

		if (isset($this->request->post['read'])) {
			$data['read'] = $this->request->post['read'];
		} elseif (!empty($testimonial_info)) {
			$data['read'] = $testimonial_info['read'];
		} else {
			$data['read'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($testimonial_info)) {
			$data['status'] = $testimonial_info['status'];
		} else {
			$data['status'] = '';
		}
			
			
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this_template = 'avethemes/service/testimonial_form.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'ave/testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		/**/ 
		
		if ((utf8_strlen($this->request->post['customer_name']) < 1) || (utf8_strlen($this->request->post['customer_name']) > 64)) {
			$this->error['customer_name'] = $this->language->get('error_customer_name');
		}
		
    	if ((utf8_strlen($this->request->post['customer_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['customer_email'])) {
      		$this->error['customer_email'] = $this->language->get('error_customer_email');
    	}
		/**/ 	
		
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 3000)) {
			$this->error['message'] = $this->language->get('error_message');
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
		if (!$this->user->hasPermission('modify', 'ave/testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
	public function autocomplete(){
		$json=array();
    	if(isset($this->request->get['filter_name'])){
			$this->load->model('avethemes/testimonial');
		$filter_data =array(
				'filter_name' =>$this->request->get['filter_name'],
				'start'       =>0,
				'limit'       =>20
			);
		$json=array();
		$results=$this->model_avethemes_testimonial->getTestimonials($filter_data);
		foreach($results as $result){
				$json[]=array(
					'testimonial_id'            =>$result['testimonial_id'],
					'name'            =>$result['customer_name'].'-'.utf8_substr(strip_tags(html_entity_decode($result['message'], ENT_QUOTES, 'UTF-8')), 0, 64) . '..',
				);		
			}		
		}
			$sort_order=array();
		foreach($json as $key =>$value){
			$sort_order[$key]=$value['name'];
		}

		array_multisort($sort_order, SORT_ASC,$json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}
?>