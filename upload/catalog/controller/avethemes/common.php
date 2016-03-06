<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesCommon extends Controller {
	public function index(){
		$lang_code = 'en';
		$theme_setting = array();
		$skin_active_id = $this->config->get('skin_active_id');
		$skin_id = $skin_active_id;		
		$ave_installed = $this->config->get('ave_installed');
		$config_template=$this->config->get('config_template');
				$this->load->model('avethemes/skin');
		if (isset($this->request->get['skin_id'])&&isset($this->request->get['no_session'])) {
			$skin_id = $this->request->get['skin_id'];
			$skin_info = $this->model_avethemes_skin->getSkin($skin_id);
			$this->session->data['profile_color'] = $skin_info['color'];
		}
		if (isset($this->session->data['skin_id'])) {
			$skin_id = $this->session->data['skin_id'];
		}
		if (isset($this->request->get['save_session'])) {
			$this->session->data['skin_id'] = $skin_id;	
		}
		if (isset($this->request->get['no_session'])) {	
			unset($this->session->data['skin_id']);
		}
		if($ave_installed==1&&$skin_id){
				$skin_info = $this->model_avethemes_skin->getSkin($skin_id);
				if ($skin_info) {
					$theme_setting = $skin_info['theme_setting'];
					$theme_setting['current_skin_id'] = $skin_id;
				}
		}
		if (isset($this->session->data['language'])) {
    		$lang_code = $this->session->data['language'];
		}	
		$currency_code = $this->currency->getCode();
		
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
			$protocol = (strpos($store_url,'//www') !== false)?'https://www.':'https://';
		} else {
			$store_url = $this->config->get('config_url');
			$protocol = (strpos($store_url,'//www') !== false)?'http://www.':'http://';
		}
		/*handle RichSnippet*/ 
			$current_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$param = array(
			'Current_URL'				=> $current_url,
			'current_skin_id'				=> $skin_id,
			'LanguageCode'				=> $lang_code,
			'CurrencyCode'				=> $currency_code,
			'theme_setting_data'			=> $theme_setting,
			'ave_installed'			=> $ave_installed,
			'config_store_url'			=> $store_url,
			'config_store_id'			=> $this->config->get('config_store_id'),
			'config_template'			=> $config_template,
			'config_maintenance'		=> $this->config->get('config_maintenance'),
			'skin_lang_dir'				=> $this->config->get('skin_lang_dir'),
			'skin_internal_link'		=> $this->config->get('skin_internal_link'),
			'skin_compression_html'		=> $this->config->get('skin_compression_html'),
			'skin_remove_comment'		=> $this->config->get('skin_remove_comment'),	
			'skin_put_js_bottom'		=> $this->config->get('skin_put_js_bottom'),
			'skin_css_delivery'			=> $this->config->get('skin_css_delivery'),
			'skin_minify_code'			=> $this->config->get('skin_minify_code'),	
			'skin_combine_code'			=> $this->config->get('skin_combine_code'),
			'skin_defer_parse'			=> $this->config->get('skin_defer_parse'),
			'skin_query_details'		=> $this->config->get('skin_query_details')
		
		);
	 	$this->ave->initData($param);
        if ($config_template==$this->ave->theme()&&$ave_installed!='1') {
			return new Action('avethemes/common/info');	
		}
	}
	public function style() {
		$ave_installed = $this->config->get('ave_installed');	
		if($ave_installed){ 
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}
		$data['ave'] = $this->ave;
		$data['store_url'] = $store_url;  
		$skin_id = $this->config->get('skin_active_id');
		
		if (isset($this->session->data['skin_id'])) {
    		$skin_id = $this->session->data['skin_id'];
		}	
		if (isset($this->request->get['skin_id'])) {
			$skin_id = $this->request->get['skin_id'];
		}
		
		$data['profile_color'] = $this->ave->get('skin_color');
		
		if (isset($this->session->data['profile_color'])) {
			$data['profile_color'] = $this->session->data['profile_color'];
			unset($this->session->data['profile_color']);
		}
		
		if (isset($this->request->get['profile_color'])) {
			$data['profile_color'] = $this->request->get['profile_color'];
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/css/custom_style.css')) {
			$this_template = $this->config->get('config_template') . '/avethemes/css/custom_style.css';
		} else {
			$this_template = 'default/avethemes/css/custom_style.css';
		}	
		
		$this->response->addHeader('Content-Type: text/css');
		$this->response->setOutput($this->load->view($this_template, $data));
		}
	}
	
	public function script() {	
		$ave_installed = $this->config->get('ave_installed');	
		if($ave_installed){ 
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}
		$data['ave'] = $this->ave;
		$data['store_url'] = $store_url;  
		
		
		if (isset($this->session->data['skin_id'])) {
    		$skin_id = $this->session->data['skin_id'];
		}elseif (isset($this->request->get['skin_id'])) {
			$skin_id = $this->request->get['skin_id'];
		}else{
			$skin_id = $this->config->get('skin_active_id');
		}
		    	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/js/custom_script.js')) {
			$this_template = $this->config->get('config_template') . '/avethemes/js/custom_script.js';
		} else {
			$this_template = 'default/avethemes/js/custom_script.js';
		}	
		
		$this->response->addHeader('Content-Type: text/css');
		$this->response->setOutput($this->load->view($this_template, $data));
		}
	}
	public function info() {		
		$template=$this->config->get('config_template');
		$ave_installed=$this->config->get('ave_installed');
			$this->load->language('avethemes/maintenance');
			
        if ($ave_installed!='1') {
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['heading_title'] = $this->language->get('heading_title');
					
			$data['message'] = $this->language->get('text_message');
		}else{
			$this->document->setTitle($this->language->get('thanks_title'));
			
			$data['heading_title'] = $this->language->get('thanks_title');
					
			$data['message'] = $this->language->get('thanks_message');			
		}
		  
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/maintenance.tpl')) {
				$this_template = $this->config->get('config_template') . '/template/common/maintenance.tpl';
			} else {
				$this_template = 'default/template/common/maintenance.tpl';
			}
			
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
		
			$this->response->setOutput($this->load->view($this_template, $data));
    }
	public function minify($setting){	
		$data['ave'] = $this->ave;
		$data['scripts'] = $setting['scripts'];
		$data['styles'] = $setting['styles'];		
		$this_template = 'default/avethemes/template/child/minify.tpl';
		
		return $this->load->view($this_template, $data);
	}
	/*Extra Position*/ 
	public function pre_header() {
		$user_login = true;
		$config_maintenance = $this->config->get('config_maintenance');
		$data['ave'] = $this->ave;
		// Show view if logged in as admin
		
		$this->user = new User($this->registry);
		$user_login = $this->user->isLogged();
		if($config_maintenance==true&&$user_login==false){
			$data['modules'] = array();
		}else{
			$data['modules'] = $this->getModule('pre_header');
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/pre_header.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/pre_header.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/pre_header.tpl';
		}				
		return $this->load->view($this_template, $data);
	}
	public function after_header() {
		$data['ave'] = $this->ave;
		$data['top_left'] = $this->load->controller('avethemes/common/top_left');
		$data['top_right'] = $this->load->controller('avethemes/common/top_right');
		$data['extra_top'] = $this->load->controller('avethemes/common/extra_top');
		
		$data['modules'] = $this->getModule('after_header');
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/after_header.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/after_header.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/after_header.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function extra_top() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('extra_top');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/extra_top.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/extra_top.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/extra_top.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function top_left() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('top_left');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/top_left.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/top_left.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/top_left.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function top_right() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('top_right');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/top_right.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/top_right.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/top_right.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function pre_footer() {
		$data['ave'] = $this->ave;
		$data['bottom_left'] = $this->load->controller('avethemes/common/bottom_left');
		$data['bottom_right'] = $this->load->controller('avethemes/common/bottom_right');
		$data['extra_bottom'] = $this->load->controller('avethemes/common/extra_bottom');
		
		$data['modules'] = $this->getModule('pre_footer');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/pre_footer.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/pre_footer.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/pre_footer.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function extra_bottom() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('extra_bottom');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/extra_bottom.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/extra_bottom.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/extra_bottom.tpl';
		}					
		return $this->load->view($this_template, $data);
	}
	public function bottom_left() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('bottom_left');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/bottom_left.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/bottom_left.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/bottom_left.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}
	public function bottom_right() {
		$data['ave'] = $this->ave;
		$data['modules'] = $this->getModule('bottom_right');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/position/bottom_right.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/position/bottom_right.tpl';
		} else {
			$this_template = 'default/avethemes/template/position/bottom_right.tpl';
		}
								
		return $this->load->view($this_template, $data);
	}	
	public function getModule($position) {	
		$this->load->model('extension/module');
		$layout_id = 0;
		$layout_id = $this->ave->getLayoutID();
		$data_modules = array();
		$modules = $this->ave->getLayoutModulesByPosition($layout_id, $position);
		foreach ($modules as $module) {
			$part = explode('.', $module['code']);
			
			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
				$data_modules[] = $this->load->controller('module/' .$part[0]);
			}
						
			if (isset($part[1])) {
				$setting_info = $this->ave->getModule($part[1]);
				if ($setting_info && $setting_info['status']) {
					$setting_info['layout_position'] = $position;
					$data_modules[] = $this->load->controller('module/' . $part[0], $setting_info);
				}
			}
		}
		return $data_modules;
	} 
