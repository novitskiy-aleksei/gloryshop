<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avetheme.com
 * @copyright	Copyright (C) January 2015 www.avetheme.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerFeedVisualLayoutBuilder extends Controller {
	private $error = array();
	private $controllers=array(
					'layout_builder'		=>'feed/visual_layout_builder',
					'article'		=>'ave/article',
					'author'		=>'ave/author',
					'category'		=>'ave/category',
					'contact'		=>'ave/contact',
					'comment'		=>'ave/comment',
					'dashboard'		=>'ave/dashboard',
					'download'		=>'ave/download',
					'image_manager'	=>'ave/image_manager_plus',
					'newsletter'	=>'ave/newsletter',
					'ocmod_manager'	=>'ave/ocmod_manager',
					'poll'			=>'ave/poll',
					'quote'			=>'ave/quote',
					'revo_slider'	=>'ave/slider_revolution',
					'keyword'		=>'ave/seo_keyword',
					'service'		=>'ave/service',
					'shortcut'		=>'ave/shortcut_route',
					'skin'			=>'ave/skin',
					'testimonial'	=>'ave/testimonial',
					'custom_footer'	=>'ave/custom_footer'
		);
	public function menu() {
		$data['ave_confirm_installed'] = $this->config->get('ave_confirm_installed');
		if(defined('ave_check')){
			$data['ave_validate'] = $this->ave->validate();
		}else{
			$data['ave_validate'] = false;	
		}
		$data['ave_installed'] = $this->config->get('ave_installed');
		$language_data = $this->load->language('avethemes/shortcut');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		foreach ($this->controllers as $controller=>$route) {
			$data[$controller] = $this->url->link($route, 'token=' . $this->session->data['token'], 'SSL');
		}
		$data['token'] = $this->session->data['token'];
		$this_template = 'avethemes/editor/menu.tpl';
		return $this->load->view($this_template, $data);
	}
	public function delete_module() {
		$this->load->language('feed/visual_layout_builder');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');
		$this->load->model('avethemes/layout');		
		
		$this->session->data['success'] = $this->language->get('text_success');
		$message = false;
		$message_data = '';
		if (isset($this->request->post['selected']) && $this->user->hasPermission('modify', 'extension/module')) {
			foreach ($this->request->post['selected'] as $module_id) {
				
				$module_info = $this->model_avethemes_layout->getModuleInfo($module_id);
				if($module_info){
					$layout_code = $module_info['code'].'.'.$module_id;
					$layout_total = $this->model_avethemes_layout->getTotalLayoutByCode($layout_code);

					if ($layout_total) {
						$message[$layout_code] = sprintf($this->language->get('error_layout_module'), $module_info['name'], $layout_total);
					}else{
						$this->model_extension_module->deleteModule($module_id);
						$message[$layout_code] = sprintf($this->language->get('success_delete_module'), $module_info['name'], $module_id);
					}
					
				}
				
			}
			if(is_array($message)){
				$message_data = '<ul><li>'.implode("</li><li>", $message).'</li></ul>';
			
			}
			$this->session->data['success'] = $message_data;

		}else{
			$this->session->data['success'] = $this->language->get('error_permission');
		}

		$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function index() {
		$this->checkPermission();
		$this->getList();
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
	public function quickadd(){ 
		$this->load->language('feed/visual_layout_builder');
		$name = 'BLANK MODULE';
		$allows = $this->allow_quickadd;
		
		$image_width = $this->config->get('config_image_thumb_width');
		$image_height = $this->config->get('config_image_thumb_height');
		$popup_width = $this->config->get('config_image_popup_width');
		$popup_height = $this->config->get('config_image_popup_height');
		$description_limit = $this->config->get('config_product_description_length');
		$form['bestseller'] = array(
            'name' => 'Bestseller - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
            'products' => array (),
            'limit' => 6,
            'width' => $image_width,
            'height' => $image_width,
		);
		$form['featured'] = array(
            'name' => 'Featured - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
            'products' => array (),
            'limit' => 6,
            'width' => $image_width,
            'height' => $image_width,
		);
		
		$form['latest'] = array(
            'name' => 'Latest - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
            'products' => array (),
            'limit' => 6,
            'width' => $image_width,
            'height' => $image_width,
		);
		
		$form['special'] = array(
            'name' => 'Special - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
            'products' => array (),
            'limit' => 6,
            'width' => $image_width,
            'height' => $image_width,
		);
		$form['html'] = array(
            'name' => 'HTML - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
            'module_description' => array (1=>'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.')
		);
		$form['ave_content_post_list'] = array(
			'name'=>'Post by Category - '.$name,
			'status'=>'1',
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
			'image_width'=>320,
			'image_height'=>320,
			'description_limit'=>150,
			'category_description_limit'=>150,
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => '',
		);
		$form['ave_content_tabs'] = array(
			'custom_title'=>array(),
			'custom_description'=>array(),
			'name'=>'Aside Tabs #',
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',	
			'tabs_status'=>array(
					'featured'=>'0',
					'latest'=>'0',
					'most_viewed'=>'0',
					'random'=>'0'
			),
			'article_sort'=>'featured,latest,most_viewed,random',
			'display'=>'post-tabs-sidebar',	
			'post_type'=>'blog',	
			'custom_item'=>array(),
			
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
			'carousel_autoplay'=>'false',
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => ''
		);
		$form['ave_content_post_type'] = array(
			'name'=>'Post by Type - '.$name,
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'display'=>'tab-post-grid',	
			'article_type'=>'recent_article',
			'post_type'=>'blog',
			'link_type'=>'link',
			'custom_title'=>array(),
			'custom_description'=>array(),
			'custom_item'=>array(),
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
			'description_limit'=>64,
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => '',
		);
		$module_description[0]['description'] = 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.';
		$module_description[1]['description'] = 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.';
		$module_description[2]['description'] = 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.';
		$form['ave_custom_html'] =array(
			'name'=>'Custom HTML ',
			'status'=>'1',
			'element'=>'',
			'module_description'=>$module_description
		);
		$form['ave_shortcodes'] = array(
            'name' => 'Shortcodes - '.$name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'element'=>'section_title',//section_title
            'display' => '',
            'display_type' => '',
            'display_style' => '',
            'grid_limit' => '3',
            'carousel_limit' => '3',
            'title' => array (1=>'Any title'),
            'skill_title' => array (1=>'Our skill'),
            'desc_position' => 'left',
            'description' => array (1=>'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.'),
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => '',
            'sections' => array('title_color'=>'#fff','show_icon'=>1)
		);
		
		$form['ave_product'] =array(
			'name'=>'Product by Type - '.$name,
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'display'=>'product-carousel-grid',	
			'product_type'=>'recent_product',
			'custom_title'=>array(),
			'custom_description'=>array(),
			'custom_item'=>array(),
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
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
		$form['ave_product_list'] =array(
			'name'=>'Product by Category - '.$name,
			'status'=>'1',
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'display'=>'product-carousel-grid',	
			'parent_id'=>array(),
			'sort_by'=>'p.date_added',
			'order_by'=>'DESC',
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
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
		$form['ave_product_tabs'] = array(
			'name'=>'Product Tabs - '.$name,
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
			'custom_description'=>array(),
			'custom_item'=>array(),
			'limit'=>6,
			'grid_limit'=>4,
			'num_row'=>1,
			'carousel_nav'=>'top',
			'carousel_limit'=>3,
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
		$json = array();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')&&isset($this->request->get['code'])&&$this->validate()) {
				$code = $this->request->get['code'];
			if(isset($form[$code])&&$this->user->hasPermission('modify', 'module/'.$code)){
				$this->load->model('extension/module');
				$this->model_extension_module->addModule($code,$form[$code]);
				$module_id = $this->db->getLastId();
				$json['success'] = $this->language->get('text_success');
				$json['text'] = $module_id.' - '.$name;
				$json['code'] = $code.'.'.$module_id;
				$json['href'] =  str_replace('&amp;', '&', $this->url->link('module/'.$code,'token='. $this->session->data['token'].'&module_id='.$module_id));		
			}else{
				$this->load->language('module/' . $code);
				$json['error'] = sprintf($this->language->get('error_quickadd'), $this->language->get('heading_title'));
			}
			
		}
		if (isset($this->error['warning'])) {
			$json['error'] = $this->error['warning'];
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function import_layout() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('avethemes/layout');	
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&& $this->validate()) {
				$layout_id = 0;
				$layout_exists = 0;
				if(isset($this->request->get['layout_id'])){
					$layout_id = $this->request->get['layout_id'];
					$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."layout WHERE `layout_id` = '" . (int)$layout_id. "'");		
					$layout_exists = $query->row['total'];
				}
				$layouts = array();
				if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					$layouts = $this->ave->parseJson(file_get_contents($this->request->files['import']['tmp_name']),'i');
				}
				if(!empty($layouts)){
					//checklayout exist
					foreach($layouts as $layout){
						if(!empty($layout)){
							
						}
					}	
					//delete layout module installeds
					if($layout_exists>0){
						$this->db->query("DELETE FROM ".DB_PREFIX."layout_module WHERE `layout_id` = '" .(int)$layout_id . "'");
					}else{
						//Add new
						$new_layout_name = 'New import layout';
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = '" . $this->db->escape($new_layout_name) . "'");
						$layout_id = $this->db->getLastId();
					}
					//Insert module to layout
					foreach($layouts as $layout){
						if(!empty($layout)){
							//Update
							$this->db->query("INSERT INTO ".DB_PREFIX."layout_module SET 
							`layout_id` = '" .(int)$layout_id . "', 
							`code` = '" . $this->db->escape($layout['code']) . "', 
							`position` = '" . $this->db->escape($layout['position']) . "',
							`sort_order` = '" . (int)$layout['sort_order'] . "'");
						}
					}		/* */
					$this->session->data['success'] =  $this->language->get('text_success_import_module');
					$redirect = $this->url->link('feed/visual_layout_builder','token=' . $this->session->data['token'] . '&layout_id=' .$layout_id);
				}else{
					$redirect = $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL');	
					$this->session->data['success'] = $this->language->get('error_import_module');
				}
		}else{
			$redirect = $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL');
		}		  	
		$this->response->redirect($redirect);
	}
  	public function export_layout() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('avethemes/layout');		
		
		if (isset($this->request->get['layout_id'])&& $this->validate()) {
			$layout_id = 0;
			if(isset($this->request->get['layout_id'])){
				$layout_id = $this->request->get['layout_id'];
			}
			$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."layout_module WHERE  `layout_id` = '" . (int)$layout_id. "'");		
			$code_exists = $query->row['total'];
			if (!$code_exists) {
	  			$this->session->data['success'] = $this->language->get('error_layout_data');
				$this->response->redirect($this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL'));
			}else{	
				$export_data = array();
				$layout_info = $this->model_avethemes_layout->getLayout($layout_id);
				$layout_data = $this->model_avethemes_layout->getLayoutModules($layout_id);
				if ($layout_data) {	
					$export_data = $layout_data;
				}
				$export_output = $this->ave->parseJson($export_data,'e');
				
				$this->response->addHeader('Pragma: public');
				$this->response->addHeader('Expires: 0');
				$this->response->addHeader('Content-Description: File Transfer');
				$this->response->addHeader('Content-Type: application/octet-stream');
				$this->response->addHeader('Content-Disposition: attachment; filename=Layout_'.$layout_id.'-'.$layout_info['name'].'_export.json');
				$this->response->addHeader('Content-Transfer-Encoding: binary');
				$this->response->setOutput($export_output);
				$this->session->data['success'] =  $this->language->get('text_success_export_layout');
			}
    	}else{
			$this->response->redirect($this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
	
	public function import_setting() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('avethemes/layout');	
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&& $this->validate()) {
				$settings = array();
				if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					$settings = $this->ave->parseJson(file_get_contents($this->request->files['import']['tmp_name']),'i');
				}
				if(!empty($settings)){
					foreach($settings as $setting){
						if(!empty($setting)){
							$this->db->query("DELETE FROM ".DB_PREFIX."setting WHERE `code` = '" . $this->db->escape($setting['code']) . "' AND `key` = '" .$this->db->escape($setting['key']) . "' AND `store_id` = '" .(int)$setting['store_id'] . "'");
							
							$this->db->query("INSERT INTO ".DB_PREFIX."setting SET 
							`store_id` = '" . $this->db->escape($setting['store_id']) . "', 
							`code` = '" . $this->db->escape($setting['code']) . "', 
							`key` = '" . $this->db->escape($setting['key']) . "',
							`value` = '" . $this->db->escape($setting['value']) . "',  
							`serialized` = '" . $this->db->escape($setting['serialized']) . "'");
						}
					}
					$this->session->data['success'] =  $this->language->get('text_success_import_module');
					$redirect = $this->request->post['redirect'];
				}else{
					$redirect = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');	
					$this->session->data['success'] = $this->language->get('error_import_module');
				}
		}else{
			$redirect = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		}		  	
		$this->response->redirect($redirect);
	}
  	public function export_setting() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('setting/setting');		
		
		if (isset($this->request->get['code'])&& $this->validate()) {
			$code = 0;
			if(isset($this->request->get['code'])){
				$code = $this->request->get['code'];
			}
			$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."setting WHERE  `code` = '" . $this->db->escape($code). "'");		
			$code_exists = $query->row['total'];
			if (!$code_exists) {
	  			$this->session->data['success'] = sprintf($this->language->get('error_setting_data'), $code);
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}else{	
				$export_data = array();
				$setting_data = $this->db->query("SELECT * FROM ".DB_PREFIX."setting WHERE `code` = '" .$this->db->escape($code). "'");
				$output=array();
				if ($setting_data->num_rows) {	
					foreach ($setting_data->rows as $result) {
						$output[$result['setting_id']] = array(
							'store_id'      => $result['store_id'],
							'code'       	=> $result['code'],
							'key'       	=> $result['key'],
							'value'       	=> $result['value'],
							'serialized' 	=> 	$result['serialized']
						);
					}
					$export_data = $output;
				}
				$export_output = $this->ave->parseJson($export_data,'e');
			
				$this->response->addHeader('Pragma: public');
				$this->response->addHeader('Expires: 0');
				$this->response->addHeader('Content-Description: File Transfer');
				$this->response->addHeader('Content-Type: application/octet-stream');
				$this->response->addHeader('Content-Disposition: attachment; filename=Setting_'.$code.'.json');
				$this->response->addHeader('Content-Transfer-Encoding: binary');
				$this->response->setOutput($export_output);
				$this->session->data['success'] =  sprintf($this->language->get('text_success_export_setting'),$code);
			}
    	}else{
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
  	public function import_module() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('avethemes/layout');	
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&& $this->validate()) {
				$modules = array();
				if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					$modules = $this->ave->parseJson(file_get_contents($this->request->files['import']['tmp_name']),'i');
				}
				if(!empty($modules)){
					foreach($modules as $module){
						$this->model_avethemes_layout->importModule($module);	
					}
					$this->session->data['success'] =  sprintf($this->language->get('text_success_import_module'));
					$redirect = $this->request->post['redirect'];
				}else{
					$redirect = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');	
					$this->session->data['success'] = $this->language->get('error_import_module');
				}
		}else{
			$redirect = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		}		  	
		$this->response->redirect($redirect);
	}
  	public function export_module() {	
		$this->load->language('feed/visual_layout_builder');
		$this->load->model('avethemes/layout');
		$this->load->model('extension/module');		
		
		if (isset($this->request->get['code'])&& $this->validate()) {
			$code = 0;
			if(isset($this->request->get['code'])){
				$code = $this->request->get['code'];
			}
  			$code_exists = $this->model_avethemes_layout->checkModule($code);
			if (!$code_exists) {
				$this->load->language('module/' . $code);
	  			$this->session->data['success'] = sprintf($this->language->get('error_module_data'), $this->language->get('heading_title'));
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}else{	
			
			$export_data = array();
			$modules_data = $this->model_extension_module->getModulesByCode($code);
			if (!empty($modules_data)) {	
				$export_data = $modules_data;
			}
			$export_output = $this->ave->parseJson($export_data,'e');
			
				$this->response->addHeader('Pragma: public');
				$this->response->addHeader('Expires: 0');
				$this->response->addHeader('Content-Description: File Transfer');
				$this->response->addHeader('Content-Type: application/octet-stream');
				$this->response->addHeader('Content-Disposition: attachment; filename=Module_'.$code.'.json');
				$this->response->addHeader('Content-Transfer-Encoding: binary');
				$this->response->setOutput($export_output);
				$this->load->language('module/' . $code);
				$this->session->data['success'] =  sprintf($this->language->get('text_success_export_module'), $this->language->get('heading_title'));
			}
    	}else{
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
	public function apply(){
		$this->load->language('feed/visual_layout_builder');
		$json = array();
		$this->load->model('avethemes/layout');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()){
			if(isset($this->request->post['layout_id'])&&$this->request->post['layout_id']!=0){				
				$this->model_avethemes_layout->editLayout($this->request->post['layout_id'], $this->request->post);
			}else{
				$this->session->data['success'] = $this->language->get('text_success');
				$layout_id = $this->model_avethemes_layout->addLayout($this->request->post);
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('feed/visual_layout_builder','token=' . $this->session->data['token'] . '&layout_id=' .$layout_id));
			}
			$json['success'] = $this->language->get('text_success');
		}else{
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			}
			if (isset($this->error['name'])) {
				$json['error'] = $this->error['name'];
			} 
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function saveoption(){
		$this->load->language('feed/visual_layout_builder');
		$json = array();
		$this->load->model('setting/setting');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
			$this->model_setting_setting->editSetting('layout_builder', $this->request->post);		
			$json['success'] = $this->language->get('text_option_success');
			if(isset($this->request->post['layout_id'])&&$this->request->post['layout_id']!=0){
				$layout_id = $this->request->post['layout_id'];
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('feed/visual_layout_builder','token=' . $this->session->data['token'] . '&layout_id=' .$layout_id));
			}
		}else{
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			}
		} 
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function delete() {
		$this->load->language('feed/visual_layout_builder');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/layout');
			$url = '';

		$error = false;
		if (!$this->user->hasPermission('modify', 'feed/visual_layout_builder')) {
				$error = true;
			$this->session->data['warning']['error_permission'] = $this->language->get('error_permission');
		}
		$this->load->model('setting/store');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/information');

		if (isset($this->request->get['layout_id'])) {
			$url .= '&layout_id=' . $this->request->get['layout_id'];
			$layout_id = $this->request->get['layout_id'];
			
			if ($this->config->get('config_layout_id') == $layout_id) {
				$error = true;
				$this->session->data['warning']['error_default'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresByLayoutId($layout_id);

			if ($store_total) {
				$error = true;
				$this->session->data['warning']['error_store'] = sprintf($this->language->get('error_store'), $store_total);
			}

			$product_total = $this->model_catalog_product->getTotalProductsByLayoutId($layout_id);

			if ($product_total) {
				$error = true;
				$this->session->data['warning']['error_product'] = sprintf($this->language->get('error_product'), $product_total);
			}

			$category_total = $this->model_catalog_category->getTotalCategoriesByLayoutId($layout_id);

			if ($category_total) {
				$error = true;
				$this->session->data['warning']['error_category'] = sprintf($this->language->get('error_category'), $category_total);
			}

			$information_total = $this->model_catalog_information->getTotalInformationsByLayoutId($layout_id);

			if ($information_total) {
				$error = true;
				$this->session->data['warning']['error_information'] = sprintf($this->language->get('error_information'), $information_total);
			}
		}
		

	
		
		if (isset($this->request->get['layout_id']) && $error == false) {
			$url = '';
			$layout_id = $this->request->get['layout_id'] ;
			$this->model_avethemes_layout->deleteLayout($layout_id);

			$this->session->data['success'] = $this->language->get('text_success');

		}
			
		$this->response->redirect($this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		

	}

	protected function getList() {
		$this->load->model('avethemes/layout');
		$language_data = $this->load->language('feed/visual_layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
		if(defined('ave_check')){
			$data['rstatus'] = $this->ave->validate();
		}else{
			$this->integratedEditor(1);
			$this->response->redirect($this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->document->addStyle('../assets/editor/css/form.css');
		$this->document->addScript('../assets/editor/js/form.js');
  		$this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js');
		$this->document->addScript('../assets/editor/js/lib_layout.js');
				
		$data['redirect'] = $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$data['skin_layout_builder_show_option'] = $this->config->get('skin_layout_builder_show_option');
		$data['skin_layout_builder_preview_urls'] = $this->config->get('skin_layout_builder_preview_urls');
		$data['module_list'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$layouts = $this->model_avethemes_layout->getLayouts();

		foreach ($layouts as $layout) {
			$data['layouts'][] = array(
				'layout_id' => $layout['layout_id'],
				'name'      => $layout['name'],
				'edit'      => $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'] . '&layout_id=' . $layout['layout_id'] , 'SSL')
			);
		}

		$language_data = $this->load->language('feed/visual_layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		
		$data['text_form'] = $this->language->get('heading_title');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = '<ul><li>'.implode("</li><li>", $this->session->data['warning']).'</li></ul>';
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		
		$url = '';

		if (isset($this->request->get['layout_id'])) {
			$url .= '&layout_id=' . $this->request->get['layout_id'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		

		$data['add'] = $this->url->link('feed/visual_layout_builder','&layout_id=0&token=' . $this->session->data['token'] , 'SSL');
		$data['action'] = $data['cancel'] = $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['add_module'] = $this->url->link('feed/visual_layout_builder/modules', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['layout_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$layout_info = $this->model_avethemes_layout->getLayout($this->request->get['layout_id']);			
			$data['layout_id'] = $layout_id =  $this->request->get['layout_id'];
		}elseif(!isset($this->request->get['layout_id'])){
			$layout_info = $this->model_avethemes_layout->getLayout(1);			
			$data['layout_id'] = $layout_id =  1;
		}
			$data['delete'] = false;
			$data['export_layout'] = false;
			$data['import_layout'] = $this->url->link('feed/visual_layout_builder/import_layout', 'token=' . $this->session->data['token'], 'SSL');
		if($layout_id){
			$data['delete'] = $this->url->link('feed/visual_layout_builder/delete', 'token=' . $this->session->data['token']. '&layout_id=' . $layout_id , 'SSL');
			$data['import_layout'] = $this->url->link('feed/visual_layout_builder/import_layout', '&layout_id=' .$layout_id .'&token=' . $this->session->data['token'] , 'SSL');
			$data['export_layout'] = $this->url->link('feed/visual_layout_builder/export_layout', '&layout_id=' .$layout_id .'&token=' . $this->session->data['token'] , 'SSL');
			$data['redirect'] = $this->url->link('feed/visual_layout_builder', 'layout_id=' .$layout_id .'&token=' . $this->session->data['token'] , 'SSL');
		}
		
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($layout_info)) {
			$data['name'] = $layout_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		
		if (isset($this->request->post['layout_route'])) {
			$data['layout_routes'] = $this->request->post['layout_route'];
		} elseif (isset($this->request->get['layout_id'])) {
			$data['layout_routes'] = $this->model_avethemes_layout->getLayoutRoutes($this->request->get['layout_id']);
		} else {
			$data['layout_routes'] = $this->model_avethemes_layout->getLayoutRoutes(1);
		}
		
		$data['extensions'] = $this->list_modules();
		
		if (isset($this->request->post['layout_module'])) {
			$layout_modules_data = $this->request->post['layout_module'];
		} elseif (isset($layout_id)) {
			$layout_modules = $this->model_avethemes_layout->getLayoutModules($layout_id);
			$layout_modules_data = array();
			foreach ($layout_modules as $layout_module) {
						$module_id = '';
					$part = explode('.', $layout_module['code']);
					if(!isset($part[0])){
						$href = $this->url->link('module/' . $layout_module['code'], 'token=' . $this->session->data['token'], 'SSL');
					}elseif (isset($part[0]) && !isset($part[1])) {						
						$href = $this->url->link('module/' . $part[0], 'token=' . $this->session->data['token'], 'SSL');
					}else{						
						$module_id = $part[1];
						$href = $this->url->link('module/' . $part[0], 'token=' . $this->session->data['token'] . '&module_id=' . $part[1], 'SSL');
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
		} else {
			$layout_modules_data = array();
		}	
		$data['layout_modules'] = 	$layout_modules_data;
		
					
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('avethemes/layout/layout_form.tpl', $data));
	}
	public function module_title($code){
		$return = '';
		$part = explode('.', $code);
		if (isset($part[0])){
			$this->load->language('module/' . $part[0]); 
		}else{
			$this->load->language('module/' . $code); 
		}
		$return = $this->language->get('heading_title');
		
		return $return;
		
	}
	public function module_name($code){
		$return = '';
		$part = explode('.', $code);
		if (isset($part[0])){
			$this->load->language('module/' . $part[0]); 
		}else{
			$this->load->language('module/' . $code); 
		}
		if (isset($part[0]) && !isset($part[1])) {
			$return = $this->language->get('heading_title');
		}else{		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$part[1] . "'");
			if ($query->row) {
				$return = $query->row['name'];
			} 
		}
		return $return;
		
	}
	public function module_refresh(){
		$language_data = $this->load->language('feed/visual_layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$data['extensions'] = $this->list_modules();
		
		$this->response->setOutput($this->load->view('avethemes/layout/module_refresh.tpl', $data));
		
	}
	public function modules() {		
	
		$this->document->addScript('../assets/editor/js/form.js');
  		$this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js');
		$this->document->addScript('../assets/editor/js/lib_layout.js');
		$language_data = $this->load->language('feed/visual_layout_builder');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$data['position'] = 'content_top';
		if (isset($this->request->get['position'])) {
			$data['position'] = $this->request->get['position'];
		}
		
		$data['extensions'] = $this->list_modules();
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('avethemes/layout/modules.tpl', $data));
	}
	private function list_modules(){
		error_reporting(0); 
		$language_data = $this->load->language('feed/visual_layout_builder');
		
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$list_modules = array();
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
		
		$allows = $this->allow_quickadd;
		$ave_modules = array('ave_content_post_list','ave_content_post_type','ave_product','ave_product_list','ave_product_tabs','ave_shortcodes','ave_sliderbanner');
		
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			//only list catalog modules
			if (file_exists(DIR_CATALOG . 'controller/module/' . $code . '.php')) {	
				$module_add = true;
				$quick_add = false;
				$quick_href = $this->url->link('feed/visual_layout_builder/quickadd', 'token=' . $this->session->data['token']. '&code=' . $code, 'SSL');
				$thumb = false;
				$has_data = false;
				$this->load->language('module/' . $code);
			
				
				$module_data = array();
				
				$modules = $this->model_extension_module->getModulesByCode($code);
				if(!empty($modules)){
					$quick_add = in_array($code,$allows)?true:false;
					$has_data = true;
					foreach ($modules as $module) {
							 if(in_array($code,$ave_modules)){
								 if(is_array($setting = $this->ave->decodeSetting($module['setting']))){
									$thumb = (isset($setting['display']))?'../assets/editor/img/mockup/'.$setting['display'].'.png':false; 
								 }
							 }
							$module_data[] = array(
								'name' => ' &raquo; ' . $module['name'],
								'thumb' => $thumb,
								'code' => $code . '.' .  $module['module_id'],
								'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
							);
					}
				}else{
					if($this->config->has($code . '_status')){
						$module_add = false;
						$module_data[] = array(
							'name' => $this->language->get('heading_title'),
							'thumb' => $thumb,
							'code' => $code,
							'edit'      => $this->url->link('module/' . $code . '', 'token=' . $this->session->data['token'], 'SSL'),
						);
					}
				}
				$list_modules[$code] = array(
					'add'   => $module_add,
					'quick_add'   => $quick_add,
					'quick_href'   => $quick_href,
					'name'   => $this->language->get('heading_title'),
					'code'   => $code,
					'edit'      => $this->url->link('module/' . $code, 'token=' . $this->session->data['token'], 'SSL'),
					'module' => $module_data,
					'has_data'   => $has_data,
					'export'      => $this->url->link('feed/visual_layout_builder/export_module', 'code='.$code.'&token=' . $this->session->data['token'], 'SSL')
				);
			}
		}
		return $list_modules;
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/visual_layout_builder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'feed/visual_layout_builder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		return !$this->error;
	}

	public function install() {
		$this->load->language('feed/visual_layout_builder');
		$this->integratedEditor(1); 
		 
		$this->db->query("ALTER TABLE  `" . DB_PREFIX. "layout_module` CHANGE `position` `position` VARCHAR(32)");
		$this->db->query("UPDATE `" . DB_PREFIX. "category_description` SET `meta_title`=`name` WHERE `meta_title` IS NULL");
		$this->db->query("UPDATE `" . DB_PREFIX. "information_description` SET `meta_title`=`title` WHERE `meta_title` IS NULL");
		$this->db->query("UPDATE `" . DB_PREFIX. "product_description` SET `meta_title`=`name` WHERE `meta_title` IS NULL");
		$missing_fields = array();
		//Create missing field
		$missing_fields[] = array('table'=>'category','field'=>'display','attr'=>"varchar(64) COLLATE utf8_general_ci DEFAULT 'multi_level'");
		
		foreach($missing_fields as $key=>$value){
			$this->checkField($value);
		}
		//Overwrite image size
		$image_sizes = array(
			'config_product_count'=>0,
			'config_product_description_length'=>200,
			'config_image_category_width'=>320,
			'config_image_category_height'=>320,
			'config_image_thumb_width'=>500,
			'config_image_thumb_height'=>600,
			'config_image_popup_width'=>500,
			'config_image_popup_height'=>600,
			'config_image_additional_width'=>500,
			'config_image_additional_height'=>600,		
			'config_image_product_width'=>300,
			'config_image_product_height'=>360,		
			'config_image_related_width'=>300,
			'config_image_related_height'=>360,		
			'config_image_compare_width'=>150,
			'config_image_compare_height'=>180,		
			'config_image_wishlist_width'=>150,
			'config_image_wishlist_height'=>180,		
			'config_image_cart_width'=>50,
			'config_image_cart_height'=>60
		);
		/*Fix Cache Size*/ 
		
		 foreach ($image_sizes as $conf_key=>$conf_value) { 		 
		$this->db->query("UPDATE `" . DB_PREFIX. "setting` SET value = '".(int)$conf_value."' WHERE `key` = '".$this->db->escape($conf_key)."'");	
		 }
		
		
		$this->db->query("UPDATE `" . DB_PREFIX. "setting` SET value = 'enar' WHERE `key` = 'config_template'");	
		
		$this->load->model('setting/setting');		
		$this->model_setting_setting->editSetting('ave_newsletter', array(
			'ave_newsletter_unsubscribe' => 1,
			'ave_ave_newsletter_mail_status' => 0,
			'ave_newsletter_registered' => 1
		));
		$budgets = unserialize('a:9:{i:0;a:2:{s:5:"value";s:1:"0";s:5:"label";s:9:"- None - ";}i:1;a:2:{s:5:"value";s:3:"200";s:5:"label";s:13:"Less than 200";}i:2;a:2:{s:5:"value";s:3:"300";s:5:"label";s:11:"$200 - $300";}i:3;a:2:{s:5:"value";s:3:"500";s:5:"label";s:11:"$300 - $500";}i:4;a:2:{s:5:"value";s:4:"1000";s:5:"label";s:12:"$500 - $1000";}i:5;a:2:{s:5:"value";s:4:"2000";s:5:"label";s:13:"$1000 - $2000";}i:6;a:2:{s:5:"value";s:4:"5000";s:5:"label";s:13:"$2000 - $5000";}i:7;a:2:{s:5:"value";s:5:"10000";s:5:"label";s:14:"$5000 - $10000";}i:8;a:2:{s:5:"value";s:7:"notsure";s:5:"label";s:15:"Not sure yet...";}}');
			
		$this->model_setting_setting->editSetting('request_quote', array('request_quote_budgets'=>$budgets));
		$this->session->data['success'] =  $this->language->get('text_success_install');
		/*Import XML*/ 
		$this->load->model('avethemes/global');		
		$files = $this->getXml();
		foreach($files as $file){
			$this->model_avethemes_global->importXML($file['file']);
		}
		$this->checkPermission();
		$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'));
		
	}
	private function getXml() {
		$oc_ver =  substr((string)str_replace('.','',VERSION),0,3);
		$xlms = array();
		$xlms[] = array(
			'file' => DIR_APPLICATION .  'view/template/avethemes/xml/ave.ocmod.xml',
			'code'=>'ave_integrated'
		);
		if (file_exists(DIR_APPLICATION .  'view/template/avethemes/xml/ave_'.$oc_ver.'.ocmod.xml')) {
			$xlms[] = array(
				'file' =>DIR_APPLICATION .  'view/template/avethemes/xml/ave_'.$oc_ver.'.ocmod.xml',
				'code'=>'ave_'.$oc_ver.'_integrated'
			);
		}
		return $xlms;
	}
	public function uninstall() {
		$this->load->model('avethemes/global');		
		$files = $this->getXml();
		foreach($files as $file){
			$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%".$file['code']."%'");
		}
		$this->db->query("DELETE FROM `" . DB_PREFIX. "setting` WHERE `key` = 'skin_imported'");
		$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'layout_builder'");	
		$this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	protected function checkPermission() {		
		
		$this->load->model('user/user_group');	
		foreach ($this->controllers as $controller=>$route) {
			if (!$this->user->hasPermission('modify', $route)) {
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', $route);
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', $route);	
			}
		}
		if(!defined('ave_check')){
				$this->integratedEditor(1); 		
		}	
	}
	protected function integratedEditor($remove){
$actions=array();
$actions[]=array(
'files'	=> array('index.php'),
'handles'	=>array(
		array(
						'original'	=>'// Router',
						'replace'	=>'/*@AVE Integrated*/
if (file_exists(DIR_SYSTEM.\'avethemes/core.php\')) {
	include_once(DIR_SYSTEM.\'avethemes/core.php\');
	$ave = new Ave($config,$request,$db);
	$registry->set(\'ave\',$ave);
	$ave->init(\'oc\');	
}
// Router',
						'keyword'=>'AVE Integrated')
)
);		
$actions[]=array(
'files'	=> array('../index.php'),
'handles'	=>array(
	array(
		'original'	=>'// Maintenance Mode',
		'replace'	=>'/*@AVE Integrated*/
if (file_exists(DIR_SYSTEM.\'avethemes/core.php\')) {
	include_once(DIR_SYSTEM.\'avethemes/core.php\');
	$ave = new Ave($config,$request,$db);
	$registry->set(\'ave\',$ave);
	$ave->init(\'oc\');
	$controller->addPreAction(new Action(\'avethemes/common\'));	
}
// Maintenance Mode',
	'keyword'=>'AVE Integrated'),
		array(
			'original'	=>'$controller->addPreAction(new Action(\'common/seo_url\'));',
			'replace'	=>'/*@AVE SEO_URL*/
if ($config->get(\'skin_seo_optimize\')==\'1\') {
	$controller->addPreAction(new Action(\'content/seo_url\'));	
}else{
	$controller->addPreAction(new Action(\'common/seo_url\'));	
}',
		'keyword'=>'AVE SEO_URL'),
		array(
			'original'	=>'<?php',
			'replace'	=>'<?php
$starttime = explode(\' \',microtime());
define(\'ave_start_time\', $starttime[\'1\'] + $starttime[\'0\']);
if(isset($_SERVER[\'HTTP_ACCEPT_ENCODING\'])&&substr_count($_SERVER[\'HTTP_ACCEPT_ENCODING\'], \'gzip\')){ob_start("ob_gzhandler");}else{ob_start();}
/*AVE check performance*/',
		'keyword'=>'AVE check performance'
	),
		array(
			'original'	=>'$response->output();',
			'replace'	=>'$response->output();
ob_end_flush();
/*AVE increase speed*/',
			'keyword'=>'AVE increase speed')
)
);	
		$this->load->model('avethemes/global');		
		$this->model_avethemes_global->handleIntegrated($actions,$remove);
	}	
	/********************************************************/
	/*      	. Create Field If Not Exists				*/
	/********************************************************/
	protected function checkField($param) {	
		$exists = false;
		$query=$this->db->query("SHOW columns FROM `".DB_PREFIX.$param['table']."`");	
		foreach($query->rows as $column){
			if($column['Field'] == $param['field']){
			 $exists=true;
			}
		}
		if($exists==false){
			$this->db->query("ALTER TABLE `".DB_PREFIX.$param['table']."` ADD `".$param['field']."` ".$param['attr']);	
		}
	}
}