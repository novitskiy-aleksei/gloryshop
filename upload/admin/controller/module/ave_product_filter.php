<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProductFilter extends Controller {
	private $error = array(); 
	public function index() {
		$data['redirect'] = $this->url->link('module/ave_product_filter', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_product_filter&token=' . $this->session->data['token'] , 'SSL');
		
		$language_data = $this->load->language('module/ave_product_filter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('sub_title'));	
		$data['rstatus'] = $this->ave->validate();
		$this->load->model('setting/setting');

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->model_setting_setting->editSetting('ave_product_filter', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('catalog/option');

		$total_options = $this->model_catalog_option->getTotalOptions();
		$data['options'] = $this->model_catalog_option->getOptions(array('start' => 0, 'limit' => $total_options));
		foreach($data['options'] as $i => $option) {
			if(!in_array($option['type'], array('radio', 'checkbox', 'select', 'image'))) {
				unset($data['options'][$i]);
			}
		}

		$this->load->model('catalog/attribute');

		$total_attributes = $this->model_catalog_attribute->getTotalAttributes();
		$data['attributes'] = $this->model_catalog_attribute->getAttributes(array('start' => 0, 'limit' => $total_attributes));

		if(isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if(isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if(isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('sub_title'),
			'href' => $this->url->link('module/ave_product_filter', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/ave_product_filter', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

	
	
		if(isset($this->request->post['ave_product_filter_status'])) {
			$data['ave_product_filter_status'] = $this->request->post['ave_product_filter_status'];
		} else{
			$data['ave_product_filter_status'] = $this->config->get('ave_product_filter_status');
		}
		
		if(isset($this->request->post['ave_product_filter_setting'])) {
			$data['setting'] = $this->request->post['ave_product_filter_setting'];
		} elseif($this->config->get('ave_product_filter_setting')) {
			$data['setting'] = $this->config->get('ave_product_filter_setting');
		}

		$data['display_options'][] = array('value' => 'none', 'name' => $this->language->get('text_display_none'));
		$data['display_options'][] = array('value' => 'checkbox', 'name' => $this->language->get('text_display_checkbox'));
		$data['display_options'][] = array('value' => 'select', 'name' => $this->language->get('text_display_select'));
		$data['display_options'][] = array('value' => 'radio', 'name' => $this->language->get('text_display_radio'));

		$this_template = 'avethemes/module/filter_product.tpl';
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view($this_template, $data));
	}

	public function install() {
		foreach(array(
			'product_option_value' => array('option_value_id', 'product_id'),
			'product_to_category' => array('category_id')) as $table => $indexes) {
			$query = $this->db->query("SHOW INDEX FROM `" . DB_PREFIX . $table . "`");

			$keys = array();
			foreach($query->rows as $row) {
				if($row['Key_name'] != 'PRIMARY') {
					$keys[] = $row['Column_name'];
				}
			}
			$keys = array_diff($indexes, $keys);
			foreach($keys as $key) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD INDEX ( `" . $key . "` )");
			}
		}

	}

	private function validate() {
		if(!$this->user->hasPermission('modify', 'module/ave_product_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if(!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}

?>