<?php    
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveSliderBanner extends Controller {   
	private $error = array();
	public function delete() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (isset($this->request->get['module_id']) && $this->user->hasPermission('modify', 'module/ave_sliderbanner')) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->index();
	} 
	public function index() {	
		$data['redirect'] = $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_sliderbanner&token=' . $this->session->data['token'] , 'SSL');
			
		$language_data = $this->load->language('module/ave_sliderbanner');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('heading_title'));	
		$data['rstatus'] = $this->ave->validate();
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('ave_sliderbanner', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['module_data'] = array();
		$modules = $this->model_extension_module->getModulesByCode('ave_sliderbanner');
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
								'delete'      => $this->url->link('module/ave_sliderbanner/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
								'href'      => $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
							);
					}
		}	
		
		
		$data['token'] = $this->session->data['token'];
		
		
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
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = false;
		}
		
		if (isset($this->error['popup'])) {
			$data['error_popup'] = $this->error['popup'];
		} else {
			$data['error_popup'] = false;
		}
 		if (isset($this->error['banner_image'])) {
			$data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$data['error_banner_image'] = array();
		}	
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		if (isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => 'Module ID: '.$this->request->get['module_id'],
				'href' => $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		
		if (!isset($this->request->get['module_id'])) {
			$data['module_id'] = 0;
			$data['action'] = $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['module_id'] = $this->request->get['module_id'];
			$data['action'] = $this->url->link('module/ave_sliderbanner', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}				
		$form_configs = array(
			'name'=>'Banner ++ #',
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'bgmode'=>'',
			'display'=>'slider_banner',
			'mobile_display'=>'',
			'grid_limit'=>12,	
			'carousel_limit'=>12,	
			'carousel_autoplay'=>3000,	
			'smartSpeed'=>500,	
			'thumb_display'=>false,	
			'thumb_width'=>120,	
			'thumb_height'=>75,	
			'image_width'=>320,	
			'image_height'=>200,	
			'popup_width'=>800,	
			'popup_height'=>500,	
			'custom_title'=>array(),
			'custom_description'=>array(),
			'banner_image'=>array()
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
		
		$this->load->model('tool/image');
		$data['placeholder'] = $no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['data_banner_images'] = array();
		
		foreach ($data['banner_image'] as $banner_image) {
		
			if ($banner_image['image'] && file_exists(DIR_IMAGE . $banner_image['image'])) {
				$image = $banner_image['image'];
				$thumb = $this->model_tool_image->resize($banner_image['image'], 100, 100);
			} else {
				$image = 'no_image.png';
				$thumb = $no_image;
			}	
			
			$data['data_banner_images'][] = array(
				'title' => $banner_image['title'],
				'title2' => $banner_image['title2'],
				'title3' => $banner_image['title3'],
				'title4' => $banner_image['title4'],
				'link'                     => $banner_image['link'],
				'image'                    => $image,
				'thumb'                    => $thumb
			);	
		} 
	
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
			
		$this_template = 'avethemes/module/banner_plus.tpl';		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');;
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_sliderbanner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!$this->request->post['image_width'] || !$this->request->post['image_height']) {
			$this->error['image'] = $this->language->get('error_image');
		}
		if ($this->request->post['display']=='popup-gallery'&&(!$this->request->post['popup_width'] || !$this->request->post['popup_height'])) {
			$this->error['popup'] = $this->language->get('error_image');
		}
		if (isset($this->request->post['banner_image'])) {
			foreach ($this->request->post['banner_image'] as $banner_image_row => $banner_image) {
				foreach ($banner_image['title'] as $language_id => $title) {
					if ((utf8_strlen($title) < 2) || (utf8_strlen($title) > 64)) {
						$this->error['banner_image'][$banner_image_row][$language_id] = $this->language->get('error_title'); 
					}				
				}
			}	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>