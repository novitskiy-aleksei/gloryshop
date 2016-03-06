<?php  
class ControllerAveDownload extends Controller {  
	private $error = array();
	
	public function index() {		
    	$this->getList();
  	}
  	        
  	public function insert() {
		$language_data = $this->load->language('avethemes/download');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/download');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_download->addDownload($this->request->post);
   	  		
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
			
			$this->response->redirect($this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
	
    	$this->getForm();
  	}

  	public function update() {
				
		$language_data = $this->load->language('avethemes/download');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/download');
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_download->editDownload($this->request->get['download_id'], $this->request->post);
	  		
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
			
			$this->response->redirect($this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
    	$this->getForm();
  	}

  	public function delete() {
				
		$language_data = $this->load->language('avethemes/download');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
 
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/download');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {	  
			foreach ($this->request->post['selected'] as $download_id) {
				$this->model_avethemes_download->deleteDownload($download_id);
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
			
			$this->response->redirect($this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
    
  	private function getList() {
				
		$language_data = $this->load->language('avethemes/download');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('avethemes/download');
		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$data['insert'] = $this->url->link('ave/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/download/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['downloads'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$download_total = $this->model_avethemes_download->getTotalDownloads();
	
		$results = $this->model_avethemes_download->getDownloads($filter_data);
 
    	foreach ($results as $result) {		
			
				if (file_exists('../assets/global/img/file_icon/'.substr(strrchr($result['mask'], '.'), 1).'.png')) {
					$thumb='../assets/global/img/file_icon/'.substr(strrchr($result['mask'], '.'), 1).'.png';
				}else{
					$thumb='../assets/global/img/file_icon/default.png';			
				}
			$ext=substr(strrchr($result['mask'], '.'), 1);
			
			$action = array();
						
			if (file_exists(DIR_DOWNLOAD.$result['filename'])) {	
				$action[] = array(
					'text' => $this->language->get('text_download'),
					'href' => HTTP_CATALOG.'index.php?route=content/article/download&auth_key=' . $result['auth_key']
				);
			}
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $result['download_id'] . $url, 'SSL')
			);
			
			
			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'thumb' => $thumb,
				'ext' => $ext,		
				'downloaded'   => $result['downloaded'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['download_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}	
	 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
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
		
		$data['sort_name'] = $this->url->link('ave/download', 'token=' . $this->session->data['token'] . '&sort=dd.name' . $url, 'SSL');
		$data['sort_downloaded'] = $this->url->link('ave/download', 'token=' . $this->session->data['token'] . '&sort=d.downloaded' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

$data['results'] = sprintf($this->language->get('text_pagination'), ($download_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($download_total - $this->config->get('config_limit_admin'))) ? $download_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $download_total, ceil($download_total / $this->config->get('config_limit_admin')));
	

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/content/download_list.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
  	}
  
  	private function getForm() {	
				
		$language_data = $this->load->language('avethemes/download');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    
    	$this->document->setTitle($this->language->get('heading_title'));
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		
 		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}
		
  		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}
		
  		if (isset($this->error['mask'])) {
			$data['error_mask'] = $this->error['mask'];
		} else {
			$data['error_mask'] = '';
		}
		
  		if (isset($this->error['auth_key'])) {
			$data['error_auth_key'] = $this->error['auth_key'];
		} else {
			$data['error_auth_key'] = '';
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL'),      		
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['download_id'])) {
			$data['action'] = $this->url->link('ave/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/download', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

    	if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$download_info = $this->model_avethemes_download->getDownload($this->request->get['download_id']);
    	}

  		$data['token'] = $this->session->data['token'];
  
  		if (isset($this->request->get['download_id'])) {
			$data['download_id'] = $this->request->get['download_id'];
		} else {
			$data['download_id'] = 0;
		}
		
		if (isset($this->request->post['download_description'])) {
			$data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$data['download_description'] = $this->model_avethemes_download->getDownloadDescriptions($this->request->get['download_id']);
		} else {
			$data['download_description'] = array();
		}   
		
    	if (isset($this->request->post['filename'])) {
    		$data['filename'] = $this->request->post['filename'];
    	} elseif (!empty($download_info)) {
      		$data['filename'] = $download_info['filename'];
		} else {
			$data['filename'] = '';
		}
		
    	if (isset($this->request->post['mask'])) {
    		$data['mask'] = $this->request->post['mask'];
    	} elseif (!empty($download_info)) {
      		$data['mask'] = $download_info['mask'];		
		} else {
			$data['mask'] = '';
		}
    	if (isset($this->request->post['auth_key'])) {
    		$data['auth_key'] = $this->request->post['auth_key'];
    	} elseif (!empty($download_info)) {
      		$data['auth_key'] = $download_info['auth_key'];		
		} else {
			$data['auth_key'] = '';
		}

		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($download_info)) {
			$data['color'] = $download_info['color'];
		} else {
			$data['color'] = 'blue-sky';
		}
				 	  
    	if (isset($this->request->post['update'])) {
      		$data['update'] = $this->request->post['update'];
    	} else {
      		$data['update'] = false;
    	}

		$data['setcolors'] = $this->ave->getColors();
		
		$this_template = 'avethemes/content/download_form.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));	
  	}

  	private function validateForm() { 
	
    	if (!$this->user->hasPermission('modify', 'ave/download')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['download_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 64)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
			
      		if ((utf8_strlen($value['description']) > 255)) {
        		$this->error['description'][$language_id] = $this->language->get('error_description');
      		}
    	}	

		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}	
		
		if (!file_exists(DIR_DOWNLOAD . $this->request->post['filename']) && !is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}
				
		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}		
		if ((utf8_strlen($this->request->post['auth_key']) < 3) || (utf8_strlen($this->request->post['auth_key']) > 64)) {
			$this->error['auth_key'] = $this->language->get('error_auth_key');
		}
			
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'ave/download')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
		
		$this->load->model('avethemes/article');

		foreach ($this->request->post['selected'] as $download_id) {
  			$article_total = $this->model_avethemes_article->getTotalArticlesByDownloadId($download_id);
    
			if ($article_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_article'), $article_total);	
			}	
		}	
			  	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		} 
  	}

	public function upload() {
	
		$this->load->language('sale/order');
		
		$json = array();
		
		
		if (!empty($this->request->files['file']['name'])) {
			$full_filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			
			if ((utf8_strlen($full_filename) < 3) || (utf8_strlen($full_filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}	  	
			$filename=(string)$full_filename;
			/**/
			$full_name = explode(".",$filename); 	
			if ((utf8_strlen($full_name[0]) < 1)) {
				$filename_prefix ='';
			}else{
				$filename_prefix =$full_name[0];
			}
			$filename_ext =substr(strrchr($filename, '.'), 1);	
			$filename = $filename_prefix.'.'.$filename_ext;
			
			$allowed = array();/*1*/ 
			$filetypes = explode(',', $this->config->get('ave_cms_upload_allowed'));/*2*/ 		
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}/*3*/ 
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}/*4*/ 	
					
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
	
		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = md5(mt_rand());
				 
				$json['filename'] = $filename . '_' . $ext;
				$json['mask'] = $filename;
				$json['auth_key'] = md5($json['filename']);
				
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $filename . '_' . $ext);
			}
						
			$json['success'] = $this->language->get('text_upload');
		}	
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	
	public function autocomplete(){
		$json=array();
    	if(isset($this->request->get['filter_name'])){
			$this->load->model('avethemes/download');
		$filter_data =array(
				'filter_name' =>$this->request->get['filter_name'],
				'start'       =>0,
				'limit'       =>20
			);
		$json=array();
		$results=$this->model_avethemes_download->getDownloads($filter_data);
		foreach($results as $result){
				$json[]=array(
					'download_id'            =>$result['download_id'],
					'name'            =>$result['name'],
					'mask'            =>$result['mask'],
					'filename'    =>$result['filename'],
					'auth_key'    =>$result['auth_key']
				);		
			}		
		}
			$sort_order=array();
		foreach($json as $key =>$value){
			$sort_order[$key]=$value['name'];
		}

		array_multisort($sort_order, SORT_ASC,$json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>