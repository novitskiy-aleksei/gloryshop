<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentQuote extends Controller {
	private $error = array(); 
	    
  	public function index() {
		$language_data = $this->load->language('avethemes/quote');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
			$data['ave'] = $this->ave;
		$this->load->model('avethemes/service');
		
		$data['services'] = array();
			$services = $this->model_avethemes_service->getServices(0);
					
			foreach ($services as $service) {								
				$data['services'][] = array(	
					'service_id'  => $service['service_id'],
					'name'  => strip_tags(html_entity_decode($service['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_avethemes_service->addQuote($this->request->post);		
	  		$this->response->redirect($this->url->link('content/quote/success'));
    	}
      	$data['breadcrumbs'] = array();
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),	
        	'separator' => false
      	);
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('content/quote'),
        	'separator' => $this->language->get('text_separator')

      	);	

			

    	$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

    	$data['text_your_information'] = $this->language->get('text_your_information');
    	$data['text_friend_information'] = $this->language->get('text_friend_information');
    	$data['text_message'] = $this->language->get('text_message');
		
    	$data['entry_your_fullname'] = $this->language->get('entry_your_fullname');
    	$data['entry_your_fullname'] = $this->language->get('entry_your_fullname');
		$data['entry_your_telephone'] = $this->language->get('entry_your_telephone');
		$data['entry_your_email'] = $this->language->get('entry_your_email');
		
    	$data['entry_friend_fullname'] = $this->language->get('entry_friend_fullname');
		$data['entry_friend_telephone'] = $this->language->get('entry_friend_telephone');
		$data['entry_friend_email'] = $this->language->get('entry_friend_email');
		
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['entry_message'] = $this->language->get('entry_message');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		

		/*Customer*/ 
		if (isset($this->error['name'])) {
    		$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}		
		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['service_selection'])) {
			$data['error_service_selection'] = $this->error['service_selection'];
		} else {
			$data['error_service_selection'] = '';
		}	
		if (isset($this->error['budget'])) {
			$data['error_budget'] = $this->error['budget'];
		} else {
			$data['error_budget'] = '';
		}	
		
/*message*/ 
		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
		}		
				
 		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}	
		
    	$data['back'] = $this->url->link('common/home');
    	$data['button_continue'] = $this->language->get('button_continue');
		$data['action'] = $this->url->link('content/quote');

		$data['store'] = $this->config->get('config_name');
		
		if (isset($this->request->post['service_selection'])) {
			$service_selection = $this->request->post['service_selection'];
		}elseif(isset($quote_info)){				
			$service_selection =  explode(',', $quote_info['service_selection']);
		}else {
			$service_selection = array();
		}	
		$data['selections'] =  $this->model_avethemes_service->getServiceGroup($service_selection);
		
		if (isset($this->request->post['service_selection'])) {
			$data['service_selection'] = $this->request->post['service_selection'];
		} else {
			$data['service_selection'] = array();
		}
	
		if (isset($this->request->post['budget'])) {
			$data['budget'] = $this->request->post['budget'];
		} else {
			$data['budget'] = '';
		}	
		
		/*customer*/ 
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}	
		
		
		
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}	
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}
		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} else {
			$data['company'] = '';
		}
		if (isset($this->request->post['competence'])) {
			$data['competence'] = $this->request->post['competence'];
		} else {
			$data['competence'] = '';
		}

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} else {
			$data['message'] = '';
		}	

		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}		
			
		$budgets = $this->config->get('request_quote_budgets');
		if(is_array($budgets)){
			$data['budgets'] = $budgets;
		}else{
			$data['budgets'] = unserialize('a:9:{i:0;a:2:{s:5:"value";s:1:"0";s:5:"label";s:9:"- None - ";}i:1;a:2:{s:5:"value";s:3:"200";s:5:"label";s:13:"Less than 200";}i:2;a:2:{s:5:"value";s:3:"300";s:5:"label";s:11:"$200 - $300";}i:3;a:2:{s:5:"value";s:3:"500";s:5:"label";s:11:"$300 - $500";}i:4;a:2:{s:5:"value";s:4:"1000";s:5:"label";s:12:"$500 - $1000";}i:5;a:2:{s:5:"value";s:4:"2000";s:5:"label";s:13:"$1000 - $2000";}i:6;a:2:{s:5:"value";s:4:"5000";s:5:"label";s:13:"$2000 - $5000";}i:7;a:2:{s:5:"value";s:5:"10000";s:5:"label";s:14:"$5000 - $10000";}i:8;a:2:{s:5:"value";s:7:"notsure";s:5:"label";s:15:"Not sure yet...";}}');			
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/service/quote.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/service/quote.tpl';
		} else {
			$this_template = 'default/avethemes/template/service/quote.tpl';
		}
 		$this->response->setOutput($this->load->view($this_template, $data));		
  	}

  	public function success() {
		$this->load->language('avethemes/quote');

		$this->document->setTitle($this->language->get('heading_title')); 

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('content/quote'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$data['heading_title'] = $this->language->get('heading_title');

    	$data['text_message'] = $this->language->get('text_success_message');

    	$data['button_continue'] = $this->language->get('button_continue');

    	$data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this_template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this_template = 'default/template/common/success.tpl';
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
 		$this->response->setOutput($this->load->view($this_template, $data)); 
	}
	
  	private function validate() {
		/*customer*/ 
    	if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}
    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
    	if ($this->request->post['budget']==0) {
      		$this->error['budget'] = $this->language->get('error_budget');
    	}
    	if (!isset($this->request->post['service_selection'])) {
      		$this->error['service_selection'] = $this->language->get('error_service');
    	}
		/*message*/ 
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 1500)) {
      		$this->error['message'] = $this->language->get('error_message');
    	}
		if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {	
			$this->error['captcha'] = $this->language->get('error_captcha');	
		}
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  	  
  	}
}
?>
