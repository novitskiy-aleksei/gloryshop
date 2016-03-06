<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesEditor extends Controller {
	private $error = array(); 
	private $_key = 'skin';
	private $default_language = 'english';
	private $ldata = array();
	public function index(){
		$config_template=$this->config->get('config_template');
		$store_url=$this->ave->get('config_store_url');
		$protocol = (strpos($store_url,'https:') !== false)?'https://':'http://';
		//if($config_template==$this->ave->theme()){
		/*Add Scrip*/ 
		$ignore_fonts = $this->ave->getRegularFonts();
		
		$google_fonts[] = $this->ave->get('body_font');
		$google_fonts[] = $this->ave->get('heading_font');
		$google_fonts[] = $this->ave->get('name_font');
		$google_fonts[] = $this->ave->get('price_font');
		
		
		foreach ($google_fonts as $google_font) {
			if (!in_array($google_font, $ignore_fonts)) {
					$this->document->addStyle($protocol.'fonts.googleapis.com/css?family='.$google_font.'&amp;subset=all');		
			}
		}
		$route=$this->ave->getRoute();
		$dir=$this->ave->layout('dir');
		
		$header_style= $this->ave->get('header_style');
		if (file_exists(DIR_STORE . 'assets/theme/css/'.$header_style.'.css')) {
			$this->document->addStyle('assets/theme/css/'.$header_style.'.css','stylesheet','all');
		}
		
		$this->document->addScript('assets/editor/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
		$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');
		$this->document->addStyle('assets/plugins/owl-carousel/owl.carousel.min.css','stylesheet','all');
		
		$ave_cms_addthis = $this->config->get('ave_cms_addthis');
		if($route=='content/article'&&$ave_cms_addthis==1){
			$this->document->addScript('https://s7.addthis.com/js/300/addthis_widget.js');
		}	
 		$animate=$this->ave->get('animated');
		if($animate=='with-animated'){
			$this->document->addStyle('assets/theme/css/animate.min.css','stylesheet','all');
		}
		
		if($route=='checkout/checkout'){
			$this->document->addStyle('assets/theme/css/checkout.css','stylesheet','all');
		}
		if($route=='product/product'){
 			$product_binding=$this->ave->get('product_binding');
				if($product_binding['addthis_widget']==1){
					$this->document->addScript('https://s7.addthis.com/js/300/addthis_widget.js');
				}
				if($product_binding['image_type']==1){
					$this->document->addStyle('assets/plugins/jquery-lightbox/css/skin/'.$product_binding['lightbox_skin'].'-skin/skin.css');
					$this->document->addStyle('assets/plugins/jquery-lightbox/css/lightbox.css');
					$this->document->addScript('assets/plugins/jquery-mousewheel/jquery.mousewheel.js');
					$this->document->addScript('assets/plugins/jquery-lightbox/js/lightbox.min.js');
					$this->document->addScript('assets/plugins/jquery-elevatezoom/elevatezoom.min.js');
				} 
		}
		/*Control Panel*/ 
		$user_login = true;
		$referer = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:'';
		$session_layout_id = $this->session->data['session_layout_id'] = $this->ave->getLayoutID();
		$frontend_cp_status= $this->config->get('skin_cp_enabled');
		if ($this->config->get('skin_cp_user')==1) {
			$frontend_cp_status = false;
		}
		if ($this->config->get('skin_cp_enabled')==1&&$this->checkUser('isLogged')&&$this->config->get('skin_cp_user')==1) {
			$frontend_cp_status = true;
		}
		if (isset($this->session->data['admin_editor'])) {
			$frontend_cp_status= true;
		}
		if($frontend_cp_status==true){
			$this->document->addStyle('assets/editor/css/front_editor.css');		
		}
		$rstatus = $this->ave->validate();
		if (isset($this->session->data['editor_status'])&&$rstatus==true&&$frontend_cp_status==true) {
			$this->document->addStyle('assets/editor/plugins/jquery-ui/jquery-ui.css','stylesheet','all');
			$this->document->addScript('assets/editor/plugins/jquery-ui/jquery-ui.js');
			$this->document->addScript('assets/editor/js/front_editor.js');
		}
			$data['skin_cp_enabled'] = $this->config->get('skin_cp_enabled');
		if (!isset($this->session->data['editor_status'])&&$frontend_cp_status==true&&$rstatus==true) {
			$data['editor_href'] = $this->url->link('avethemes/editor/open_editor', '', 'SSL');	
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/editor.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/editor/editor.tpl';
		} else {
			$this_template = 'default/avethemes/editor/editor.tpl';
		}	
		return $this->load->view($this_template, $data); 
	}
	public function open_editor(){
			$this->session->data['editor_status'] = 1;
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home', '', 'SSL');				
			$this->response->redirect($redirect);
		
	}
	public function applylayout(){
		$json = array();
		if ($this->check_referer()!== false) {
			$user_login = $this->checkUser('isLogged');
			
			$this->load->language('avethemes/layout_builder');
			$this->load->model('avethemes/layout');
			if($this->config->get('skin_layout_refresh')){
				if (isset($this->session->data['preview_url'])) {
					$redirect = $this->session->data['preview_url'];
				}else{
					$redirect= 'index.php?route=common/home';			
				}
				$json['redirect'] = str_replace('&amp;', '&', $redirect);	
			}
			if (($this->request->server['REQUEST_METHOD'] == 'POST')&& $this->checkUser('hasPermission')){
				if(isset($this->request->post['layout_id'])&&$this->request->post['layout_id']!=0){				
					$this->model_avethemes_layout->editLayoutModule($this->request->post['layout_id'], $this->request->post);
				}
				$json['success'] = $this->session->data['success_message'] = $this->language->get('text_success');
			}else{
				$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
			} 
		}else{
			$json['error'] = $this->session->data['error_message'] ='Not accept request!';
		}	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
  	public function add_skin() {	
		$json = array();
				$this->load->language('avethemes/editor');
				$user_login = $this->checkUser('isLogged');
		if ($this->check_referer()!== false&&$this->checkUser('hasPermission')&&$this->config->get('ave_installed')) {
				$this->load->model('avethemes/skin');		
						$skin_name ='-Draft-';
					$savedata= array(
					'skin_name'=>$skin_name,
					'color'=>'#0dc0c0',
					'theme_setting'=>$this->ave->getDefaultValue(),
					'status'=>0);
					$skin_id = $this->model_avethemes_skin->addSkin($savedata);
			$this->session->data['skin_id'] = $skin_id;
			$this->session->data['action_cp'] = 'general';
			$this->session->data['action_title'] = $this->language->get('text_general');

			$json['success'] = $this->session->data['success_message'] = sprintf($this->language->get('text_success_add_skin'), $skin_name);
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');				
			$json['redirect'] = str_replace('&amp;', '&', $redirect);	
		}else {
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  	}
	public function active_skin(){ 
		$json = array();
				$this->load->language('avethemes/editor');
				$user_login = $this->checkUser('isLogged');
		if (isset($this->request->get['skin_id'])&&$this->check_referer()!== false&&$this->checkUser('hasPermission')) {	
			$skin_id = $this->request->get['skin_id'];
			$this->session->data['skin_id'] = $skin_id;	
			$this->load->model('setting/setting');	
			$store_id = (int)$this->config->get('config_store_id');
			$store_info = $this->model_setting_setting->getSetting('config',$store_id);
			$store_name = $store_info['config_name'];
			
			$this->load->model('avethemes/skin');	
			$this->model_avethemes_skin->activeSkin($skin_id,$store_id);
			$skin_info = $this->model_avethemes_skin->getSkin($skin_id);
			
			$json['success'] = $this->session->data['success_message'] = sprintf($this->language->get('text_success_active_skin'), $skin_info['skin_name'],$store_name);
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');				
			$json['redirect'] = str_replace('&amp;', '&', $redirect);	
		}else {
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function delete_module(){ 
		$json = array();
				$this->load->language('avethemes/editor');
				$user_login = $this->checkUser('isLogged');
		if (isset($this->request->get['module_id'])&&$this->check_referer()!== false&&$this->checkUser('hasPermission')) {
			$module_id = $this->request->get['module_id'];
			$this->load->model('avethemes/layout');		
			$this->model_avethemes_layout->deleteModule($module_id);
			$json['success'] = $this->session->data['success_message'] = $this->language->get('text_success_delete_module');
		}else {
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function delete_skin(){ 
		$json = array();
				$this->load->language('avethemes/editor');
				$user_login = $this->checkUser('isLogged');
		if (isset($this->request->get['skin_id'])&&$this->check_referer()!== false&&$this->checkUser('hasPermission')) {
			$this->session->data['skin_id'] = $this->config->get('skin_active_id');		
			$skin_id = $this->request->get['skin_id'];
			$this->load->model('avethemes/skin');		
			$this->model_avethemes_skin->deleteSkin($skin_id);
			$json['success'] = $this->session->data['success_message'] = $this->language->get('text_success_delete_skin');
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');				
			$json['redirect'] = str_replace('&amp;', '&', $redirect);	
		}else {
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function switch_skin(){ 
		$this->load->language('avethemes/editor');
		$json = array();
		if (isset($this->request->get['skin_id'])) {					
			$this->session->data['skin_id'] = (int)$this->request->get['skin_id'];
		}
		$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');				
		$json['redirect'] = str_replace('&amp;', '&', $redirect);	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function apply(){
		$json = array();
			/*Language*/ 
			$this->load->language('avethemes/editor');
			$user_login = $this->checkUser('isLogged');
			if ($this->check_referer()!== false&&($this->request->server['REQUEST_METHOD'] == 'POST')&&isset($this->request->post['skin_id'])&& $this->checkUser('hasPermission')){
				
				
				$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');				
				$json['redirect'] = str_replace('&amp;', '&', $redirect);
				
				$store_id = 0;
				if (isset($this->request->post['store_id'])) {
					$store_id = $this->request->post['store_id'];
				}
				$this->load->model('avethemes/skin');	
				$this->model_avethemes_skin->editSetting($this->_key, $this->request->post, $store_id);	
				
				
				
				if(isset($this->request->post['theme_setting'])){
					$update_data = array(
								'skin_name'=>$this->request->post['skin_name'],
								'color'=>$this->request->post['skin_color'],
								'theme_setting'=>$this->request->post['theme_setting'],
								'status'=>1
					);
					
					$this->model_avethemes_skin->updateSkin($this->request->post['skin_id'],$update_data);	
				}
				
				if(isset($this->request->post['nav_catalog'])){
						$this->load->model('avethemes/global');	
						$this->model_avethemes_global->updateCatalogCategories($this->request->post['nav_catalog']);
				}
				if(isset($this->request->post['nav_content'])){
						$this->load->model('avethemes/global');	
						$this->model_avethemes_global->updateContentCategories($this->request->post['nav_content']);
				}
				 
				if(isset($this->request->post['ave_custom_footer_layout'])){
					$custom_footer_data = array();
					$custom_footer_data['ave_custom_footer_status'] = $this->request->post['ave_custom_footer_status'];	
					$custom_footer_data['ave_custom_footer_class'] = isset($this->request->post['ave_custom_footer_class'])?$this->request->post['ave_custom_footer_class']:'';	
					$custom_footer_data['ave_custom_footer_layout'] = htmlspecialchars_decode($this->request->post['ave_custom_footer_layout']);
					$this->model_avethemes_skin->editSetting('ave_custom_footer',$custom_footer_data, $store_id);
				}
				if (isset($json_error)) {
					$json['error'] = $this->session->data['error_message'] = $json_error;
				} else {
					$json['success'] = $this->session->data['success_message'] = $this->language->get('text_success');	
				}		
				
		}else{
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function editor(){	
		if ($this->check_referer()!== false){
			$token = $this->mtoken();
			$this->load->model('avethemes/skin');
			$this->load->model('avethemes/layout');
			$this->load->model('avethemes/global');
			
			$skin_total = $this->model_avethemes_skin->getTotalSkins();
			if($skin_total<1){
				$savedata= array(
				'skin_name'=>'Default (#0dc0c0)',
				'color'=>'#0dc0c0',
				'theme_setting'=>$this->ave->getDefaultValue(),
				'status'=>1);
				$this->model_avethemes_skin->addSkin($savedata);
			}
			$data['token'] = $this->mtoken();
			$data['ave'] = $this->ave;
			$rstatus = $this->ave->rStatus();
			$data['rbg'] = ($rstatus==1)?'#EAF7D9':'#FFD1D1';
			
			/*Switch Skin Data*/ 
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');
			$data['redirect'] = str_replace('&amp;', '&', $redirect);
			
			$language_data = $this->load->language('avethemes/editor');
			foreach($language_data as $key=>$value){
				$data[$key] = $value;
			}	
			
			if (isset($this->session->data['success_message'])) {
				$data['success_message'] = $this->session->data['success_message'];
				unset($this->session->data['success_message']);
			} else {
				$data['success_message'] = '';
			} 
			if (isset($this->session->data['error_message'])) {
				$data['error_message'] = $this->session->data['error_message'];
				unset($this->session->data['error_message']);
			} else {
				$data['error_message'] = '';
			} 
			/*SkinDefaultValue*/ 
			$store_configs = $this->ave->skin_configs();
			foreach($store_configs as $config_key=>$config_value){
			  $data[$config_key] = $$config_key = $this->config->get($config_key);
			}
		
			$data['skin_name']='Default (#0dc0c0)';
			$data['color']='#0dc0c0';		
			$data['language_id'] = $this->config->get('config_language_id');//needed			
			$data['theme_settings_default'] = $this->ave->getDefaultValue(); 
			$data['skin_texts_default'] = $this->ave->getTranslateText();		
			$data['skin_lic_key'] =$this->config->get('skin_lic_key');	
			$data['custom_menu_link'] = $this->link('ave/category', 'token=' . $this->mtoken(), 'SSL');
			if ($this->request->server['HTTPS']) {
				$data['store_url'] = $this->config->get('config_ssl');
			} else {
				$data['store_url'] = $this->config->get('config_url');
			}	
			
			/*Language*/ 
			$this->load->model('localisation/language');		
			$data['languages'] = $this->model_localisation_language->getLanguages(); 
			
			/*catalog_categories*/ 
			$data['catalog_categories'] = array();
			$catalog_categories = $this->model_avethemes_global->getProductCategories(0);
			foreach ($catalog_categories as $category) {
					$data['catalog_categories'][] = array(
						'category_id'     => $category['category_id'],
						'name'     => $category['name'],
						'top'     => $category['top'],
						'sort_order'     => $category['sort_order'],
						'display'     => $category['display'],
						'column'   => $category['column'] ? $category['column'] : 1
					);
			}
			/*content_categories*/ 
			$this->load->model('avethemes/category');	
			$data['content_categories'] = array();
			$content_categories = $this->model_avethemes_category->getCategories(0);
			foreach ($content_categories as $category) {
					$data['content_categories'][] = array(
						'content_id'     => $category['content_id'],
						'name'     => $category['name'],
						'top'     => $category['top'],
						'sort_order'     => $category['sort_order'],
						'display'     => $category['display'],
						'column'   => $category['column'] ? $category['column'] : 1
					);
			}
			/*Layout*/ 
			$layouts = $this->model_avethemes_layout->getLayouts();
			$data['layouts'] = $layouts;
			
			/*Config Data*/ 
			$data['store_id'] =  $store_id = $this->config->get('config_store_id');
			$data['theme_setting'] = $this->config->get('theme_setting');
			$skins = $this->model_avethemes_skin->getSkins();
			
			$data['skin_active_id'] = $skin_id = $this->config->get('skin_active_id');			
			$skin_pin_download = $this->config->get('skin_pin_download');
			$skin_pin_product = $this->config->get('skin_pin_product');
			$skin_pin_brand = $data['skin_pin_brand'] = $this->config->get('skin_pin_brand');
			$skin_pin_information = $data['skin_pin_information'] = $this->config->get('skin_pin_information');
			$store_logo = $this->config->get('config_logo');
		
			
			$data['skin_id'] =  $skin_id;
			if (isset($this->session->data['skin_id'])) {
				$skin_id =  $this->session->data['skin_id'];
				$data['skin_id'] =  $skin_id;
			}	
			$skin_info = $this->model_avethemes_skin->getSkin($skin_id);
			if(!empty($skin_info)){
				$data['theme_setting'] = $skin_info['theme_setting'];
				$data['skin_name']=$skin_info['skin_name'];
				$data['color']=$skin_info['color'];		
			}
			
			
			$data['skins'] = $skins;
			/*FROM DATA*/ 
			
		$skin_admin_path = $this->config->get('skin_admin_path');
		if(!empty($skin_admin_path)){
			$data['skin_admin_path'] = $this->config->get('skin_admin_path');
		}else{
			$admin_path = $this->config->get('config_secure') ? HTTPS_SERVER.'admin/' : HTTP_SERVER.'admin/' ;
			$data['skin_admin_path'] = $admin_path;
		}
		
		$skin_admin_dir = $this->config->get('skin_admin_dir');
		if(!empty($skin_admin_dir)){
			$data['skin_admin_dir'] = $this->config->get('skin_admin_dir');	
		}else{
			$data['skin_admin_dir'] = str_replace('system/','admin/',DIR_SYSTEM);	
		}			
		/*8. Get Information*/ 
		$data['informations'] = array();
		$data['footer_informations'] = array();
		foreach ($this->model_avethemes_global->getInformations($store_id) as $info) {		
			$data['informations'][] = array(				
				'id' => $info['information_id'],
				'title' => $info['title']
			);
			if ($info['bottom']) {
				$data['footer_informations'][] = array(				
					'id' => $info['information_id'],
					'title' => $info['title']
				);
			}
    	}
		/*9. Get Manufacturers*/
		$data['manufacturers'] = array();
		foreach ($this->model_avethemes_global->getManufacturers($store_id) as $manufacturer) {		
			$data['manufacturers'][] = array(				
				'id' => $manufacturer['manufacturer_id'],
				'name' => $manufacturer['name']
			);
    	}
		
		/*Define Pin Product*/ 
		$data['products'] = array();	
		
		$products =array();
		if(isset($skin_pin_product)){	
			if(is_array($skin_pin_product)){	
				$products = $skin_pin_product;
			}
		}
		if(!is_array($products)){	
			$products =array();
		}
		foreach ($products as $product_id) {
			$product_info = $this->model_avethemes_global->getProduct($product_id,$store_id);
			
			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}	
		/*Define Pin Download*/ 
		$data['downloads'] = array();		
			$downloads =array();
		if (isset($this->request->post['skin_pin_download'])) {
			$downloads = $this->request->post['skin_pin_download'];
		} else if(isset($skin_pin_download)){	
			if(is_array($skin_pin_download)){	
				$downloads = $skin_pin_download;
			}
		}
		if(!is_array($downloads)){	
			$downloads =array();
		}
		$content_installed=$this->config->get('ave_confirm_installed');
		$data['content_installed'] = $content_installed;	
		if($content_installed){
			foreach ($downloads as $download_id) {
				$download_info = $this->model_avethemes_global->getDownload($download_id);				
				if ($download_info) {
					$data['downloads'][] = array(
						'download_id' => $download_info['download_id'],
						'name'       => $download_info['name']
					);
				}
			}	
		}/*ace_confirm_installed*/
		
			/*Switch Skin Data*/ 
			$redirect = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:$this->url->link('common/home');
			
			$data['redirect'] = str_replace('&amp;', '&', $redirect);
			
		$data['add_module'] = $this->url->link('avethemes/editor/modules', '', 'SSL');
		// Get a list of installed modules
			// Get Setting
 		$form_configs = array(
 			'ave_custom_footer_status' => 0,
 			'ave_custom_footer_class' => '',
 			'ave_custom_footer_layout' => array()
 		);	
		foreach ($form_configs as $key => $value){
				$data[$key] = $value;
			if($this->config->has($key)){
				$data[$key] = $this->config->get($key);
			}
		}	
		/*Modules Extensions*/
		$data['extensions'] = $this->getInstalledModules();
		
		if (isset($this->session->data['session_layout_id'])) {
			$data['layout_id'] = $data['session_layout_id']	= $this->session->data['session_layout_id'];
		}else{
			$data['layout_id'] = $data['session_layout_id']	= $this->ave->getLayoutIDByRoute('common/home');	
		}
		$data['module_list'] = $this->link('extension/module', 'token='. $this->mtoken() , 'SSL');
		$data['dashboard'] = $this->link('common/dashboard', 'token='. $this->mtoken() , 'SSL');
		$data['footer_builder'] = $this->link('module/ave_footer_builder', 'token='. $this->mtoken() , 'SSL');
			$domain = parse_url(HTTP_SERVER);
			$purchase_theme = $this->ave->theme();
			$data['register_uri'] = 'http://www.avethemes.com/index.php?route=support/license&domain='.$domain['host'].'&theme='.$purchase_theme;
			$data['skin_config_email'] = $this->config->get('config_email');	
			$data['skin_config_domain'] = $domain['host'];
			
		/*Layout Modules*/ 
			$layout_modules_data = array();
		if (isset($data['layout_id'])) {
			$layout_modules = $this->model_avethemes_layout->getLayoutModules($data['layout_id']);
			foreach ($layout_modules as $layout_module) {
					$part = explode('.', $layout_module['code']);
					if(!isset($part[0])){
						$href = $this->link('module/' . $layout_module['code'], '', 'SSL');
					}elseif (isset($part[0]) && !isset($part[1])) {						
						$href = $this->link('module/' . $part[0], '', 'SSL');
					}else{						
						$href = $this->link('module/' . $part[0],  'module_id=' . $part[1], '', 'SSL');
					}
					$layout_modules_data[] = array(
							'layout_id'	=>$layout_module['layout_id'],
							'title'		=>$this->module_title($layout_module['code']),
							'name'		=>$this->module_name($layout_module['code']),
							'code'		=>$layout_module['code'],
							'href'		=>$href,
							'position'	=>$layout_module['position'],
							'sort_order'=>$layout_module['sort_order']
					);
			}
		}
			
			$data['layout_modules'] = 	$layout_modules_data;	
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/main_editor.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/editor/main_editor.tpl';
			} else {
				$this_template = 'default/avethemes/editor/main_editor.tpl';
			}
			
			
			if(isset($this->request->get['action_title'])){
				$this->session->data['action_title'] = $this->request->get['action_title'];
			}
			
			$data['action_title'] = isset($this->session->data['action_title'])?$this->session->data['action_title']:$this->language->get('text_general');
			$data['default_section'] = $this->load->controller('avethemes/editor/action_cp' ,$data);
			$this->response->setOutput($this->load->view($this_template, $data));
		}
	}
	public function action_cp($param=array()) {	
		if ($this->check_referer()!== false&&!empty($param)){
				$data = $param;
				$action_cp = 'general';
				if(isset($this->request->get['action_cp'])){
					if($this->request->get['action_cp']==''||$this->request->get['action_cp']=='null'||$this->request->get['action_cp']=='undefined'){
						$this->session->data['action_cp'] = 'general';
					}else{
						$this->session->data['action_cp'] = $this->request->get['action_cp'];
					}
				}
				if(isset($this->session->data['action_cp'])){
					if($this->session->data['action_cp']==''||$this->session->data['action_cp']=='null'||$this->session->data['action_cp']=='undefined'){
						unset($this->session->data['action_cp']);
					}else{
						$action_cp = $this->session->data['action_cp'];
					}
				}
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/'.$action_cp.'.tpl')) {
						$this_template = $this->config->get('config_template') . '/avethemes/editor/'.$action_cp.'.tpl';
					} else {
						$this_template = 'default/avethemes/editor/'.$action_cp.'.tpl';
					}	
				return $this->load->view($this_template, $data);
		}
	}
	public function layout_preview() {	
		$json = array();
		$json['preview'] = 'index.php?route=common/home';
		$preview_urls = $this->config->get('skin_layout_builder_preview_urls');
		if(isset($this->request->get['layout_id'])){
				$layout_id = $this->request->get['layout_id'];
				if(isset($preview_urls[$layout_id])){
					$json['preview'] = str_replace('&amp;', '&',$preview_urls[$layout_id]['preview_url']);
					$this->session->data['preview_url'] = $preview_urls[$layout_id]['preview_url'];
				}
				$this->session->data['session_layout_id'] = $layout_id;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	
	}
	private function getInstalledModules(){
		$installed = array();
		$this->load->model('avethemes/layout');
		$extensions = $this->model_avethemes_layout->getInstalled('module');
		$allows = $this->allow_quickadd;
		
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			//make sure frontend controller exist
			if (file_exists(DIR_APPLICATION . 'controller/module/' . $code . '.php')) {
			$this->language_load('module/' . $code);
			$ave_modules = array('ave_content_post_list','ave_content_post_type','ave_product','ave_product_list','ave_product_tabs','ave_shortcodes','ave_sliderbanner');
		
		
			$module_data = array();
			$module_add = false;
			$quick_add = false;
			$thumb = false;
			
			$modules = $this->model_avethemes_layout->getModulesByCode($code);
				if(!empty($modules)){
					$module_add = true;
					$quick_add = in_array($code,$allows)?true:false;
					foreach ($modules as $module) {
							 if(in_array($code,$ave_modules)){
								if(is_array($setting = $this->ave->decodeSetting($module['setting']))){
									$thumb = (isset($setting['display']))?'assets/editor/img/mockup/'.$setting['display'].'.png':false; 
								 }
							 }
							$module_data[] = array(
								'title' => $this->language_get('heading_title'),
								'thumb' => $thumb,
								'name' => ' &raquo; ' . $module['name'],
								'code' => $code . '.' .  $module['module_id'],
								'module_id' => $module['module_id'],
								'edit'      => $this->link('module/' . $code,  'module_id=' . $module['module_id'], '', 'SSL')
							);
					}
				} else if(empty($modules)&&$this->config->has($code . '_status')){
					$module_add = false;
					$module_data[] = array(
						'title' => $this->language_get('heading_title'),
						'thumb' => $thumb,
						'name' => $this->language_get('heading_title'),
						'code' => $code,
						'edit'      => $this->link('module/' . $code . '', '', 'SSL'),
					);
				}
				$installed[] = array(
					'add'   => $module_add,
					'quick_add'   => $quick_add,
					'quick_href'   => $this->link('feed/visual_layout_builder/quickadd&token='.$this->mtoken(). '&code=' . $code, '', 'SSL'),
					'title'   => $this->language_get('heading_title'),
					'name'   => $this->language_get('heading_title'),
					'code'   => $code,
					'edit'      => $this->link('module/' . $code, '', 'SSL'),
					'module' => $module_data
				);
			}
		}
		return $installed;
	}
	private $allow_quickadd = array(
			'ave_content_post_list',
			'ave_content_post_type',
			'ave_custom_html',
			'ave_product',
			'ave_product_list',
			'ave_product_tabs',
			'ave_shortcodes',
			'bestseller',
			'featured',
			'html',
			'latest',
			'special'
	);
	public function module_refresh(){
		if ($this->check_referer()!== false) {
		$token = $this->mtoken();
		$language_data = $this->load->language('avethemes/layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$data['extensions'] = $this->getInstalledModules();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/layout_module_refresh.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/editor/layout_module_refresh.tpl';
		} else {
			$this_template = 'default/avethemes/editor/layout_module_refresh.tpl';
		}	
		$this->response->setOutput($this->load->view($this_template,$data));
		}
	}
	public function modules() {		
		if ($this->check_referer()!== false) {
		$this->document->addScript('assets/editor/js/form.js');
		$this->document->addStyle('assets/editor/css/form.css');
		
		$token = $this->mtoken();
		$language_data = $this->load->language('avethemes/layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$data['extensions'] = $this->getInstalledModules();
		
		$data['header'] = $this->load->controller('avethemes/editor/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/layout_module_popup.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/editor/layout_module_popup.tpl';
		} else {
			$this_template = 'default/avethemes/editor/layout_module_popup.tpl';
		}
		$this->response->setOutput($this->load->view($this_template,$data));
		}
	}
	private function module_name($code){
		$return = '';
		$part = explode('.', $code);
		if (isset($part[0])){
			$this->language_load('module/' . $part[0]); 
		}else{
			$this->language_load('module/' . $code); 
		}
		if (isset($part[0]) && !isset($part[1])) {
			$return = $this->language_get('heading_title');
		}else{		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$part[1] . "'");
			if ($query->row) {
				$return = $query->row['name'];
			} 
		}
		return $return;
		
	}
	private function module_title($code){
		$return = '';
		$part = explode('.', $code);
		if (isset($part[0])){
			$this->language_load('module/' . $part[0]); 
		}else{
			$this->language_load('module/' . $code); 
		}
		$return = $this->language_get('heading_title');
		return $return;
	}
	
	private function check_referer(){
		$return = false;
		
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}	
		$referer = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:'';
		if (strpos($referer,$store_url) !== false) {
			$return = true;
		}
		return $return;
	}
	public function getdata(){		
		if ($this->check_referer()!== false) {
			$this->load->language('avethemes/editor');
			$this->load->model('avethemes/global');	
			$this->load->model('avethemes/skin');
			$dt['fmdata']= array();
			
				$font_style = array(
				  'inherit' 		=>'inherit',
				  'italic' 			=>'italic',
				  'normal' 			=>'normal', 
				  'oblique' 		=>'oblique'
				 );
				foreach ($font_style as $value => $label) {		 
					$dt['fmdata']['font_style'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$text_align = array(	 
				  'inherit' 	=>'inherit',
				  'left' 		=>'left',
				  'right' 		=>'right', 
				  'center' 		=>'center', 
				  'justify' 	=>'justify',
				 );
				foreach ($text_align as $value => $label) {		 
					$dt['fmdata']['text_align'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$carousel_autoplay = array(	 
				  'false' 		=>'false', 
				  '1000' 		=>'1000',
				  '2000' 		=>'2000',
				  '3000' 		=>'3000',
				  '4000' 		=>'4000',
				  '5000' 		=>'5000',
				  '6000' 		=>'6000',
				  '7000' 		=>'7000',
				  '8000' 		=>'8000',
				  '9000' 		=>'9000',
				  '10000' 		=>'10000',
				 );
				foreach ($carousel_autoplay as $value => $label) {		 
					$dt['fmdata']['carousel_autoplay'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$text_transform = array(	 
				  'none' 		=>'none',
				  'uppercase'	=>'uppercase',
				  'lowercase'	=>'lowercase', 
				  'capitalize'	=>'capitalize', 
				  'inherit'		=>'inherit',
				 );
				foreach ($text_transform as $value => $label) {		 
					$dt['fmdata']['text_transform'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$heading_title = array(	 
				  'heading_default' =>'Default',
				  'heading_bg_grey' 	=>'Bg Grey',
				  'heading_bg_colored' 	=>'Bg Colored',
				  'heading_through' 	=>'Middle Line',
				  'heading_small heading_center' 	=>'Small',
				  'heading_default heading_center' =>'Default - Center',
				  'heading_bg_grey heading_center' 	=>'Bg Grey - Center',
				  'heading_bg_colored heading_center' 	=>'Bg Colored - Center',
				  'heading_through heading_center' 	=>'Middle Line - Center',
				  'heading_small heading_center' 	=>'Small - Center',
				  'heading_default heading_right' =>'Default - Right',
				  'heading_bg_grey heading_right' 	=>'Bg Grey - Right',
				  'heading_bg_colored heading_right' 	=>'Bg Colored - Right',
				  'heading_through heading_right' 	=>'Middle Line - Right',
				  'heading_small heading_right' 	=>'Small - Right'
				 );
				foreach ($heading_title as $value => $label) {		 
					$dt['fmdata']['heading_title'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$grid_limit = array(	
				  '12'			=>'1 '.$this->language->get('text_items'), 
				  '6'			=>'2 '.$this->language->get('text_items'), 
				  '4'			=>'3 '.$this->language->get('text_items'), 
				  '3'			=>'4 '.$this->language->get('text_items'),
				  '2'			=>'6 '.$this->language->get('text_items') 
				 );
				foreach ($grid_limit as $value => $label) {		 
					$dt['fmdata']['grid_limit'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$carousel_limit = array(	
				  '1'			=>'1 '.$this->language->get('text_item'), 
				  '2'			=>'2 '.$this->language->get('text_items'), 
				  '3'			=>'3 '.$this->language->get('text_items'), 
				  '4'			=>'4 '.$this->language->get('text_items'), 
				  '5'			=>'5 '.$this->language->get('text_items'), 
				  '6'			=>'6 '.$this->language->get('text_items') 
				 );
				foreach ($carousel_limit as $value => $label) {		 
					$dt['fmdata']['carousel_limit'][]= array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
                 $layout_direction =       $this->ave->layout('direction'); 
				$column_position = array(
				  'default'		=>$this->language->get('text_inherit_general'), 
				  'custom'		=>$this->language->get('text_custom'), 
				 );
				foreach ($column_position as $value => $label) {		 
					$dt['fmdata']['column_position'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$box_shadow = array(
				  'no-shadow'		=>$this->language->get('text_none'), 
				  'lite-shadow'		=>$this->language->get('text_lite_shadow'), 
				  'small-shadow'		=>$this->language->get('text_normal_shadow'), 
				  'medium-shadow'		=>$this->language->get('text_medium_shadow'), 
				  'large-shadow'		=>$this->language->get('text_large_shadow')
				 );
				foreach ($box_shadow as $value => $label) {		 
					$dt['fmdata']['box_shadow'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				}
				$block_shadow = array(
				  'block-no-shadow'		=>$this->language->get('text_none'), 
				  'block-lite-shadow'		=>$this->language->get('text_lite_shadow'), 
				  'block-small-shadow'		=>$this->language->get('text_normal_shadow'), 
				  'block-medium-shadow'		=>$this->language->get('text_medium_shadow'), 
				  'block-large-shadow'		=>$this->language->get('text_large_shadow')
				 );
				foreach ($block_shadow as $value => $label) {		 
					$dt['fmdata']['block_shadow'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				}
				$border_radius = array(
				  'no-border-radius'		=>$this->language->get('text_none'),
				  'small-border-radius'		=>$this->language->get('text_small_radius'),
				  'border-radius'			=>$this->language->get('text_medium_radius'),
				  'large-border-radius'		=>$this->language->get('text_large_radius'),
				  'huge-border-radius'		=>$this->language->get('text_huge_radius')
				 );
				foreach ($border_radius as $value => $label) {		 
					$dt['fmdata']['border_radius'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$bg_position = array(
				  'center top'		=>$this->language->get('text_center_top'), 
				  'center center'	=>$this->language->get('text_center_center'), 
				  'center bottom'	=>$this->language->get('text_center_bottom'), 
				  'left top'		=>$this->language->get('text_left_top'), 
				  'left center'		=>$this->language->get('text_left_center'), 
				  'left bottom'		=>$this->language->get('text_left_bottom'), 
				  'right top'		=>$this->language->get('text_right_top'), 
				  'right center'	=>$this->language->get('text_right_center'), 
				  'right bottom'	=>$this->language->get('text_center_top')
				 );
				foreach ($bg_position as $value => $label) {		 
					$dt['fmdata']['bg_position'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$font_weight = array(
				  'normal'	=>'Normal',
				  '100'		=>'100',
				  '200'		=>'200',
				  '300'		=>'300',
				  '400'		=>'400',
				  '500'		=>'500',
				  '600'		=>'600',
				  '700'		=>'700',
				  '800'		=>'800',
				  '900'		=>'900',
				  'lighter'=>'Lighter', 
				  'bold'	=>'Bold'
				 );
				foreach ($font_weight as $value => $label) {		 
					$dt['fmdata']['font_weight'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$bg_repeat = array(
				  'repeat' 			=>'repeat',
				  'repeat-x' 		=>'repeat-x',
				  'repeat-y' 		=>'repeat-y', 
				  'no-repeat' 		=>'no-repeat'
				 );
				foreach ($bg_repeat as $value => $label) {		 
					$dt['fmdata']['bg_repeat'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$bg_size = array(
				  'inherit' 			=>'inherit',
				  'cover' 		=>'cover',
				  'contain' 		=>'contain', 
				  'initial' 		=>'initial'
				 );
				foreach ($bg_size as $value => $label) {		 
					$dt['fmdata']['bg_size'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$bg_attachment = array(
				  'fixed'			=>'fixed',
				  'scroll'			=>'scroll',
				  'inherit'			=>'inherit'
				 );
				foreach ($bg_attachment as $value => $label) {		 
					$dt['fmdata']['bg_attachment'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
		
				$setcolor =$this->ave->getColors();
				foreach ($setcolor as $value => $label) {		 
					$dt['fmdata']['setcolor'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				foreach ($setcolor as $value => $label) {		 
					$dt['fmdata']['set_overcolor'][] = array(
						'value'       =>$value.'-bg-hover',
						'label'        =>$label
					);
				 }
		
				foreach ($setcolor as $value => $label) {		 
					$dt['fmdata']['setbgcolor'][] = array(
						'value'       =>$value.'-bg',
						'label'        =>$label
					);
				 }
			 $regular_fonts=$this->ave->getRegularFonts();
				 foreach ($regular_fonts as $font_name) { 		 
					$dt['fmdata']['setfont'][]= array(				
						'value'       =>$font_name,
						'label'        =>$font_name
					);
				 }
				$setfont=$this->ave->getGoogleFonts();
				 foreach ($setfont as $font_name) { 		 
					$dt['fmdata']['setfont'][] = array(
						'value'       =>str_replace(' ','+',$font_name),				
						'label'        =>$font_name	
					);
				 }
				$tlang=$this->model_avethemes_global->getTwitterLang();
				foreach ($tlang as $value => $label) {		 
					$dt['fmdata']['tlang'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }
				$flang=$this->model_avethemes_global->getFacebookLang();
				 foreach ($flang as $value=>$label) { 		 
					$dt['fmdata']['flang'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
				 }	
			$json = $dt['fmdata'];
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	} 
	public function syslang(){
		$languages = array();	
		/*Language*/ 
		$this->load->model('localisation/language');		
		$langs = $this->model_localisation_language->getLanguages();
		 foreach ($langs as $language) { 		 
			$languages[] = array(
				'language_id'=>$language['language_id'],
				'name'       =>$language['name'],
				'code'       =>$language['code'],
				'image'      =>$language['image'],
				'status'     =>$language['status']
			);
		 }
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($languages));
	}
	public function lquery(){
		if ($this->check_referer()!== false) {
		$json = array();	
		$rstatus = $this->ave->rStatus();
		$json['bg'] = ($rstatus==1)?'#EAF7D9':'#FFD1D1';
		$json['html'] = ($rstatus==1)?'rg':'urg';
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}		
	public function connect(){
		$this->load->language('avethemes/editor');
		$json = array();	
		$connecttion= $this->checkConnect();
		if($connecttion==1){
			$json['success'] = $this->session->data['success_message'] = 'Success';	
		}else{			
			$json['error'] = $this->session->data['error_message'] =$this->language->get('text_no_google');	
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	private function checkConnect(){
		//ini_get('max_execution_time'); Test
		set_time_limit(5);
        $connecttion=  false;
		$url = "http://www.google.com";
		$curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,1);
        curl_setopt($curl,CURLOPT_NOBODY,1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_FRESH_CONNECT,1);
        if(!curl_exec($curl)){
			$connecttion= 0;
        }else{
        	$connecttion= 1;
        }
		curl_close($curl);
		return $connecttion;
	}
	/*File Mangager*/ 	
    private $file = 'image_log.txt';
    protected function log_write($log) {	
		$file = DIR_LOGS . $this->file;		
		$handle = fopen($file, 'a+'); 		
		fwrite($handle, $log);			
		fclose($handle); 
    }
	public function thumb(){	
		$this->load->model('tool/image');
		if (isset($this->request->get['image'])) {
			$this->response->setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
		}
	}
	public function popup(){	
		if ($this->check_referer()!== false) {
		$elfinder_path = str_replace('system/','',DIR_SYSTEM).'assets/editor/plugins/elfinder/php/';
		ini_set('max_file_uploads', 50);
		ini_set('upload_max_filesize','50M'); 
		require_once($elfinder_path . 'elFinderConnector.class.php');
		require_once($elfinder_path . 'elFinder.class.php');
		require_once($elfinder_path . 'elFinderSimpleLogger.class.php');
		require_once($elfinder_path . 'elFinderVolumeDriver.class.php');
		require_once($elfinder_path . 'elFinderVolumeLocalFileSystem.class.php');
		
			
		$myLogger = new elFinderSimpleLogger(DIR_LOGS.$this->file);
		
		if (isset($this->session->data['image_access'])) {
			$image_access = $this->session->data['image_access'];
			$session_token = $this->session->data['token'];
			if($image_access!=$session_token){
				$log = 'At time: ['.date('d.m H:s')."]\n";
				$log .= "\tUser Access: ".$this->checkUser('getUserName')."\n";
				$log .= "\tIP Address: ".$this->request->server['REMOTE_ADDR'];
				unset($this->session->data['image_access']);
			}
		} else {
			$this->session->data['image_access'] = $this->session->data['token'];
		}
		$image_path = ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS']))?HTTPS_SERVER:HTTP_SERVER;
		$opts = array(
		'bind' => array(
			'mkdir mkfile rename duplicate upload rm paste' => array($myLogger, 'log'),
		),
		'roots' => array(
				array(
					'driver'     => 'LocalFileSystem',
					'path'       => DIR_IMAGE.'catalog', 
					'startPath'  => DIR_IMAGE.'catalog', 
					'URL'        => $image_path.'image/catalog', 
					// 'alias'      => 'File system',
					'uploadOrder'  => 'deny,allow',
					'mimeDetect' => 'internal',
					'tmbPath'    => DIR_IMAGE.'thumb',         // tmbPath to files (REQUIRED)
					'tmbURL'     => $image_path.'image/thumb',
					'utf8fix'    => true,
					//'uploadMaxSize'    => '0',
					'uploadMaxSize'    => '128M',
					'tmbCrop'    => false,
					'tmbBgColor' => 'transparent',
					'accessControl' => 'access',
					'copyOverwrite' => false,
					'uploadOverwrite' => false,
					// 'uploadDeny' => array('application', 'text/xml')
				)		
			)
		);
		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
		}
	}
	public function mtoken() {
		return (isset($this->session->data['token']) ? $this->session->data['token'] : 'demo');
	}
	public function stoken() {
		$json = array();
		$json['token'] = (isset($this->session->data['token']) ? $this->session->data['token'] : 'demo');
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function admin_path() {
		$http_server = ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS']))?HTTPS_SERVER:HTTP_SERVER;
		$skin_admin_path = $this->config->get('skin_admin_path');
		if(!empty($skin_admin_path)){
			$skin_admin_path = $this->config->get('skin_admin_path');
		}else{
			$skin_admin_path = $http_server.'admin/';
		}
		return $skin_admin_path;
	}
	public function admin_dir() {
		$skin_admin_dir = $this->config->get('skin_admin_dir');
		if(!empty($skin_admin_dir)){
			$skin_admin_dir = $this->config->get('skin_admin_dir');
		}else{
			$skin_admin_dir = str_replace('system/','admin/',DIR_SYSTEM);
		}
		return $skin_admin_dir;
	}
	public function language_get($key) {
		return (isset($this->ldata[$key]) ? $this->ldata[$key] : $key);
	}
	public function language_load($filename) {
		$_ = array();
		$skin_admin_dir = $this->admin_dir();
		$default_language = $this->default_language;
		$config_language = $this->config->get('config_language');
		
			
		if (file_exists($skin_admin_dir.'language/'. $config_language. '/'.'default.php')) {
			$dir_language = $skin_admin_dir.'language/'.$config_language.'/';
		} else {
			$dir_language = $skin_admin_dir.'language/'.$default_language.'/';
		}
		
		$file = $dir_language. $filename . '.php';
		
		if (file_exists($file)) {
			require($file);
		}
		$this->ldata = array_merge($this->ldata, $_);

		return $this->ldata;
	}
	public function link($route, $args = '', $secure = false) {
		
		$url = $this->admin_path();
		
		$url .= 'index.php?route=' . $route;

		if ($args) {
			$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
		}
		
		return $url;
	}
	public function clearcache() {	
		/*Language*/ 
		$json = array();	
		$this->load->language('avethemes/editor');
		$user_login = $this->checkUser('isLogged');
		if ($this->check_referer()!== false&&$this->checkUser('hasPermission')) {			
			$caches=array(
				'html/',
				'query/',
				'js/',
				'css/'
			);
			foreach($caches as $cache){
				$fcache = DIR_STORE.'assets/cache/'.$cache;
				$files = glob($fcache . '*');
				foreach($files as $file){
					$this->deldir($file);
				}
			}
			$json['success'] = $this->session->data['success_message'] = $this->language->get('text_success_clear_cache');
			
			if (isset($this->request->post['redirect'])) {
				$redirect = $this->request->post['redirect'];
			} else {
				$redirect = $this->url->link('common/home');
			}
			$json['redirect'] = str_replace('&amp;', '&', $redirect);
		}else {
			$json['error'] = $this->session->data['error_message'] =$this->language->get('error_permission');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
     private function deldir($dirname){         
		if(file_exists($dirname)) {
			if(is_dir($dirname)){
                            $dir=opendir($dirname);
                            while($filename=readdir($dir)){
                                    if($filename!="." && $filename!=".."){
                                        $file=$dirname."/".$filename;
					$this->deldir($file); 
                                    }
                                }
                            closedir($dir);  
                            rmdir($dirname);
                        }
			else {@unlink($dirname);}			
		}
	}
	public function product_autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])|| isset($this->request->get['filter_store'])) {
			$this->load->model('avethemes/global');
			
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
						
			$filter_data = array(
				'filter_store'  => $filter_store,
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_avethemes_global->getProducts($filter_data);
			
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
	public function download_autocomplete(){
		$json=array();
    	if(isset($this->request->get['filter_name'])){
			$this->load->model('avethemes/global');
		$filter_data =array(
				'filter_name' =>$this->request->get['filter_name'],
				'start'       =>0,
				'limit'       =>20
			);
		$json=array();
		$results=$this->model_avethemes_global->getDownloads($filter_data);
		foreach($results as $result){
				$json[]=array(
					'download_id'            =>$result['download_id'],
					'name'            =>$result['name'],
					'mask'            =>$result['mask'],
					'filename'    =>$result['filename'],
					'auth_key'    =>$result['auth_key']
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
	public function bg_preset() {		
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('bg_title'));
		$data['lang'] = $this->language->get('code');
		$data['dir'] = $this->language->get('direction');
							
		if (isset($this->request->get['field'])) {
			$data['field'] = $this->request->get['field'];
		} else {
			$data['field'] = '';
		}
				
		if (isset($this->request->get['preview'])) {
			$data['preview'] = $this->request->get['preview'];
		} else {
			$data['preview'] = '';
		}	
		if (isset($this->request->get['active_image'])) {
			$data['active_image'] = $this->request->get['active_image'];
		} else {
			$data['active_image'] = '';
		}			
		$data['header'] = $this->load->controller('avethemes/editor/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/popup_bg.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/editor/popup_bg.tpl';
		} else {
			$this_template = 'default/avethemes/editor/popup_bg.tpl';
		}
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function icon() {		
		$language_data = $this->load->language('avethemes/global_lang');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('icon_title'));
		$data['lang'] = $this->language->get('code');
		$data['dir'] = $this->language->get('direction');

		if (isset($this->request->get['field'])) {
			$data['field'] = $this->request->get['field'];
		} else {
			$data['field'] = '';
		}
				
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}	
		$data['header'] = $this->load->controller('avethemes/editor/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/popup_icon.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/editor/popup_icon.tpl';
		} else {
			$this_template = 'default/avethemes/editor/popup_icon.tpl';
		}		
			
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function filemanager() {
		if ($this->check_referer()!== false) {
		$language_data = $this->language->load('avethemes/image_manager_plus');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
       	$data['user_group_id'] = $this->checkUser('getGroupId');
		$data['image_manager_plus_command']  = $this->config->get('image_manager_plus_command'); 
		$data['image_manager_plus_status']  = $image_manager_plus_status = $this->config->get('image_manager_plus_status'); 
		
		if ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS'])) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
			 
		if ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS'])) {
			$data['http_image'] = HTTPS_SERVER.'image/';
		} else {
			$data['http_image']  = HTTP_SERVER.'image/';
		}

		$data['token'] = '123';

		// Return the target ID for the file manager to set the value
		if (isset($this->request->get['field'])) {
			$data['field'] = $this->request->get['field'];
		} else {
			$data['field'] = '';
		}
		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}
		// Return the preview for the file manager to show a preview
		if (isset($this->request->get['previewsrc'])) {
			$data['previewsrc'] = $this->request->get['previewsrc'];
		} else {
			$data['previewsrc'] = '';
		}
		
		if($image_manager_plus_status==1){
			$this->document->addStyle('assets/editor/plugins/elfinder/css/elfinder.min.css');
			$this->document->addScript('assets/editor/plugins/elfinder/js/elFinder.js');
			$this->document->addScript('assets/editor/plugins/elfinder/js/ui/elfinder-ui.js');
			$this->document->addScript('assets/editor/plugins/elfinder/js/commands/commands.js');
			$this->document->addScript('assets/editor/plugins/elfinder/js/i18n/elfinder.en.js');
			$this->document->addScript('assets/editor/plugins/elfinder/js/proxy/elFinderSupportVer1.js');
			$template = '/avethemes/editor/elfinder_browse.tpl';
		}else{
			$template = '/avethemes/editor/filemanager.tpl';
		}
		
		
		$data['header'] = $this->load->controller('avethemes/editor/header');
		
				$data['images'] = array();
				
				if (isset($this->request->get['filter_name'])) {
					$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->request->get['filter_name']), '/');
				} else {
					$filter_name = null;
				}
		
				// Make sure we have the correct directory
				if (isset($this->request->get['directory'])) {
					$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
				} else {
					$directory = DIR_IMAGE . 'catalog';
				}
		
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
		
		
				$this->load->model('tool/image');
		
				// Get directories
				$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);
		
				if (!$directories) {
					$directories = array();
				}
				// Get files
				$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
		
				if (!$files) {
					$files = array();
				}
				// Merge directories and files
				$images = array_merge($directories, $files);
		
				// Get total number of files and directories
				$image_total = count($images);
		
				// Split the array based on current page number and max number of items per page of 10
				$images = array_splice($images, ($page - 1) * 16, 16);
		
				foreach ($images as $image) {
					$name = str_split(basename($image), 14);
		
					if (is_dir($image)) {
						$url = '';
		
						if (isset($this->request->get['field'])) {
							$url .= '&field=' . $this->request->get['field'];
						}
		
						if (isset($this->request->get['thumb'])) {
							$url .= '&thumb=' . $this->request->get['thumb'];
						}
		
						$data['images'][] = array(
							'thumb' => '',
							'name'  => implode(' ', $name),
							'type'  => 'directory',
							'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
							'href'  => $this->url->link('avethemes/editor/filemanager', 'directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, 'SSL')
						);
					} elseif (is_file($image)) {
						// Find which protocol to use to pass the full image link back
						if ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS'])) {
							$server = HTTPS_SERVER;
						} else {
							$server = HTTP_SERVER;
						}
		
						$data['images'][] = array(
							'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
							'name'  => implode(' ', $name),
							'type'  => 'image',
							'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
							'href'  => $server . 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
						);
					}
				}
		
				if (isset($this->request->get['directory'])) {
					$data['directory'] = urlencode($this->request->get['directory']);
				} else {
					$data['directory'] = '';
				}
		
				if (isset($this->request->get['filter_name'])) {
					$data['filter_name'] = $this->request->get['filter_name'];
				} else {
					$data['filter_name'] = '';
				}		
		
				// Parent
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$pos = strrpos($this->request->get['directory'], '/');
		
					if ($pos) {
						$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
					}
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$data['parent'] = $this->url->link('avethemes/editor/filemanager', $url, 'SSL');
		
				// Refresh
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$url .= '&directory=' . urlencode($this->request->get['directory']);
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$data['refresh'] = $this->url->link('avethemes/editor/filemanager',  $url, 'SSL');
		
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
				}
		
				if (isset($this->request->get['filter_name'])) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$pagination = new Pagination();
				$pagination->total = $image_total;
				$pagination->page = $page;
				$pagination->limit = 16;
				$pagination->url = $this->url->link('avethemes/editor/filemanager', $url . '&page={page}', 'SSL');
		
				$data['pagination'] = $pagination->render();
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
			$this_template = $this->config->get('config_template') . $template;
		} else {
			$this_template = 'default'.$template;
		}	
		$this->response->setOutput($this->load->view($this_template, $data));
		}
	}
	private function checkUser($key){
		$return = false;
			//$this->load->library('user');
			$this->user = new User($this->registry);
			if($key =='isLogged'){$return = $this->user->isLogged();}
			if($key =='getGroupId'){$return = $this->user->getGroupId();}
			if($key =='getUserName'){$return = $this->user->getUserName();}
			if($key =='hasPermission'){$return = $this->user->hasPermission('modify','ave/skin');}
		return $return;
	}
	public function header(){
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->document->setTitle($this->config->get('config_meta_title'));
		$data['base'] = $server;

		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['title'] = $this->document->getTitle();
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/editor/cp_header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/avethemes/editor/cp_header.tpl', $data);
		} else {
			return $this->load->view('default/avethemes/editor/cp_header.tpl', $data);
		}
	}
}
?>