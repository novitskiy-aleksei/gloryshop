<?php    
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveContentPostList extends Controller {   
	private $error = array(); 
	public function delete() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (isset($this->request->get['module_id']) && $this->user->hasPermission('modify', 'module/ave_content_post_list')) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->index();
	} 
	public function index() {
		$data['redirect'] = $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_content_post_list&token=' . $this->session->data['token'] , 'SSL');
		
		$language_data = $this->load->language('module/ave_content_post_list');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('heading_title'));		
		$data['rstatus'] = $this->ave->validate();
		$data['heading_title'] = $this->language->get('heading_title');
		$data['animations'] = $this->ave->getAnimations();
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('ave_content_post_list', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['token'] = $this->session->data['token'];
		$data['module_data'] = array();
		$modules = $this->model_extension_module->getModulesByCode('ave_content_post_list');
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
								'delete'      => $this->url->link('module/ave_content_post_list/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
								'href'      => $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
							);
					}
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
				'href' => $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'], 'SSL')
			);
		if (isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => 'Module ID: '.$this->request->get['module_id'],
				'href' => $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['module_id'] = 0;
			$data['action'] = $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['module_id'] = $this->request->get['module_id'];
			$data['action'] = $this->url->link('module/ave_content_post_list', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}	
		$this->load->model('tool/image');	
		$data['placeholder'] = $no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		$image_width = $this->config->get('ave_cms_gallery_details_image_width');
		$image_height = $this->config->get('ave_cms_gallery_details_image_height');	
		$description_limit = $this->config->get('ave_cms_content_description_limit');	
		$form_configs = array(
			'custom_title'=>array(),
			'name'=>'Content by Category #',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'display'=>'tab-post-grid',	
			'parent_id'=>array(),
			'sort_by'=>'p.date_added',
			'order_by'=>'DESC',
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
			'smartSpeed'=>900,
			'slideBy'=>3,
			'status'=>'1',
			'image_width'=>$image_width,
			'image_height'=>$image_height,
			'description_limit'=>$description_limit,
			'category_description_limit'=>$description_limit,
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => '',
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
		
		$this->load->model('avethemes/category');				
		$data['categories'] = $this->model_avethemes_category->getCategories(0);
		if(empty($data['parent_id'])){
			$data['categories_group'] = array();
		}else{
			$id_group= $data['parent_id'];
			$data['categories_group'] = $this->model_avethemes_category->getCategoryGroup($id_group);
		}
		
		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['elements'] = $this->elements();
		
		$this_template = 'avethemes/module/content_post_list.tpl';		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');;
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_content_post_list')) {
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
		$this->load->language('module/ave_content_post_list');
		$elements[] = array(
			'label'  => $this->language->get('text_tab_post_grid'),
			'value'  => 'tab-post-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_tab_post_grid_carousel'),
			'value'  => 'tab-post-grid-carousel'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_tab_project_grid'),
			'value'  => 'tab-project-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_tab_gallery_grid'),
			'value'  => 'tab-gallery-grid'
		);
		
		$elements[] = array(
			'label'  => $this->language->get('text_post_grid'),
			'value'  => 'post-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_post_list'),
			'value'  => 'post-list'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_column_list'),
			'value'  => 'post-column-list'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_project_grid'),
			'value'  => 'project-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_gallery_grid'),
			'value'  => 'gallery-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_carousel_grid'),
			'value'  => 'post-carousel-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_carousel_list'),
			'value'  => 'post-carousel-list'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_project_carousel'),
			'value'  => 'project-carousel'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_gallery_carousel'),
			'value'  => 'gallery-carousel'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_post_grid_desc'),
			'value'  => 'post-grid-desc'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_carousel_grid_desc'),
			'value'  => 'post-carousel-grid-desc'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_project_grid_desc'),
			'value'  => 'project-grid-desc'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_project_carousel_desc'),
			'value'  => 'project-carousel-desc'
		);
		return $elements;
	}
}
?>