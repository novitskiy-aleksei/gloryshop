<?php  
class ControllerAveSkin extends Controller {  
	private $error = array();
	public function index() {
		if (!$this->config->has('ave_installed')) {
			$this->response->redirect($this->url->link('ave/skin/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
		if (isset($this->session->data['skin_id'])) {
			unset($this->session->data['skin_id']);
		}
    	$this->getList();
  	}
  	public function editor() {
		
		
		if (isset($this->session->data['skin_id'])) {
			unset($this->session->data['skin_id']);
		}
		$this->load->language('avethemes/skin');
		
		
		
		$this->load->model('avethemes/skin');
		$this->load->model('setting/setting');
		$language_data = $this->load->language('avethemes/skin');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('editor_title'));
		$this->document->addLink('../assets/editor/img/favicon.png', 'icon');
		$this->document->addStyle('../assets/editor/css/back_editor.css');
		
		
		
		
		$this->session->data['admin_editor'] = true;
		$query_url = 'save_session=1';	
		$store_id = 0;
		$skin_id = 0;
		$store_url = ($this->config->get('config_secure')==1)?HTTPS_CATALOG:HTTP_CATALOG;
		$skin_id = $skin_active_id = $this->config->get('skin_active_id');	
		
		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
			$query_url .='&store_id='.$this->request->get['store_id'];
			$store_info = $this->model_setting_setting->getSetting('config', $this->request->get['store_id']);
			$store_url = !empty($store_info['config_url'])?$store_info['config_url']:$store_url;
		}	
		if (isset($this->request->get['skin_id'])) {
			$query_url .='&skin_id='.$this->request->get['skin_id'];
			$skin_id=$this->request->get['skin_id'];			
      		$skin_info = $this->model_avethemes_skin->getSkin($skin_id);	
		}
		if(isset($this->request->get['section'])){
			$query_url .='&section=1';
		}
		$data['store_url'] = $store_url;
		$data['url'] = $query_url;
		$data['skin_id'] = $skin_id;
		
		$data['cancel'] = $this->url->link('ave/skin/clear_session', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');	
		$this_template = 'avethemes/editor/main_editor.tpl';	
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	
  	public function add_skin() {	
		$this->load->language('avethemes/skin');
		$this->load->model('avethemes/skin');		
		$url ='';
    	if ($this->validate()) {
				$skin_name ='-Draft-';
			if(isset($this->request->post['skin_name'])){
				$skin_name = $this->request->post['skin_name'].'-Draft-';
			}
			$savedata= array(
			'skin_name'=>$skin_name,
			'color'=>'#0dc0c0',
			'theme_setting'=>$this->ave->getDefaultValue(),
			'status'=>0);
			$skin_id = $this->model_avethemes_skin->addSkin($savedata);	 		
		$this->session->data['success'] =  sprintf($this->language->get('text_success_add_skin'), $skin_name);
		$url .='&skin_id='.$skin_id.'&section=1';
		}
		$this->response->redirect($this->url->link('ave/skin/editor',$url.'&token=' . $this->session->data['token'], 'SSL'));
  	}
  	public function export_skin() {	
		$this->load->language('avethemes/skin');
		$this->load->model('avethemes/skin');		
		
		$rstatus = $this->ave->validate();
		if ($rstatus==true&&isset($this->request->get['skin_id'])&& $this->validate()) {
			$skin_id = 0;
			if(isset($this->request->get['skin_id'])){
				$skin_id = $this->request->get['skin_id'];
			}
  			$skin_exists = $this->model_avethemes_skin->checkSkin($skin_id);
			if (!$skin_exists) {
	  			$this->session->data['warning'] = $this->language->get('error_skin_exists');	
			}else{	
			
      		$skin_info = $this->model_avethemes_skin->getSkin($skin_id);	
			$export_output = $this->ave->parseJson($skin_info,'e');
			$this->response->addHeader('Pragma: public');
			$this->response->addHeader('Expires: 0');
			$this->response->addHeader('Content-Description: File Transfer');
			$this->response->addHeader('Content-Type: application/octet-stream');
			$this->response->addHeader('Content-Disposition: attachment; filename=Skin_'.$skin_id.'-'.$skin_info['skin_name'].'.json');
			$this->response->addHeader('Content-Transfer-Encoding: binary');
			$this->response->setOutput($export_output);
			$this->session->data['success'] =  sprintf($this->language->get('text_success_export_skin'), $skin_info['skin_name']);
			}
    	}else{
			$this->response->redirect($this->url->link('ave/skin/permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
  	public function import_skin() {	
		$this->load->language('avethemes/skin');
		$this->load->model('avethemes/skin');	
		
		$rstatus = $this->ave->validate();				
		if ($rstatus==true&&$this->request->server['REQUEST_METHOD'] == 'POST') {
				$filecontent = array();
				if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					$filecontent = file_get_contents($this->request->files['import']['tmp_name']);
				}
				$import_info = $this->ave->parseJson($filecontent,'i');	
				if(!empty($import_info)){
					$this->model_avethemes_skin->importSkinData($import_info);	
					$this->session->data['success'] =  $this->language->get('text_success_import_skin');
				}else{						
					$this->session->data['warning'] = $this->language->get('error_import_skin');	
				}
		}else{
			$this->response->redirect($this->url->link('ave/skin/permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$redirect = $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL');			  	
		$this->response->redirect($redirect);
	}
  	public function clear_session() {
		if (isset($this->session->data['skin_id'])) {
			unset($this->session->data['skin_id']);
		}
		$this->session->data['success'] =  'Success!';
		$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'));
	}
  	public function permission() {
		$language_data = $this->load->language('avethemes/skin');
    	$this->document->setTitle($this->language->get('heading_title'));
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['text_error_register'] = $this->language->get('text_error_register');
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$this_template = 'avethemes/content/error.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
		
	}
	
  	public function active_skin() {
		$language_data = $this->load->language('avethemes/skin');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
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
			
    	if (isset($this->request->get['skin_id'])&& $this->validate()) {	
				$skin_id=$this->request->get['skin_id'];	
			$this->load->model('avethemes/skin');			
			$store_id=0;
			if(isset($this->request->get['store_id'])){
				$store_id=$this->request->get['store_id'];
			}				
			$this->load->model('setting/setting');		
			$store_info = $this->model_setting_setting->getSetting('config',$store_id);
			$store_name = $store_info['config_name'];	
			
      		$skin_info = $this->model_avethemes_skin->activeSkin('skin',$skin_id,$store_id);				
      		$skin_info = $this->model_avethemes_skin->getSkin($skin_id);		
			if (isset($this->session->data['skin_id'])) {
					unset($this->session->data['skin_id']);
			}	
			$this->session->data['success'] =  sprintf($this->language->get('text_success_active_skin'), $skin_info['skin_name'],$store_name);
			
			
			$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    	$this->getList();
  	}
  	public function copy() {
		$language_data = $this->load->language('avethemes/skin');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/skin');
		
		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $skin_id) {
				$this->model_avethemes_skin->copySkin($skin_id);
	  		}
			$this->session->data['success'] = $this->language->get('text_success_copy');
			
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
			
			$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  	public function delete_selected() {
		$language_data = $this->load->language('avethemes/skin');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
 
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/skin');
			
    	if (isset($this->request->post['selected']) && $this->validateDeletes()) {	  
			foreach ($this->request->post['selected'] as $skin_id) {
				$this->model_avethemes_skin->deleteSkin($skin_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success_delete');

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
			
			$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
  	protected function getList() {
		$language_data = $this->load->language('avethemes/skin');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
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
    	$this->document->setTitle($this->language->get('heading_title'));
		
		/*Modal data*/ 
		$this->load->model('avethemes/skin');
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {			
			$this->load->model('avethemes/skin');
			$this->model_avethemes_skin->editSetting('skin',$this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$skin_admin_path = $this->config->get('skin_admin_path');
		if(!empty($skin_admin_path)){
			$data['skin_admin_path'] = $this->config->get('skin_admin_path');
		}else{
			$data['skin_admin_path'] = $this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER;
		}
		
		$skin_admin_dir = $this->config->get('skin_admin_dir');
		if(!empty($skin_admin_dir)){
			$data['skin_admin_dir'] = $this->config->get('skin_admin_dir');	
		}else{
			$data['skin_admin_dir'] = DIR_APPLICATION;	
		}
		
		
		$store_configs = $this->ave->skin_configs();
		foreach($store_configs as $key=>$value){
			$data[$key] = $value;
			$data[$key] = $this->config->get($key);
		}	
		$store_url = ($this->config->get('config_secure')==1)?HTTPS_CATALOG:HTTP_CATALOG;
		if (isset($this->request->get['store_id'])) {
			$store_info = $this->model_setting_setting->getSetting('config', $this->request->get['store_id']);
			$store_url = !empty($store_info['config_url'])?$store_info['config_url']:$store_url;
		}	
		$data['store_url'] = $store_url;
		
		$data['modal_action'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url, 'SSL');
		/*End Modal data*/ 
		
		if (isset($this->session->data['admin_editor'])) {
			unset($this->session->data['admin_editor']);
		} 
		
		$this->load->model('avethemes/skin');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'skin_id';
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
				
		
 		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];		
			unset($this->session->data['warning']);
		} else if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$rstatus = $this->ave->validate();
		if ($rstatus==false) {
			$data['error_warning'] =  '<b>'.$this->language->get('error_register').'</b>';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$data['copy'] = $this->url->link('ave/skin/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['clear_session'] = $this->url->link('ave/skin/clear_session', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['insert'] = $this->url->link('ave/skin/add_skin', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['import'] = $this->url->link('ave/skin/import_skin', 'token=' . $this->session->data['token']. $url, 'SSL');	
		$data['delete_selected'] = $this->url->link('ave/skin/delete_selected', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['skins'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$skin_total = $this->model_avethemes_skin->getTotalSkins();
		if($skin_total<1){
			$savedata= array(
			'skin_name'=>'Default Theme',
			'color'=>'#0dc0c0',
			'theme_setting'=>$this->ave->getDefaultValue(),
			'status'=>1);
			$this->model_avethemes_skin->addSkin($savedata);
		}
		$results = $this->model_avethemes_skin->getSkins($filter_data);
 
		$this->load->model('setting/store');
		$stores = array();
		$stores[] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name'),
			'url'      => HTTP_CATALOG,
		);
		$getstores = $this->model_setting_store->getStores();
		foreach ($getstores as $getstore) {	
			$stores[] = array(
				'store_id' => $getstore['store_id'],
				'name'     => $getstore['name'],
				'url'      => $getstore['url'],
			);
		}
    	foreach ($results as $result) {	
			$skin_id =	$result['skin_id'];	
			
			$store_actions = array();
			foreach ($stores as $store) {
				$store_actions[$store['store_id']] = array(
					'store_id' => $store['store_id'],
					'name'     => $store['name'],
					'preview'     => $store['url'].'index.php?skin_id=' . $result['skin_id'].'&store_id=' . $store['store_id'].'&no_session=1',
					'edit'     =>$this->url->link('ave/skin/editor', '&section=1&store_id=' . $store['store_id'] . '&skin_id=' . $result['skin_id'] . $url.'&token=' . $this->session->data['token'], 'SSL'),
					'active' => $this->url->link('ave/skin/active_skin', 'token=' . $this->session->data['token']. '&store_id=' . $store['store_id'] . '&skin_id=' . $result['skin_id'] . $url, 'SSL')
				);
				$stores_active = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store['store_id'] . "' AND `key` = 'skin_active_id'");			
				if ($stores_active->num_rows) {					
					foreach ($stores_active->rows as $store_active) {	
							if($store_active['value']==$skin_id){
								$store_actions[$store['store_id']]['active'] = false;
							}
					}
				}
			}
			 
			
			$export = array(
				'text' => $this->language->get('text_export'),
				'class' => '',
				'href' => $this->url->link('ave/skin/export_skin', 'token=' . $this->session->data['token'] . '&skin_id=' . $result['skin_id'] . $url, 'SSL')
			);
			/**/ 
			
			
			$data['skins'][] = array(
				'skin_id' => $result['skin_id'],
				'skin_name'        => $result['skin_name'],
				'color'        => $result['color'],
				'store_actions'        => $store_actions,
				'date_added'        => $result['date_added'],
				'status'        => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'    => isset($this->request->post['selected']) && in_array($result['skin_id'], $this->request->post['selected']),
				'export'      => $export
			);
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
		
		$data['ave_status'] =  $this->ave->validate();
		$data['sort_name'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . '&sort=skin_name' . $url, 'SSL');
		$data['sort_date'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $skin_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/skin', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		
	$data['results'] = sprintf($this->language->get('text_pagination'), ($skin_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($skin_total - $this->config->get('config_limit_admin'))) ? $skin_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $skin_total, ceil($skin_total / $this->config->get('config_limit_admin')));
	
		$data['sort'] = $sort;
		$data['order'] = $order;

			$domain = parse_url(HTTP_SERVER);
			$purchase_theme = $this->ave->theme();
			$data['register_uri'] = 'http://www.avethemes.com/index.php?route=support/license&domain='.$domain['host'].'&theme='.$purchase_theme;
			$data['skin_config_email'] = $this->config->get('config_email');	
			$data['skin_config_domain'] = $domain['host'];
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this_template = 'avethemes/editor/skin_list.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
  	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ave/skin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
  	private function validateDeletes() {
    	if (!$this->user->hasPermission('modify', 'ave/skin')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
		$this->load->model('avethemes/skin');

		foreach ($this->request->post['selected'] as $skin_id) {
  			$active_total = $this->model_avethemes_skin->checkActiveSkin($skin_id);
			if ($active_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_delete_skin'), $active_total);	
			}	
		}	
			  	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		} 
  	}
	public function install() {
		$this->load->model('avethemes/global');		
		$this->model_avethemes_global->checkThemeSkin();
		$store_configs = $this->ave->skin_configs();
		$this->load->model('avethemes/skin');
		$this->model_avethemes_skin->editSetting('skin',array_merge(array('skin_active_id' => 1),$store_configs));
		$this->db->query("INSERT INTO `" . DB_PREFIX. "setting` SET value = '1',`key` = 'ave_installed'");
		$this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
		//$this->response->redirect($this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'));
	}
/********************************************************/
/*      			. getDefaultValue					*/
/********************************************************/	
	public function skin_configs() {
	 $skin_configs = array(
					/*Contact Page*/ 
					'skin_lic_key'	=> 'F95903-18AC02-5DB7',
					'skin_lang_dir'	=> array('en'=>'ltr'),
					'skin_nav_shortcode'	=>'0',
					'skin_minify_code'	=>'0',
					'skin_seo_optimize'	=>'1',
					'skin_internal_link'	=>'0',
					'skin_compression_html'	=>'0',
					'skin_remove_comment'	=>'0',
					'skin_oc_comment'	=>'1',
					/*Social*/ 
					'skin_disqus_shortname'	=>'avetheme',
					'skin_catalog_disqus_comment'	=>'1',
					'skin_catalog_gplus_comment'	=>'0',
					'skin_catalog_fb_comment'	=>'0',
					'skin_blog_disqus_comment'	=>'1',
					'skin_blog_gplus_comment'	=>'0',
					'skin_blog_fb_comment'	=>'0',
					'skin_fb_type'	=>'admins',
					'skin_fb_id'			=>'100004207811901',
					'skin_fb_color_scheme'	=>'dark',
					'skin_fb_order_by'	=>'social',
					'skin_fb_num_posts'	=>'5',
					'skin_fb_color_scheme'	=>'dark',
					'skin_facebook_id'			=>'675916102537982',
					'skin_facebook_shown'		=>'8',
					'skin_facebook_lang'			=>'en_US',
					
					'skin_twitter_shown'			=>'2',
					'skin_twitter_widget_id'		=>'353398084929208320',
					'skin_twitter_username'		=>'OpencartPlus',
					'skin_twitter_button'		=>'0',
					'skin_twitter_lang'	=>'en',
					/*Optimizer*/ 	
					'skin_css_delivery'	=>'0',
					'skin_put_js_bottom'	=>'0',
					'skin_cp_enabled'					=>'1',
					'skin_cp_user'					=>'1',
					'skin_social_data'			=>array(0=>array('icon'=>FALSE,'link'=>FALSE,'title'=>FALSE,'sort_order'=>FALSE,'target'=>FALSE)),
					'skin_query_details'					=>'1',
					'skin_footer_info_title'			=>array(),
					'skin_footer_info_desc'			=>array(),
					'skin_header_step_info'			=>array(
													 array(
														'icon'=>'fa fa-truck',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Goal definition'),
														'description'=>array(1=>'Lorem ipsum')
													  ),
													 array(
														'icon'=>'fa fa-gift',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Analyse'),
														'description'=>array(1=>'Adipisicing eiusmod')
													  ),
													 array(
														'icon'=>'fa fa-phone',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Implementation'),
														'description'=>array(1=>'Sed unde')
													  )
													),					
					'skin_footer_step_info'			=>array(
													 array(
														'icon'=>'fa fa-facebook',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Like us on Facebook'),
														'description'=>array(1=>'Visit our Facebook page!')
													  ),
													array(
														'icon'=>'fa fa-comments',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Community blogs'),
														'description'=>array(1=>'Get help from other users')
													  ),
													 array(
														'icon'=>'fa fa-user',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Commercial support'),
														'description'=>array(1=>'Development services')
													  )
													),
					'skin_powered_desc' =>array(),
					'skin_payment_icons_status'			=>0, 
					'skin_payment_icons_data'			=>array('image'=>FALSE,'sort_order'=>FALSE,'title'=>FALSE), 
					'skin_zoom_image_width'			=>'960',
					'skin_zoom_image_height'			=>'960',
					'skin_layout_refresh'=>'0',
					'skin_layout_builder_show_option'=>'hide_module_option',
					'skin_layout_builder_module_display'=>0,
					'skin_layout_builder_preview_urls'=>unserialize('a:15:{i:6;a:2:{s:9:"layout_id";s:1:"6";s:11:"preview_url";s:31:"index.php?route=account/account";}i:10;a:2:{s:9:"layout_id";s:2:"10";s:11:"preview_url";s:33:"index.php?route=affiliate/account";}i:3;a:2:{s:9:"layout_id";s:1:"3";s:11:"preview_url";s:44:"index.php?route=product/category&amp;path=20";}i:7;a:2:{s:9:"layout_id";s:1:"7";s:11:"preview_url";s:29:"index.php?route=checkout/cart";}i:12;a:2:{s:9:"layout_id";s:2:"12";s:11:"preview_url";s:31:"index.php?route=product/compare";}i:8;a:2:{s:9:"layout_id";s:1:"8";s:11:"preview_url";s:35:"index.php?route=information/contact";}i:15;a:2:{s:9:"layout_id";s:2:"15";s:11:"preview_url";s:48:"index.php?route=content/article&amp;article_id=1";}i:14;a:2:{s:9:"layout_id";s:2:"14";s:11:"preview_url";s:49:"index.php?route=content/category&amp;content_id=1";}i:4;a:2:{s:9:"layout_id";s:1:"4";s:11:"preview_url";s:27:"index.php?route=common/home";}i:1;a:2:{s:9:"layout_id";s:1:"1";s:11:"preview_url";s:27:"index.php?route=common/home";}i:11;a:2:{s:9:"layout_id";s:2:"11";s:11:"preview_url";s:60:"index.php?route=information/information&amp;information_id=4";}i:5;a:2:{s:9:"layout_id";s:1:"5";s:11:"preview_url";s:36:"index.php?route=product/manufacturer";}i:2;a:2:{s:9:"layout_id";s:1:"2";s:11:"preview_url";s:49:"index.php?route=product/product&amp;product_id=42";}i:13;a:2:{s:9:"layout_id";s:2:"13";s:11:"preview_url";s:30:"index.php?route=product/search";}i:9;a:2:{s:9:"layout_id";s:1:"9";s:11:"preview_url";s:35:"index.php?route=information/sitemap";}}')
					
		);
		return $skin_configs;
	}
}