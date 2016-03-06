<?php
/******************************************************
 * @package Custom footter for Opencart 2.0.x
 * @version 1.0
 * @author avethemes (http://www.avethemes.com)
 * @copyright	Copyright (C) May 2013 pavotheme.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 1
*******************************************************/
class ControllerAveCustomFooter extends Controller {
	private $error = array();
	
	public function index() {
		$data['redirect'] = $this->url->link('ave/custom_footer', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_setting'] = $this->url->link('feed/visual_layout_builder/import_setting', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_setting'] = $this->url->link('feed/visual_layout_builder/export_setting', '&code=ave_custom_footer&token=' . $this->session->data['token'] , 'SSL');
		
		$language_data = $this->load->language('avethemes/custom_footer');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->load->model('setting/setting');
		$this->load->model('extension/module');
		// Token
		$data['token'] = $this->session->data['token'];
		$data['rstatus'] = $this->ave->validate();
		$this->load->model('tool/image');
 		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);	
		$this->document->setTitle($this->language->get('heading_title'));
		
	   $this->document->addScript('../assets/plugins/jquery-migrate-1.2.1.min.js');
	   $this->document->addStyle('../assets/editor/plugins/jquery-ui/jquery-ui.css');
	   $this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js');
	   
		$this->document->addScript('../assets/editor/js/custom_footer.js');
		$this->document->addStyle('../assets/editor/css/custom_footer.css');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$post_data = array();
		 	foreach ($this->request->post as $key => $value) {
		 	 	$post_data[$key] = $this->request->post[$key];	
		 	 	$post_data['ave_custom_footer_layout'] = htmlspecialchars_decode($this->request->post['ave_custom_footer_layout']);
		 	}
			$this->model_setting_setting->editSetting('ave_custom_footer',$post_data);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('ave/custom_footer', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);


		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('ave/custom_footer', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
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
		$data['action'] = $this->url->link('ave/custom_footer', 'token=' . $this->session->data['token'], 'SSL');
		
		// Get Setting
 		$form_configs = array(
 			'ave_custom_footer_status' => 0,
 			'ave_custom_footer_class' => '',
 			'ave_custom_footer_layout' => array()
 		);	
		foreach ($form_configs as $key => $value){
				$data[$key] = $value;
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif($this->config->has($key)) {
				$data[$key] = $this->config->get($key);
			}
		}
		$data['extensions'] = $this->_modulesInstalled();
		
		// Render
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$template = 'avethemes/custom_footer/custom_footer.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view($template, $data));
	}
	public function _modulesInstalled(){
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$exdata['extensions'] = array();
		
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
		$ave_modules = array('ave_content_post_list','ave_content_post_type','ave_product','ave_product_list','ave_product_tabs','ave_shortcodes','ave_sliderbanner');
				
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			if (file_exists(DIR_CATALOG . 'controller/module/' . $code . '.php')) {
				$this->load->language('module/' . $code);
			
					$thumb = false;
				$module_data = array();
				
				$modules = $this->model_extension_module->getModulesByCode($code);
				if(!empty($modules)){
					foreach ($modules as $module) {
						 if(in_array($code,$ave_modules)){
							 if(is_array($setting = $this->ave->decodeSetting($module['setting']))){
								$thumb = (isset($setting['display']))?'../assets/editor/img/mockup/'.$setting['display'].'.png':false; 
							 }
						 }
						$module_data[] = array(
							'name' => $module['name'],
							'thumb' => $thumb,
							'code' => $code . '.' .  $module['module_id'],
							'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
							'id' 	=>  $module['module_id']
						);
					}
				}else{	
					if($this->config->has($code . '_status')){
						$module_data[] = array(
							'name' => $this->language->get('heading_title'),
							'thumb' => false,
							'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
							'code' => $code,
							'id' 	=>  NULL
						);
					}
				}
				$exdata['extensions'][$code] = array(
					'name'   => strip_tags( $this->language->get('heading_title') ),
					'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
					'code'   => $code,
					'module' => $module_data

				);
			}
		}
		return $exdata['extensions'];
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ave/custom_footer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}
?>
