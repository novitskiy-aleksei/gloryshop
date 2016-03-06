<?php /******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentTestimonial extends Controller {
	private $error = array(); 
	    
  	public function index() {
		$this->document->addScript('assets/plugins/ajaxupload/ajaxupload.js');
		$language_data = $this->load->language('avethemes/testimonial');
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
			$this->model_avethemes_service->addTestimonial($this->request->post);		
	  		$this->response->redirect($this->url->link('content/testimonial/success'));
    	}
      	$data['breadcrumbs'] = array();
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),	
        	'separator' => false
      	);
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('content/testimonial'),
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
/*message*/ 
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
 		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}	
		
    	$data['back'] = $this->url->link('common/home');
    	$data['button_continue'] = $this->language->get('button_continue');
		$data['action'] = $this->url->link('content/testimonial');

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
		/*customer*/ 
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}	
		if (isset($this->request->post['avatar'])) {
			$data['avatar'] = $this->request->post['avatar'];
		} else {
			$data['avatar'] = 'assets/theme/img/avatar.jpg';
		}
		
		$this->load->model('tool/image');
		
		$data['no_image'] = 'assets/theme/img/avatar.jpg';
		
		if (isset($this->request->post['avatar']) && file_exists(DIR_IMAGE . $this->request->post['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['avatar'], 100, 100);
		} else {
			$data['thumb'] = 'assets/theme/img/avatar.jpg';
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

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		}else {
			$data['rating'] = '';
		}

		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}		
				

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/service/testimonial.tpl')) {

			$this_template = $this->config->get('config_template') . '/avethemes/template/service/testimonial.tpl';

		} else {

			$this_template = 'default/avethemes/template/service/testimonial.tpl';

		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
 		$this->response->setOutput($this->load->view($this_template, $data));		
  	}

  	public function success() {
		$this->load->language('avethemes/testimonial');

		$this->document->setTitle($this->language->get('heading_title')); 

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('content/testimonial'),
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
	public function image() {	
	
		$language_data = $this->load->language('avethemes/testimonial');
		$this->load->model('tool/image');
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$full_filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			if ((utf8_strlen($full_filename) < 3) || (utf8_strlen($full_filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}	  
			$filename=(string)$full_filename;
			/**/ $full_name = explode(".",$filename); 	
			$filename_prefix =$full_name[0];
			$filename_ext =substr(strrchr($filename, '.'), 1);	
			$filename = $filename_prefix.'.'.$filename_ext;
			$allowed = array();/*1*/ 
			$filetypes = explode(',', 'jpg,png,gif');/*2*/ 		
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}/*3*/ 
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}		
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
			/*
			if ($this->request->files['file']['size']>40000) {
				$json['error'] = $this->language->get('error_upload_file_size');
			}		*/ 	
			$img_info = getimagesize($this->request->files["file"]["tmp_name"]);
			$img_width = $img_info[0];
			$img_height = $img_info[1];
			if ($img_width>480||$img_height>480) {
				$json['error'] = $this->language->get('error_upload_file_dimension');
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
	
		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = substr(md5(mt_rand()),0,8);		
				if (!is_dir(DIR_IMAGE.'catalog/clients/')){
					@mkdir(DIR_IMAGE.'catalog/clients/',  0777, true);
				}
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE.'catalog/clients/'.$ext.'.'.$filename);		 
				$json['filename'] = 'catalog/clients/'.$ext.'.'.$filename;	
				$json['thumb']= $this->model_tool_image->resize('catalog/clients/'.$ext.'.'.$filename, 100, 100);
		}
						
			$json['success'] = $this->language->get('text_success_upload');
		}	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
  	private function validate() {
		/*customer*/ 
    	if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}
    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
    	if (!isset($this->request->post['service_selection'])) {
      		$this->error['service_selection'] = $this->language->get('error_service');
    	}
		/*message*/ 
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 1500)) {
      		$this->error['message'] = $this->language->get('error_message');
    	}
		
		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
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
	
	public function widget($setting=array()) {
		if(defined('ave_check')){
		static $module = 0;
			$data['ave'] = $this->ave;
			$data['carousel_limit'] = isset($setting['sections']['carousel_limit'])?$setting['sections']['carousel_limit']:1;
			$data['carousel_autoplay'] = isset($setting['sections']['carousel_autoplay'])?$setting['sections']['carousel_autoplay']:3000;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		if (!empty($setting['title'][$this->config->get('config_language_id')])) {
      		$data['heading_title'] = html_entity_decode($setting['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$data['heading_title'] = $this->language->get('testimonial_title');		
		}
		
		$data['heading_align'] = !empty($setting['heading_align'])?$setting['heading_align']:'';
		
		$this->load->model('tool/image');
		$this->load->model('avethemes/testimonial');
			$data['submit_testimonial'] = $this->url->link('content/testimonial');
		$limit =5;
		if(!empty($setting['sections']['limit'])){
			$limit = $setting['sections']['limit'];
		}
		if($setting['sections']['type']=='custom')	{
			$custom_testimonial = (isset($setting['sections']['custom_testimonial']))?$setting['sections']['custom_testimonial']:false;
			$testimonials = $this->model_avethemes_testimonial->getTestimonialsGroup($custom_testimonial,$limit);
		}else{
			$testimonials = $this->model_avethemes_testimonial->getRandomTestimonials($limit);			
		}
			$data['testimonials'] = array();
			if(!empty($testimonials)){
				foreach ($testimonials as $testimonial_info) {
					if ($testimonial_info['avatar'] && file_exists(DIR_IMAGE . $testimonial_info['avatar'])) {
						$avatar =  $this->model_tool_image->resize($testimonial_info['avatar'],150,150);
					} else {
						$avatar = 'assets/theme/img/avatar.jpg';
					}	
						
					if ($testimonial_info) {					
						$data['testimonials'][] = array(
						'name' => $testimonial_info['customer_name'],
						'message' => html_entity_decode($testimonial_info['message'], ENT_QUOTES, 'UTF-8'),		
						'competence' => $testimonial_info['competence'],			
						'rating' => $testimonial_info['rating'],							
						'avatar' => $avatar,					
						);
					}
				}	
		}
		$data['num_row'] = isset($setting['sections']['num_row'])?$setting['sections']['num_row']:1;
		
		if (!empty($setting['display'])) {	
			$template = $setting['display'];
		}else{
			$template='testimonial-v1';
		}
		$data['module'] = $template.'_'.$module++; 	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/shortcodes/'.$template.'.tpl';
		}
		
        return $this->load->view($this_template, $data);
		}
	}
}
?>