/*End Extra Position*/ 
	public function custom_header($setting) {
       foreach ($setting as $key=>$value) {
			$data[$key] = $value;    
       }
	   $data['language_id'] = $this->config->get('config_language_id');
	   $data['social_status'] = $this->ave->get('social_status');     
	   $data['social_data'] = $this->config->get('skin_social_data');     
		// Search		
		if (isset($this->request->get['search'])) {
			$data['search_query'] = $this->request->get['search'];
		} else {
			$data['search_query'] = '';
		}
		
		$language_id = $this->config->get('config_language_id');//needed
		$template= $this->ave->get('header_style');
		
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		
		if (file_exists(DIR_IMAGE . $this->config->get('config_custom_logo'))) {
			$data['config_custom_logo'] = $server . $this->ave->get('config_custom_logo');
		} else {
			$data['config_custom_logo'] = '';
		}	
		
		$data['main_menu'] = $this->load->controller('avethemes/common/main_menu');
		
		$data['home_class'] = '';
		if (isset($this->request->get['route'])) {
			$get_route = $this->request->get['route'];
		}else{
			$get_route = 'common/home';
		}
		if(empty($get_route)||$get_route==''||$get_route=='common/home'){
			$data['home_class'] = 'active';
		}
			$data['ave'] = $this->ave;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/custom_header/'.$template .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/custom_header/'.$template .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/custom_header/'.$template .'.tpl';
		}
		return $this->load->view($this_template, $data);	
	}
	public function main_menu() {
			$language_id = $this->config->get('config_language_id');//needed
			
			$multi_languages_config=array(
					'skin_pin_product_title',
					'skin_pin_brand_title',
					'skin_pin_information_title',
					'skin_pin_download_title'
			);
			  
			foreach ($multi_languages_config as $title) {
					$title_key=$this->ave->get($title);
				 if (!empty($title_key[$language_id])) {    
					 $$title =  html_entity_decode($title_key[$language_id], ENT_QUOTES, 'UTF-8');
				 }else{
					$$title =FALSE;
				 }
			}   
					
         $skin_nav_shortcode=$this->config->get('skin_nav_shortcode');
         $nav_catalog_status=$this->ave->get('nav_catalog_status');
         $nav_content_status=$this->ave->get('nav_content_status');
         $skin_pin_brand_status=$this->ave->get('skin_pin_brand_status');
         $skin_pin_product_status=$this->ave->get('skin_pin_product_status');
         $skin_pin_information_status=$this->ave->get('skin_pin_information_status');
         $skin_pin_download_status=$this->ave->get('skin_pin_download_status');
         $menu_sort=$this->ave->get('menu_sort');
		 	
		$custommenu_sort=explode(',', $menu_sort);	        
        $desktop_menu['nav_catalog'] = array(
                'label' => 'nav_catalog',     
                'status' => $nav_catalog_status,
                'data' => array(
                	'template' =>'nav_catalog', 
                	'language_id' => $language_id  
                )
        );
       $desktop_menu['nav_content'] = array(
                'label' => 'nav_content',
                'status' => $nav_content_status,
                'data' => array(
                	'template' => 'nav_content',   
                	'language_id' => $language_id 
                )
		);
		
       $desktop_menu['nav_shortcode'] = array(
                'label' => 'nav_shortcode',
                'status' => $skin_nav_shortcode,
                'data' => array(
                	'template' => 'nav_shortcode',
                	'language_id' => $language_id 
                )
		);
        $desktop_menu['skin_pin_brand'] = array(
                'label' => 'skin_pin_brand',     
                'status' => $skin_pin_brand_status,
                'data' => array(
                	'template' => 'skin_pin_brand',  
                	'language_id' => $language_id,   
                	'skin_pin_brand' => $this->config->get('skin_pin_brand'),   
                	'item' => $this->ave->get('skin_pin_brand_limit'),     
                	'width' => $this->ave->get('skin_pin_logo_width'),    
                	'height' => $this->ave->get('skin_pin_logo_height'),  
					'text' => $skin_pin_brand_title,     
                )
		);  
       $desktop_menu['skin_pin_product'] = array(
                'label' => 'skin_pin_product',  
                'status' => $skin_pin_product_status,
                'data' => array(
                	'template' => 'skin_pin_product',  
                	'description_limit' => 150,   
                	'skin_pin_product' => $this->config->get('skin_pin_product'),
                	'language_id' => $language_id,   
					'text' =>$skin_pin_product_title,      
                )
		);   
       $desktop_menu['skin_pin_information'] = array(
                'label' => 'skin_pin_information',    
                'status' => $skin_pin_information_status,
                'data' => array(
                	'template' => 'skin_pin_information', 
                	'skin_pin_information' => $this->config->get('skin_pin_information'),     
                	'language_id' => $language_id,     
					'text' => $skin_pin_information_title,     
                )
		); 
       $desktop_menu['skin_pin_download'] = array(
                'label' => 'skin_pin_download',
                'status' => $skin_pin_download_status,
                'data' => array(
                	'template' => 'skin_pin_download',  
                	'skin_pin_download' => $this->config->get('skin_pin_download'), 
                	'language_id' => $language_id, 
					'text' => $skin_pin_download_title,        
                )
		);       
        
			$data['widgets'] = array();
			foreach ($custommenu_sort as $sort_key) {
				if ($desktop_menu[$sort_key]['status']==1){ 
						 $data['widgets'][] = $this->load->controller('avethemes/widget/'.$sort_key,$desktop_menu[$sort_key]['data']);
				} 
			} 
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/child/main_menu.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/child/main_menu.tpl';
			} else {
				$this_template = 'default/avethemes/template/child/main_menu.tpl';
			}
			return $this->load->view($this_template, $data);
	}
	
	public function custom_footer($setting) {
       foreach ($setting as $key=>$value) {        
			$data[$key] = $$key = $value;
       }
		/*Add Child*/ 
		$data['pre_footer'] = $this->load->controller('avethemes/common/pre_footer');
		$data['footer_custom'] = $this->load->controller('avethemes/custom_footer');
		$data['ave_editor'] = $this->load->controller('avethemes/editor');
	   //FOOTER DATA
		$this->load->model('avethemes/global');
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}
			$og_image = $this->config->get('config_logo');
		if ($route == 'content/category' && isset($this->request->get['content_id'])) {
			$content_path = explode('_', (string)$this->request->get['content_id']);
			$og_image = $this->model_avethemes_global->getContentImage(end($content_path));
		}		
		if ($route == 'content/article' && isset($this->request->get['article_id'])) {
			$og_image = $this->model_avethemes_global->getArticleImage($this->request->get['article_id']);
		}
		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$category_path = explode('_', (string)$this->request->get['path']);
			$og_image = $this->model_avethemes_global->getCategoryImage(end($category_path));
		}
		
		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$og_image = $this->model_avethemes_global->getProductImage($this->request->get['product_id']);
		}
		$this->ave->additionalData(array('og_image'=>$this->ave->store_url().'image/'.$og_image));
	   
		$language_id = $data['language_id'] = $this->config->get('config_language_id');	   
	  
	  	 $data['footer_style']= $footer_style=$this->ave->get('footer_style');
	   
		 $default_footer_sort=$this->ave->get('default_footer_sort');
         $footer_information=$this->ave->get('footer_information');
         $footer_service=$this->ave->get('footer_service');
         $footer_extras=$this->ave->get('footer_extras');
         $footer_account=$this->ave->get('footer_account');
         
		 $data['footer_sort'] = $footer_sort=explode(',', $default_footer_sort);	         
                  
        $data['footer_links']['information'] = array(
                'label' => 'information',
                'status' =>$footer_information['status'],
                'display' =>$footer_information['display'],
                'icon' => $footer_information['icon'],
                'text' => $text_information,
                'links' => array(),
        );
       $data['footer_links']['service'] = array(
                'label' => 'service',
                'status' =>$footer_service['status'],
                'display' =>$footer_service['display'],
				'icon' => $footer_service['icon'],
				'text' => $text_service,
				'links' => array(),
		);
        $data['footer_links']['extras'] = array(
                'label' => 'extras',
                'status' =>$footer_extras['status'],
                'display' =>$footer_extras['display'],
				'icon' => $footer_extras['icon'],
				'text' => $text_extra,
				'links' => array(),
		);
         $data['footer_links']['account'] = array(
                'label' => 'account',
                'status' =>$footer_account['status'],
                'display' =>$footer_account['display'],
				'icon' => $footer_account['icon'],
				'text' => $text_account,
				'links' => array(),
		);
          
         $f=0;
        if($footer_information['status']&&isset($footer_information['display'])){$f++;}
        if($footer_service['status']&&isset($footer_service['display'])){$f++;}
        if($footer_extras['status']&&isset($footer_extras['display'])){$f++;}
        if($footer_account['status']&&isset($footer_account['display'])){$f++;}
        $data['col'] = $col=($f>0)?(12/$f):'12';   
        
       if ($informations) {
            foreach ($informations as $information) { 
             $data['footer_links']['information']['links'][]= array('id'=>$information['id'],'href'=>$information['href'],'title'=>$information['title']);
            }
       }    
       
         $data['footer_links']['service']['links'][]= array('id'=>'1','href'=>$contact,'title'=>$text_contact);
         $data['footer_links']['service']['links'][]= array('id'=>'2','href'=>$return,'title'=>$text_return);
         $data['footer_links']['service']['links'][]= array('id'=>'3','href'=>$sitemap,'title'=>$text_sitemap);
         
         $data['footer_links']['extras']['links'][]= array('id'=>'1','href'=>$manufacturer,'title'=>$text_manufacturer);
         $data['footer_links']['extras']['links'][]= array('id'=>'2','href'=>$voucher,'title'=>$text_voucher);
         $data['footer_links']['extras']['links'][]= array('id'=>'3','href'=>$affiliate,'title'=>$text_affiliate);
         $data['footer_links']['extras']['links'][]= array('id'=>'4','href'=>$special,'title'=>$text_special);
         
         
         $data['footer_links']['account']['links'][]= array('id'=>'1','href'=>$account,'title'=>$text_account);
         $data['footer_links']['account']['links'][]= array('id'=>'2','href'=>$order,'title'=>$text_order);
         $data['footer_links']['account']['links'][]= array('id'=>'3','href'=>$wishlist,'title'=>$text_wishlist);
         $data['footer_links']['account']['links'][]= array('id'=>'4','href'=>$newsletter,'title'=>$text_newsletter);
	     $multi_languages_config =array(
				'skin_powered_desc'
		);
		 
		foreach ($multi_languages_config as $title) {
				$$title =FALSE;
				$title_key=$this->config->get($title);
			 if (!empty($title_key[$language_id])) {    
				 $$title =  html_entity_decode($title_key[$language_id], ENT_QUOTES, 'UTF-8');
			 }else{
				 $$title = '';
			 }
		}   
		$data['skin_powered_desc'] = $skin_powered_desc;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/child/custom_footer.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/child/custom_footer.tpl';
		} else {
			$this_template = 'default/avethemes/template/child/custom_footer.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	public function cart_info() {
		
		$json = array();
		
		$this->load->language('common/cart');

		// Totals
		$this->load->model('extension/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			$sort_order = array();

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);
		}

		$json['items'] 	= $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
		$json['totals'] = $this->currency->format($total);
    
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function ajax_header() {
		$this->load->language('common/header');
		$json = array();
		$whistlist = $this->url->link('account/account', '', 'SSL');
		$json['whistlist'] = '<a href="'.$whistlist.'" id="wishlist-total"><i class="icon fa fa-heart"></i><span class="title">'.sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0)).'</span></a>';
		$json['account'] = $this->account();
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function account() {
		$this->load->language('common/header');
		$return = false;
		$account = $this->url->link('account/account', '', 'SSL');
		$logout = $this->url->link('account/logout', '', 'SSL');
		$register = $this->url->link('account/register', '', 'SSL');
		$login = $this->url->link('account/login', '', 'SSL');
		
		$order = $this->url->link('account/order', '', 'SSL');
		$download = $this->url->link('account/download', '', 'SSL');
		$transaction = $this->url->link('account/transaction', '', 'SSL');
		
		$text_order = $this->language->get('text_order');
		$text_download = $this->language->get('text_download');
		$text_transaction = $this->language->get('text_transaction');
		$text_login = $this->language->get('text_login');
		$text_register = $this->language->get('text_register');
		$text_account = $this->language->get('text_account');
		$text_welcome= $this->ave->text('text_welcome');
		$text_manager_account= $this->ave->text('text_manager_account');
		$text_logout= $this->ave->text('text_logout');
		$logged = $this->customer->isLogged();
		
		if ($this->customer->isLogged()) { 
			$firstname =  $this->customer->getFirstName();
			$return .= '<span><a href="'.$account.'" title="'.$text_account.'"><i class="icon fa fa-user"></i><span class="title">'.$text_welcome.' <b>'.$firstname.'</b></span></a>&nbsp;<i class="fa fa-angle-down"></i></span>';
			$return .= '<div class="dropdown-panel"><ul class="dropdown-panel-con">';
			$return .= '<li><a href="'.$account.'">'.$text_account.'</a></li>';
			$return .= '<li><a href="'. $order.'">'.$text_order.'</li>';
			$return .= '<li><a href="'.$transaction.'">'.$text_transaction.'</a></li>';
			$return .= '<li><a href="'.$download.'">'.$text_download.'</a></li>';
			$return .= '<li><a href="'.$logout.'">'.$text_logout.'</a></li>';
			$return .= '</ul></div>';
    	} else{
			$return .= '<span><a href="'.$account.'" title="'.$text_account.'"><i class="icon fa fa-user"></i><span class="title">'.$text_account.'</span></a>&nbsp;<i class="fa fa-angle-down"></i></span>';
			$return .= '<div class="dropdown-panel"><ul class="dropdown-panel-con">';
			$return .= '<li><a href="'.$register.'"> '.$text_register.'</a> </li>';
			$return .= '<li><a href="'.$login.'"> '.$text_login.'</a> </li>';
			$return .= '</ul></div>';
			
		}
		$return = $return;
		return $return;
		
	}
	public function captcha() {
		$this->session->data['captcha'] = substr(sha1(mt_rand()), 17, 4);
		$image = imagecreatetruecolor(60, 30);
		$width = imagesx($image);
		$height = imagesy($image);
		$black = imagecolorallocate($image, 0, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);
		$red = imagecolorallocatealpha($image, 255, 0, 0, 75);
		$green = imagecolorallocatealpha($image, 0, 255, 0, 75);
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75);
		imagefilledrectangle($image, 0, 0, $width, $height, $white);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);
		imagefilledrectangle($image, 0, 0, $width, 0, $black);
		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
		imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);
		imagestring($image, 10, intval(($width - (strlen($this->session->data['captcha']) * 9)) / 2), intval(($height - 15) / 2), $this->session->data['captcha'], $black);
		header('Content-type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	public function image() {
		$this->load->model('tool/image');
		if (!empty($this->request->get['image'])) {
			$image=$this->request->get['image'];
		}else{
			$image='no_image.png';		
		}
		if (!empty($this->request->get['width'])&&!empty($this->request->get['height'])) {
			$width=$this->request->get['width'];
			$height=$this->request->get['height'];		
		}else{
			$width=$this->config->get('config_image_product_width');
			$height=$this->config->get('config_image_product_height');			
		}
		$img= $this->model_tool_image->resize(html_entity_decode($image, ENT_QUOTES, 'UTF-8'), $width, $height);
		$img_data='<img src="'.$img.'" alt""/>';
		$this->response->setOutput($img_data);
	}
}
?>