<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveCustomHtml extends Controller {
	private $error = array();

	public function index() {
		$url = '';

		if (isset($this->request->get['module_id'])) {
			$url .= '&module_id=' . $this->request->get['module_id'];
		}

		if (isset($this->request->get['element'])) {
			$url .= '&element=' . $this->request->get['element'];
		}
			
		$data['redirect'] = $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'].$url, 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_custom_html&token=' . $this->session->data['token'] , 'SSL');
		
		
		
		$this->load->model('localisation/language');
		$data['languages'] = $languages = $this->model_localisation_language->getLanguages();
		
		$language_data = $this->load->language('module/ave_custom_html');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('heading_title'));	
		$data['rstatus'] = $this->ave->validate();	
		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('ave_custom_html', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'].$url , 'SSL'));
		}
		$data['module_data'] = array();
		$modules = $this->model_extension_module->getModulesByCode('ave_custom_html');
		if(!empty($modules)){
					$thumb = false;
					$has_data = true;
					foreach ($modules as $module) {
							 if(is_array($setting = $this->ave->decodeSetting($module['setting']))){
								$thumb = (isset($setting['display']))?'../assets/editor/img/mockup/'.$setting['display'].'.png':false; 
							 }
							$data['module_data'][$module['module_id']] = array(
								'name' => $module['name'],
								'thumb' => $thumb,
								'module_id' => $module['module_id'],
								'delete'      => $this->url->link('module/ave_custom_html/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
								'href'      => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
							);
					}
		}	
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
			
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'], 'SSL')
		);
		if (isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => 'Module ID: '.$this->request->get['module_id'],
				'href' => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['module_id'] = false;
			$data['action'] = $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'].$url, 'SSL');
		} else {
			$data['module_id'] = $this->request->get['module_id'];
			$data['action'] = $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'].$url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
	
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		$element = '';
		$element_content = array();
		if (isset($this->request->get['element'])) {
			$data['element'] = $element = $this->request->get['element'];
			$path = DIR_TEMPLATE.'avethemes/example/html/'.$element.'.html';
			if(file_exists($path)){
				$file_ct = file_get_contents($path);
				foreach ($languages as $language) { 
					$element_content[$language['language_id']]['description'] =$file_ct ;
				}
			}
		}
		$form_configs = array(
			'name'=>'Custom block',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'status'=>'1',
			'element'=>$element,
			'module_description'=>$element_content,
		);
		
		foreach ($form_configs as $key => $value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif (!empty($module_info)) {
				$data[$key] = isset($module_info[$key])?$module_info[$key]:$value;
			} else {
				$data[$key] = $value;
			}
		}
		$data['elements'] = $this->elements();
		
		/**/ 
		$this->load->controller('ave/shortcut');
		
		//$this->document->addScript('../assets/plugins/global-plugins.js');
		//$this->document->addScript('../assets/plugins/progressbar/progressbar.min.js');
		
		$this->document->addStyle('../assets/theme/css/style.css');
		$this->document->addStyle('../assets/theme/css/section_bg.css');
		$this->document->addStyle('../assets/theme/widget/pricing.css');
		$this->document->addStyle('../assets/theme/widget/progess.css');
		$this->document->addStyle('../assets/theme/widget/tooltip.css');
		$this->document->addStyle('../assets/theme/widget/call_action.css');
		$this->document->addStyle('../assets/theme/css/heading.css');
		$this->document->addStyle('../assets/theme/css/heading2.css');
		//$this->document->addStyle('../assets/theme/css/buttons.css');
		//$this->document->addStyle('../assets/theme/css/buttons-styled.css');
		$this->document->addStyle('../assets/theme/css/animate.min.css');
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('avethemes/module/custom_html.tpl', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function delete() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (isset($this->request->get['module_id']) && $this->validateDelete()) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->index();
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_custom_html')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		foreach ($this->request->post['module_description'] as $language_id => $value) {
			if ((utf8_strlen($value['description']) < 1)) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}
				
		return !$this->error;
	}
	protected function elements() {

		$elements[] = array(
			'label'  => $this->language->get('heading_title'),
			'key'  => false,
			'value'  => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'])
		);
		$elements[] = array(
			'label'  => $this->language->get('text_list'),
			'key'  => 'list',
			'value'  => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&element=list')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_info'),
			'key'  => 'info',
			'value'  => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&element=info')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_description'),
			'key'  => 'desc',
			'value'  => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&element=desc')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_skill_desc'),
			'key'  => 'skill_desc',
			'value'  => $this->url->link('module/ave_custom_html', 'token=' . $this->session->data['token'] . '&element=skill_desc')
		);
		return $elements;
	}
}