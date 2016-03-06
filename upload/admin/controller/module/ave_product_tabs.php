<?php    
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProductTabs extends Controller {  	
	private $error = array(); 
	public function delete() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (isset($this->request->get['module_id']) && $this->user->hasPermission('modify', 'module/ave_product_tabs')) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->index();
	} 
	public function index() {
		$data['redirect'] = $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_product_tabs&token=' . $this->session->data['token'] , 'SSL');
		
		$language_data = $this->load->language('module/ave_product_tabs');
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
				$this->model_extension_module->addModule('ave_product_tabs', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['token'] = $this->session->data['token'];
		
		$data['module_data'] = array();
		$modules = $this->model_extension_module->getModulesByCode('ave_product_tabs');
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
								'delete'      => $this->url->link('module/ave_product_tabs/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
								'href'      => $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
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
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = false;
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
				'href' => $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'], 'SSL')
			);
		if (isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => 'Module ID: '.$this->request->get['module_id'],
				'href' => $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['module_id'] = 0;
			$data['action'] = $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['module_id'] = $this->request->get['module_id'];
			$data['action'] = $this->url->link('module/ave_product_tabs', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		$this->load->model('tool/image');	
		$data['placeholder'] = $no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		$image_width = $this->config->get('config_image_thumb_width');
		$image_height = $this->config->get('config_image_thumb_height');
		$popup_width = $this->config->get('config_image_popup_width');
		$popup_height = $this->config->get('config_image_popup_height');
		$description_limit = $this->config->get('config_product_description_length');				
		$form_configs = array(
			'custom_title'=>array(),
			'custom_description'=>array(),
			'name'=>'Product Tabs #',
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',	
			'tabs_status'=>array(
					'featured'=>'0',
					'bestseller'=>'0',
					'special'=>'0',
					'latest'=>'0',
					'most_viewed'=>'0',
					'popular'=>'0',
					'random'=>'0'
			),
			'product_sort'=>'featured,bestseller,special,latest,most_viewed,popular,random',
			'display'=>'product-tab-grid-carousel',	
			'custom_item'=>array(),
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
			'smartSpeed'=>900,
			'slideBy'=>3,
			'carousel_autoplay'=>'false',
			'image_width'=>$image_width,
			'image_height'=>$image_height,
			'popup_width'=>$popup_width,
			'popup_height'=>$popup_height,
			'description_limit'=>$description_limit,
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
		
		$data['products_sort'] = explode(',', $data['product_sort']);
		
		$this->load->model('catalog/product'); 		
		$products = $data['custom_item'] ;
		$data['products'] = array();
		if(is_array($products)){
			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
				if ($product_info) {
					$data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}	
		}
		 
		 
		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		
		$data['elements'] = $this->elements();
		$this_template = 'avethemes/module/product_tabs.tpl';		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');;
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_product_tabs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!$this->request->post['image_width'] || !$this->request->post['image_height']) {
			$this->error['image'] = $this->language->get('error_image');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	protected function elements() {
		$this->load->language('module/ave_product_tabs');
		$elements[] = array(
			'label'  => $this->language->get('text_product_carousel_grid'),
			'value'  => 'product-tab-grid-carousel'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_product_carousel_list'),
			'value'  => 'product-tab-list-carousel'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_product_grid'),
			'value'  => 'product-tab-grid'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_product_list'),
			'value'  => 'product-tab-list'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_sidebar_product'),
			'value'  => 'product-tab-sidebar'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_product_grid_desc'),
			'value'  => 'product-tab-grid-desc'
		);
		$elements[] = array(
			'label'  => $this->language->get('text_product_carousel_desc'),
			'value'  => 'product-tab-grid-carousel-desc'
		);
		return $elements;
	}
}
?>