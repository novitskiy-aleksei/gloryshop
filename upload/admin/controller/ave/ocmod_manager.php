<?php
class ControllerAveOcmodManager extends Controller {
	private $error = array();
	public function index() {
		$this->getList();
	}

	public function add() {
		$this->load->language('avethemes/ocmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/modification');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_modification->addModification($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	public function import(){
						$error = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST'&& $this->validate()) {
			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					/*Import XML*/ 
						$this->load->language('extension/installer');
						$this->load->model('extension/modification');
						
						// If xml file just put it straight into the DB
							$xml = file_get_contents($this->request->files['import']['tmp_name']);
							if ($xml) {
								try {
									$dom = new DOMDocument('1.0', 'UTF-8');
									$dom->loadXml($xml);
									
									$name = $dom->getElementsByTagName('name')->item(0);
				
									if ($name) {
										$name = $name->nodeValue;
									} else {
										$name = '';
									}
									
									$code = $dom->getElementsByTagName('code')->item(0);
				
									if ($code) {
										$code = $code->nodeValue;
										
										// Check to see if the modification is already installed or not.
										$modification_info = $this->model_extension_modification->getModificationByCode($code);
										
										if ($modification_info) {							
											$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%".$code."%'");
										}
									} else {
										$error['error'] = $this->language->get('error_code');
									}
				
									$author = $dom->getElementsByTagName('author')->item(0);
				
									if ($author) {
										$author = $author->nodeValue;
									} else {
										$author = '';
									}
				
									$version = $dom->getElementsByTagName('version')->item(0);
				
									if ($version) {
										$version = $version->nodeValue;
									} else {
										$version = '';
									}
				
									$link = $dom->getElementsByTagName('link')->item(0);
				
									if ($link) {
										$link = $link->nodeValue;
									} else {
										$link = '';
									}
				
									$modification_data = array(
										'name'    => $name,
										'code'    => $code,
										'author'  => $author,
										'version' => $version,
										'link'    => $link,
										'xml'     => $xml,
										'status'  => 1
									);
									
									if (!$error) {
										$this->model_extension_modification->addModification($modification_data);
										$this->session->data['success'] = $this->language->get('text_success');
									}
								} catch(Exception $exception) {
										$this->session->data['warning'] = 'Import error!';
								}
						}
			}else{
				$this->session->data['warning'] = 'Import error!';
			}
		}
		$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function download(){
		$this->load->language('avethemes/ocmod_manager');
		$this->load->model('avethemes/modification');		
		
		if (isset($this->request->get['modification_id'])&& $this->validate()) {
				$modification_id = $this->request->get['modification_id'];
				
  			$modification_info = $this->model_avethemes_modification->getModification($modification_id);
			if (!$modification_info) {
	  			$this->session->data['warning'] = $this->language->get('error_modification_exists');	
			}else{	
			$this->response->addHeader('Pragma: public');
			$this->response->addHeader('Expires: 0');
			$this->response->addHeader('Content-Description: File Transfer');
			$this->response->addHeader('Content-Type: application/xml');
			$this->response->addHeader('Content-Disposition: attachment; filename='.$modification_info['code'].'.ocmod.xml');
			$this->response->addHeader('Content-Transfer-Encoding: binary');
				$this->response->setOutput($modification_info['xml']);
			$this->session->data['success'] =  sprintf($this->language->get('text_success_export_mod'), $modification_info['name']);
			}
    	}else{
			$this->session->data['warning'] = $this->language->get('error_permission');
			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	public function edit() {
		$this->load->language('avethemes/ocmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/modification');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_modification->editModification($this->request->get['modification_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		$this->document->addScript('../assets/editor/plugins/code_editor/ace.js');
		
		$language_data = $this->load->language('avethemes/ocmod_manager');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('avethemes/modification');
		
		$data['text_form'] = !isset($this->request->get['modification_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		if (isset($this->error['xml'])) {
			$data['error_xml'] = $this->error['xml'];
		} else {
			$data['error_xml'] = '';
		}
		
		if (isset($this->error['rating'])) {
			$data['error_rating'] = $this->error['rating'];
		} else {
			$data['error_rating'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['modification_id'])) {
			$data['action'] = $this->url->link('ave/ocmod_manager/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/ocmod_manager/edit', 'token=' . $this->session->data['token'] . '&modification_id=' . $this->request->get['modification_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['modification_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$modification_info = $this->model_avethemes_modification->getModification($this->request->get['modification_id']);
		}

		$data['token'] = $this->session->data['token'];		
		$fields = array(
			'name'		=>'Name',
			'code'		=>'',
			'author'	=>'Author',
			'version'	=>'1.0',
			'link'		=>'http://www.opencart.com',
			'xml'		=>'',
			'status'	=>1
		);		
		foreach ($fields as $key=>$value){
			if (isset($this->request->post[$key])) {
				$data[$key] = html_entity_decode($this->request->post[$key]);
			} elseif (!empty($modification_info)) {
				$data[$key] = $modification_info[$key];
			} else {
				$data[$key] = $value;
			}			
		}

		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$this_template = 'avethemes/tool/modification_form.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function delete() {
		$this->load->language('avethemes/ocmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/modification');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $modification_id) {
				$this->model_avethemes_modification->deleteModification($modification_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	public function refresh() {
		$this->session->data['session_redirect'] = 'ave/ocmod_manager';
		$this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function clear() {
		$this->session->data['session_redirect'] = 'ave/ocmod_manager';
		$this->response->redirect($this->url->link('extension/modification/clear', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function enable() {
		$this->load->language('avethemes/ocmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/modification');

		if (isset($this->request->get['modification_id']) && $this->validate()) {
			$this->model_avethemes_modification->enableModification($this->request->get['modification_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function disable() {
		$this->load->language('avethemes/ocmod_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('avethemes/modification');

		if (isset($this->request->get['modification_id']) && $this->validate()) {
			$this->model_avethemes_modification->disableModification($this->request->get['modification_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function clearlog() {
		$this->load->language('avethemes/ocmod_manager');

		if ($this->validate()) {
			$handle = fopen(DIR_LOGS . 'ocmod.log', 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$language_data = $this->load->language('avethemes/ocmod_manager');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('avethemes/modification');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['import_ocmod'] = $this->url->link('ave/ocmod_manager/import', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['refresh'] = $this->url->link('ave/ocmod_manager/refresh', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['clear'] = $this->url->link('ave/ocmod_manager/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['add'] = $this->url->link('ave/ocmod_manager/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/ocmod_manager/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['modifications'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$modification_total = $this->model_avethemes_modification->getTotalModifications();

		$results = $this->model_avethemes_modification->getModifications($filter_data);

		foreach ($results as $result) {
			$data['modifications'][] = array(
				'modification_id' => $result['modification_id'],
				'name'            => $result['name'],
				'author'          => $result['author'],
				'version'         => $result['version'],
				'status'          => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'link'            => $result['link'],
				'edit'          => $this->url->link('ave/ocmod_manager/edit', 'token=' . $this->session->data['token'] . '&modification_id=' . $result['modification_id'], 'SSL'),
				'download'          => $this->url->link('ave/ocmod_manager/download', 'token=' . $this->session->data['token'] . '&modification_id=' . $result['modification_id'], 'SSL'),
				'enable'          => $this->url->link('ave/ocmod_manager/enable', 'token=' . $this->session->data['token'] . '&modification_id=' . $result['modification_id'], 'SSL'),
				'disable'         => $this->url->link('ave/ocmod_manager/disable', 'token=' . $this->session->data['token'] . '&modification_id=' . $result['modification_id'], 'SSL'),
				'enabled'         => $result['status'],
			);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		}else if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_author'] = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . '&sort=author' . $url, 'SSL');
		$data['sort_version'] = $this->url->link('extension/version', 'token=' . $this->session->data['token'] . '&sort=author' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $modification_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($modification_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($modification_total - $this->config->get('config_limit_admin'))) ? $modification_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $modification_total, ceil($modification_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		// Log
		$file = DIR_LOGS . 'ocmod.log';

		if (file_exists($file)) {
			$data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['log'] = '';
		}

		$data['clear_log'] = $this->url->link('ave/ocmod_manager/clearlog', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this_template = 'avethemes/tool/modification_list.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'ave/ocmod_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['author']) {
			$this->error['author'] = $this->language->get('error_author');
		}
		if (!$this->request->post['name']) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!$this->request->post['code']) {
			$this->error['code'] = $this->language->get('error_code');
		}
		if (!$this->request->post['xml']) {
			$this->error['xml'] = $this->language->get('error_xml');
		}	

		return !$this->error;
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ave/ocmod_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}