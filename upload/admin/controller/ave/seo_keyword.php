<?php  
class ControllerAveSeoKeyword extends Controller {  
	private $error = array();
	public function index() {
		$language_data = $this->load->language('avethemes/seo_keyword');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('avethemes/keyword');
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('autokw', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('ave/seo_keyword', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/seo_keyword', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);		
 		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];		
			unset($this->session->data['warning']);
		} else if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['route'])) {
			$data['error_route'] = $this->error['route'];
		} else {
			$data['error_route'] = array();
		}
		if (isset($this->error['url'])) {
			$data['error_url'] = $this->error['url'];
		} else {
			$data['error_url'] = array();
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$language_id = $this->config->get('config_language_id');
		$ruler =array(
			'prefix'=>'',
			'sufix'=>'',
			'separator'=>'',
			'language_id'=>$language_id,
			'extension'=>''
		);
		$data['autokw_seo_config'] = array(
											'product' =>$ruler,
											'category' =>$ruler,
											'manufacturer' =>$ruler,
											'information' =>$ruler,
											'article' =>$ruler,
											'content' =>$ruler,
											'author' =>$ruler
										);		
		if (isset($this->request->post['autokw_seo_config'])) {
			$data['autokw_seo_config'] = $this->request->post['autokw_seo_config'];
		} elseif ($this->config->get('autokw_seo_config')) { 
			$data['autokw_seo_config'] = $this->config->get('autokw_seo_config');
		}
		if (isset($this->request->post['autokw_status'])) {
			$data['autokw_status'] = $this->request->post['autokw_status'];
		} elseif ($this->config->get('autokw_status')) { 
			$data['autokw_status'] = $this->config->get('autokw_status');
		}else{
			$data['autokw_status'] = 0;
		}
			
		if (isset($this->request->post['autokw_page_routes'])) {
			$data['autokw_pages'] = $this->request->post['autokw_page_routes'];
		} elseif ($this->config->get('autokw_page_routes')) { 
			$data['autokw_pages'] = $this->config->get('autokw_page_routes');
		}else{
			$data['autokw_pages'] = unserialize('a:12:{i:0;a:2:{s:10:"page_route";s:15:"account/account";s:8:"page_url";s:7:"account";}i:1;a:2:{s:10:"page_route";s:13:"account/login";s:8:"page_url";s:5:"login";}i:2;a:2:{s:10:"page_route";s:16:"account/register";s:8:"page_url";s:8:"register";}i:3;a:2:{s:10:"page_route";s:15:"product/special";s:8:"page_url";s:7:"special";}i:4;a:2:{s:10:"page_route";s:20:"product/manufacturer";s:8:"page_url";s:12:"manufacturer";}i:5;a:2:{s:10:"page_route";s:19:"information/sitemap";s:8:"page_url";s:7:"sitemap";}i:6;a:2:{s:10:"page_route";s:19:"information/contact";s:8:"page_url";s:7:"contact";}i:7;a:2:{s:10:"page_route";s:16:"account/wishlist";s:8:"page_url";s:8:"wishlist";}i:8;a:2:{s:10:"page_route";s:14:"account/logout";s:8:"page_url";s:6:"logout";}i:9;a:2:{s:10:"page_route";s:17:"affiliate/account";s:8:"page_url";s:9:"affiliate";}i:10;a:2:{s:10:"page_route";s:17:"checkout/checkout";s:8:"page_url";s:8:"checkout";}i:11;a:2:{s:10:"page_route";s:11:"common/home";s:8:"page_url";s:0:"";}}');			
		}		
		$data['action'] = $this->url->link('ave/seo_keyword', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('ave/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$this_template = 'avethemes/tool/seo_keyword.tpl';
				
		$this->response->setOutput($this->load->view($this_template, $data));
  	}
	public function clean() {
		$this->load->model('avethemes/keyword');
		$json = array();
		/*Language*/ 
		$language_data = $this->load->language('avethemes/seo_keyword');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$json = array();
		
		if (isset($this->request->get['query'])&& $this->validate()) {
				$query_group = $this->request->get['query'];
				$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE `query` LIKE '".$query_group."%'");
				
				if(file_exists(DIR_LOGS.'kw_'.$query_group.'.txt')) {
					@unlink(DIR_LOGS.'kw_'.$query_group.'.txt');
				}
				$this->model_avethemes_keyword->writeOutput(DIR_LOGS.'kw_'.$query_group.'.txt','Empty!');
				$json['success'] = $json['log']  = sprintf($this->language->get('text_success_clean'), $query_group); 
		
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			} 	
		}else{
				$json['error'] = $this->language->get('error_permission');
		}		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function build() {
		$this->load->model('avethemes/keyword');
		$json = array();
		/*Language*/ 
		$language_data = $this->load->language('avethemes/seo_keyword');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$json = array();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['query'])&&isset($this->request->post['autokw_seo_config'])){
				$query_group = $this->request->post['query'];
				$log = $this->model_avethemes_keyword->generateKeyword(array('group'=>$query_group,'config'=>$this->request->post['autokw_seo_config']));
				$json['log'] = $log;
				$json['success'] = sprintf($this->language->get('text_success_build'), $query_group); 
			}else{
				$json['error'] = $this->language->get('error_data');	
			}
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			} 	
		}else{
				$json['error'] = $this->language->get('error_permission');
		}		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function result(){
		$this->load->language('avethemes/seo_keyword');	
		$json = array();
		if (isset($this->request->get['query'])) {
			$query = $this->request->get['query'];
			$file = DIR_LOGS.'kw_'.$query.'.txt';
			if(file_exists($file)) {
				$json['success'] = sprintf($this->language->get('text_success_load'), $query); 
				$json['log'] = file_get_contents($file);
			}
		} else {
			$query = '';
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ave/seo_keyword')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['autokw_page_routes'])) {
			foreach ($this->request->post['autokw_page_routes'] as $key => $value) {
				if (!$value['page_route']) {
					$this->error['route'][$key] = $this->language->get('error_route_empty');
				}
			}
		}
		
		if (isset($this->request->post['autokw_page_routes'])) {
			foreach ($this->request->post['autokw_page_routes'] as $key => $value) {
				if ($value['page_route']!='common/home'&&!$value['page_url']) {
					$this->error['url'][$key] = $this->language->get('error_url_empty');
				}
				if (isset($value['page_url'])) {
					if (preg_match('/[^a-zA-Z0-9_-]/',$value['page_url'])!=0) {
					$this->error['url'][$key] = $this->language->get('error_url_string');
					}
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($value['page_url']) . "'");
					$keyword_total = $query->row['total'];
					if ($keyword_total>0) {
						$this->error['url'][$key] = $this->language->get('error_url_duplicate');
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
	public function install() {
		/*Import XML*/ 
		$this->load->language('extension/installer');
		$error = array();

		$file = DIR_APPLICATION .  'view/template/keyword_generator/install.xml';

		$this->load->model('extension/modification');
		
		// If xml file just put it straight into the DB
			$xml = file_get_contents($file);

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
							$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'autokw'");
							$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%auto_keyword_generator%'");
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
					}
				} catch(Exception $exception) {
					$error['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
			}
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('autokw', array('autokw_status' => 1));
	}
	public function uninstall() {					
		$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'autokw'");	
		$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%auto_keyword_generator%'");
	}
}
?>