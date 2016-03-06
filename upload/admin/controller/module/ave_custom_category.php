<?php    
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveCustomCategory extends Controller {  
	private $error = array(); 
	public function index() {
		$data['redirect'] = $this->url->link('module/ave_custom_category', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_custom_category&token=' . $this->session->data['token'] , 'SSL');
		
		
		$language_data = $this->load->language('module/ave_custom_category');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('heading_title'));	
		$data['rstatus'] = $this->ave->validate();
		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('extension/module');
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('ave_custom_category', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
				
					
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
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
		
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/ave_custom_category', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/ave_custom_category', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/ave_custom_category', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/ave_custom_category', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}				
		$form_configs = array(
			'name'=>'Custom category #',
			'custom_title'=>array(),
			'catalog_data'=>array('category_id'=>0,'is_parent'=>0,'icon'=>'fa fa-tasks','vcolumn'=>'1','vsort_order' => 999),
			'content_data'=>array('content_id'=>0,'is_parent'=>0,'icon'=>'fa fa-tasks','vcolumn'=>'1','vsort_order' => 999),
			'type'=>'catalog',
			'display'=>'dropdown',	
			'show_thumb'=>'1',	
			'show_icon'=>'1',	
			'desc_limit'=>'64',
			'mobile_visible'=>'',
			'count'=>0,	
			'status'=>'1'			
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
		
		$this->load->model('catalog/category');		
		$filter_data = array(
			'sort'  => 'name',
			'order' => 'ASC'
		);		
		$this->load->model('tool/image');
		$data['placeholder'] = $placeholder = $this->model_tool_image->resize('no_image.png', 60, 60);
		
		$data['catalog_categories'] = array();
		$catalog_categories = $this->model_catalog_category->getCategories($filter_data);
		
		foreach ($catalog_categories as $catalog_category) {
			$category_id = $catalog_category['category_id'];
			$img_query = $this->db->query("SELECT image FROM ".DB_PREFIX."category WHERE category_id = '".(int)$category_id."'");
			$image = 'no_image.png';
			if ($img_query->row['image']) {
					$image = $img_query->row['image'];
			}
			if (file_exists(DIR_IMAGE . $image)) {
				$thumb = $this->model_tool_image->resize($image, 80, 80);
			} else{
				$thumb = $this->model_tool_image->resize('no_image.png', 80, 80);
			}
			$data['catalog_categories'][] = array(
				'category_id' => $catalog_category['category_id'],
				'name'        => $catalog_category['name'],
				'sort_order'  => $catalog_category['sort_order'],
				'image'  	=> $thumb,
				'edit'        => $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $catalog_category['category_id'], 'SSL'),
			);
		}
		
				
		$data['content_categories'] = array();
		if($this->config->get('ave_confirm_installed')){
			$this->load->model('avethemes/category');		
			$content_categories = $this->model_avethemes_category->getCategories(0);
			
			foreach ($content_categories as $result) {
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 80, 80);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 80, 80);
				}
				$category_name = $this->model_avethemes_category->getPath($result['content_id']);
				
				$conditions =array(
					'faq',
					'category'
					);
				if(in_array($result['type'], $conditions)){
					$data['content_categories'][] = array(
						'content_id' => $result['content_id'],
						'name'        => $category_name,
						'image'      => $image,
						'icon'      => $result['icon'],
						'edit' => $this->url->link('ave/category/update', 'content_id=' . $result['content_id'].'&token=' . $this->session->data['token'], 'SSL')
					);
				}
				
			}
		}
		
		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['elements'] = $this->elements();
		$this_template = 'avethemes/module/custom_category.tpl';		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');;
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_custom_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	protected function elements() {
		$this->load->language('module/ave_custom_category');
		$elements[] = array(
			'label'  => $this->language->get('text_category_simple'),
			'value'  => 'category_simple'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_category_accordion'),
			'value'  => 'category_accordion'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_category_bootstrap'),
			'value'  => 'category_bootstrap'
		);
	
		return $elements;
	}
}
?>