<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesNewsletter extends Controller {
	public function index($setting=array()){	
		if(defined('ave_check')){
		$data['ave'] = $this->ave;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		static $module = 0;
		
			$language_id 	= $this->config->get('config_language_id');
			
			$data['custom_message'] = html_entity_decode($setting['custom_message'][$language_id], ENT_QUOTES, 'UTF-8');
			
	   	$this->document->addScript('assets/theme/js/newsletter.js');	
		 
	   	$this->load->model('avethemes/newsletter');	 
		$this->load->language('avethemes/global_lang');

      	$data['subscribe_title'] = $this->language->get('subscribe_title');	
		
      	$data['entry_name'] = $this->language->get('entry_name');	
      	$data['entry_email'] = $this->language->get('entry_email');	
		
      	$data['entry_button'] = $this->language->get('entry_button');	
		
      	$data['entry_unbutton'] = $this->language->get('entry_unbutton');	
		
      	$data['ave_newsletter_unsubscribe'] = $this->config->get('ave_newsletter_unsubscribe');	
		
		
		$data['text_subscribe'] = $this->language->get('text_subscribe');	
		
		$template = 'module_subscribe';
		if(in_array($position,$side_position)){
			$template = 'module_subscribe_sidebar';
		}
		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/module/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/module/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/module/'.$template.'.tpl';
		}
		return $this->load->view($this_template, $data);
		}
	}
	public function subscribe(){
		$json = array();
		
		$this->load->language('avethemes/newsletter');
		$this->load->model('avethemes/newsletter');
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&&isset($this->request->post['subscribe_email'])) {	
		
			if ((utf8_strlen($this->request->post['subscribe_email']) < 3) || (utf8_strlen($this->request->post['subscribe_email']) > 64)) {
				$json['error'] = $this->language->get('error_invalid');
			}
			if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['subscribe_email'])) {
				$json['error'] = $this->language->get('error_invalid');
			}
			
			$ave_newsletter_registered = $this->config->get('ave_newsletter_registered');
			$customer_email_exist=$this->model_avethemes_newsletter->checkRegisteredUser($this->request->post);
			if($customer_email_exist){
					$json['error'] = $this->language->get('text_exist');
			}
			if(!isset($json['error'])&&$ave_newsletter_registered&&$customer_email_exist){
				$this->model_avethemes_newsletter->UpdateRegisterUsers($this->request->post,1);					
					$json['success'] = $this->language->get('text_success');
		
			}
			if(!isset($json['error'])&&!$customer_email_exist){	 
				$checkmail_subscribe =$this->model_avethemes_newsletter->checkmail_subscribe($this->request->post);
				$checkmail_unsubscribe =$this->model_avethemes_newsletter->checkmail_unsubscribe($this->request->post);
												
				if($checkmail_subscribe&&!$checkmail_unsubscribe){
					$json['success'] = $this->language->get('text_exist');
				}elseif($checkmail_unsubscribe&&!$checkmail_subscribe){	
					$this->model_avethemes_newsletter->update_unsubscribe($this->request->post);		
					$json['success'] = $this->language->get('text_re_success');
				}else{			
				 	$this->model_avethemes_newsletter->subscribe($this->request->post);
					$json['success'] = $this->language->get('text_success');
				}
			   /*fix */
				if($this->config->get('ave_newsletter_mail_status')){
	
					if (isset($this->request->post['subscribe_name'])) {
						$subscribe_name = $this->request->post['subscribe_name'];
					} else {
						$subscribe_name = '';
					}
	
					$subject = $this->language->get('mail_subject');	
	  
					
					$message = '<table width="60%" cellpadding="2"  cellspacing="1" border="0"> 
								 <tr>
								   <td> Email Id </td>
								   <td> '.$this->request->post['subscribe_email'].' </td>
								 </tr>
								 <tr>
								   <td> Name  </td>
								   <td> '.$subscribe_name.' </td>
								 </tr>';
					 $message .= '</table>';
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');				
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($this->config->get('config_name'));
					$mail->setSubject($subject);
					$mail->setHtml($message);
					$mail->send();
	
				}//EMAIL
			
		   	}//no error
		
		}//REQUEST_METHOD
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function unsubscribe(){
		$this->load->language('avethemes/newsletter');
		$this->load->model('avethemes/newsletter');
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&&isset($this->request->post['subscribe_email'])) {	
		
			if ((utf8_strlen($this->request->post['subscribe_email']) < 3) || (utf8_strlen($this->request->post['subscribe_email']) > 64)) {
				$json['error'] = $this->language->get('error_invalid');
			}
			if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['subscribe_email'])) {
				$json['error'] = $this->language->get('error_invalid');
			}
			$ave_newsletter_registered = $this->config->get('ave_newsletter_registered');
			$customer_email_exist=$this->model_avethemes_newsletter->checkRegisteredUser($this->request->post);
			
			if($customer_email_exist){
					$json['error'] = $this->language->get('text_exist');
			}
			if(!isset($json['error'])&&$ave_newsletter_registered&&$customer_email_exist){
				$this->model_avethemes_newsletter->UpdateRegisterUsers($this->request->post,0);					
					$json['success'] = $this->language->get('text_unsubscribe');
		
			}
			if(!isset($json['error'])&&!$customer_email_exist){	 
				$checkmail_exist =$this->model_avethemes_newsletter->checkmail_exist($this->request->post);
				$checkmail_unsubscribe =$this->model_avethemes_newsletter->checkmail_unsubscribe($this->request->post);
				
				if(!$checkmail_exist){
					$json['error'] = $this->language->get('error_not_exist');
				}else{			
				 	$this->model_avethemes_newsletter->unsubscribe($this->request->post);
					$json['success'] = $this->language->get('text_unsubscribe');
				}
				if(!isset($json['success'])&&$checkmail_unsubscribe){
					$json['success'] = $this->language->get('text_has_unsubscribe');
				}
		   	}
			
		}//REQUEST_METHOD
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>
