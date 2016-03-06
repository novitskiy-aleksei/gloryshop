<?php
class ControllerAveQuote extends Controller {
	private $error = array(); 
	public function index() {
		
		$this->getList();
	} 

	public function insert() {
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/quote');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_quote->addQuote($this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/quote');
		$this->model_avethemes_quote->setRead($this->request->get['quote_id']);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_quote->editQuote($this->request->get['quote_id'], $this->request->post);
			
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
						
			$this->response->redirect($this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/quote');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $quote_id) {
				$this->model_avethemes_quote->deleteQuote($quote_id);
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
						
			$this->response->redirect($this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {	
	
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {			
			$this->load->model('setting/setting');		
			$this->model_setting_setting->editSetting('request_quote',array('request_quote_budgets'=>$this->request->post['request_quote_budgets']));	
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->load->model('avethemes/quote');
		$this->load->model('avethemes/service');

		$this->document->setTitle($this->language->get('heading_title'));
		
		
		$this->load->model('avethemes/service');
		
		$data['services'] = $this->model_avethemes_service->getServices(0);	
		
		
		if (isset($this->request->post['request_quote_budgets'])) {
			$data['budgets'] = $this->request->post['request_quote_budgets'];
		} elseif ($this->config->get('request_quote_budgets')) { 
			$data['budgets'] = $this->config->get('request_quote_budgets');
		}else{
			$data['budgets'] = unserialize('a:9:{i:0;a:2:{s:5:"value";s:1:"0";s:5:"label";s:9:"- None - ";}i:1;a:2:{s:5:"value";s:3:"200";s:5:"label";s:13:"Less than 200";}i:2;a:2:{s:5:"value";s:3:"300";s:5:"label";s:11:"$200 - $300";}i:3;a:2:{s:5:"value";s:3:"500";s:5:"label";s:11:"$300 - $500";}i:4;a:2:{s:5:"value";s:4:"1000";s:5:"label";s:12:"$500 - $1000";}i:5;a:2:{s:5:"value";s:4:"2000";s:5:"label";s:13:"$1000 - $2000";}i:6;a:2:{s:5:"value";s:4:"5000";s:5:"label";s:13:"$2000 - $5000";}i:7;a:2:{s:5:"value";s:5:"10000";s:5:"label";s:14:"$5000 - $10000";}i:8;a:2:{s:5:"value";s:7:"notsure";s:5:"label";s:15:"Not sure yet...";}}');			
		}	
		
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
			'href'      => $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$data['insert'] = $this->url->link('ave/quote/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/quote/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['budget'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['quotes'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$quote_total = $this->model_avethemes_quote->getTotalQuotes();
	
		$results = $this->model_avethemes_quote->getQuotes($filter_data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/quote/update', 'token=' . $this->session->data['token'] . '&quote_id=' . $result['quote_id'] . $url, 'SSL')
			);
						
			$data['quotes'][] = array(
				'quote_id'  => $result['quote_id'],
				'customer_name'     => $result['customer_name'],
				'competence'     => $result['competence'],
				'service_selection'   =>  explode(',', $result['service_selection']),
				'budget'     => $result['budget'],
				'read'     => ($result['read'] ? $this->language->get('text_read') : $this->language->get('text_unread')),
				'status'     => ($result['status'] ? $this->language->get('text_processed') : $this->language->get('text_waiting')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['quote_id'], $this->request->post['selected']),
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
		$data['sort_customer'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . '&sort=r.customer_name' . $url, 'SSL');
		$data['sort_read'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . '&sort=r.read' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');
		
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
		$pagination->url = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
$data['results'] = sprintf($this->language->get('text_pagination'), ($quote_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($quote_total - $this->config->get('config_limit_admin'))) ? $quote_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $quote_total, ceil($quote_total / $this->config->get('config_limit_admin')));
	
		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/service/quote_list.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function getForm() {	
		
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		
		$this->load->model('setting/store');
		
		$this->load->model('avethemes/service');
		
			$data['services'] = array();
			$services = $this->model_avethemes_service->getServices(0);
				
			$data['services'][] = array(
				'service_id' => '0',
				'name'  => ' --None-- ',
			);	
			foreach ($services as $service) {								
				$data['services'][] = array(	
					'service_id'  => $service['service_id'],
					'name'  => strip_tags(html_entity_decode($service['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
			$data['budgets'] = $this->config->get('request_quote_budgets');
			
		$data['stores'] = $this->model_setting_store->getStores();
		
		$data['heading_title'] = $this->language->get('heading_title');
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
			'href'      => $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['quote_id'])) { 
			$data['action'] = $this->url->link('ave/quote/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$data['send'] = FALSE;
		} else {
			$data['action'] = $this->url->link('ave/quote/update', 'token=' . $this->session->data['token'].'&send_email=0&quote_id=' . $this->request->get['quote_id']. $url, 'SSL');			
			$data['send'] = $this->url->link('ave/quote/update', 'token=' . $this->session->data['token'] .'&send_email=1&quote_id=' . $this->request->get['quote_id']. $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/quote', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['quote_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$quote_info = $this->model_avethemes_quote->getQuote($this->request->get['quote_id']);
		}
		
		/*service*/ 	
		if (isset($this->request->post['service_selection'])) {
			$service_selection = $this->request->post['service_selection'];
		}elseif(isset($quote_info)){				
			$service_selection =  explode(',', $quote_info['service_selection']);
		}else {
			$service_selection = array();
		}	
		
		$data['service_selections'] =  $this->model_avethemes_service->getServiceGroup($service_selection);
		
		$data['token'] = $this->session->data['token'];
					
		if (isset($this->request->post['store_id'])) {
			$data['store_id'] = $this->request->post['store_id'];
		} else {
			$data['store_id'] = '';
		}
		/*service*/ 			
		if (isset($this->request->post['budget'])) {
			$data['budget'] = $this->request->post['budget'];
		}elseif(isset($quote_info)){				
			$data['budget'] =  $quote_info['budget'];
		}else {
			$data['budget'] = 0;
		}	
		/*customer*/ 
			
		if (isset($this->request->post['customer_name'])) {
			$data['customer_name'] = $this->request->post['customer_name'];
		} elseif (!empty($quote_info)) {
			$data['customer_name'] = $quote_info['customer_name'];
		} else {
			$data['customer_name'] = '';
		}
		if (isset($this->request->post['customer_telephone'])) {
			$data['customer_telephone'] = $this->request->post['customer_telephone'];
		} elseif (!empty($quote_info)) {
			$data['customer_telephone'] = $quote_info['customer_telephone'];
		} else {
			$data['customer_telephone'] = '';
		}
		if (isset($this->request->post['customer_email'])) {
			$data['customer_email'] = $this->request->post['customer_email'];
		} elseif (!empty($quote_info)) {
			$data['customer_email'] = $quote_info['customer_email'];
		} else {
			$data['customer_email'] = '';
		}
		
		if (isset($this->request->post['customer_company'])) {
			$data['customer_company'] = $this->request->post['customer_company'];
		} elseif (!empty($quote_info)) {
			$data['customer_company'] = $quote_info['customer_company'];
		} else {
			$data['customer_company'] = '';
		}
		if (isset($this->request->post['competence'])) {
			$data['competence'] = $this->request->post['competence'];
		} elseif (!empty($quote_info)) {
			$data['competence'] = $quote_info['competence'];
		} else {
			$data['competence'] = '';
		}
		
		
		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (!empty($quote_info)) {
			$data['message'] = $quote_info['message'];
		} else {
			$data['message'] = '';
		}

		if (isset($this->request->post['read'])) {
			$data['read'] = $this->request->post['read'];
		} elseif (!empty($quote_info)) {
			$data['read'] = $quote_info['read'];
		} else {
			$data['read'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($quote_info)) {
			$data['status'] = $quote_info['status'];
		} else {
			$data['status'] = '';
		}
		$this_template = 'avethemes/service/quote_form.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	private function validateSent() {
		if (!$this->user->hasPermission('modify', 'ave/quote')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		/**/ 		
		if ((utf8_strlen($this->request->post['customer_name']) < 1) || (utf8_strlen($this->request->post['customer_name']) > 64)) {
			$this->error['customer_name'] = $this->language->get('error_customer_name');
		}	
		if ((utf8_strlen($this->request->post['customer_telephone']) < 6) || (utf8_strlen($this->request->post['customer_telephone']) > 15)) {
      		$this->error['customer_telephone'] = $this->language->get('error_customer_telephone');
    	}
    	if ((utf8_strlen($this->request->post['customer_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['customer_email'])) {
      		$this->error['customer_email'] = $this->language->get('error_customer_email');
    	}
				
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 1024)) {
			$this->error['message'] = $this->language->get('error_message');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'ave/quote')) {
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
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'ave/quote')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ave/quote')) {
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