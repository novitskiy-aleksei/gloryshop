<?php class ControllerAveImageManagerPlus extends Controller { 
	private $error = array();		
    private $file = 'image_log.txt';
	public function thumb(){	
		$this->load->model('tool/image');

		if (isset($this->request->get['image'])) {
			$thumb = $this->model_tool_image->resize(html_entity_decode(str_replace('image/catalog/','catalog/',$this->request->get['image']), ENT_QUOTES, 'UTF-8'), 100, 100);
			$this->response->setOutput($thumb);
		}
	
	}
	public function index() {	
		if (!$this->config->has('image_manager_plus_installed')) {
			$this->response->redirect($this->url->link('ave/image_manager_plus/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
	   $this->document->addScript('../assets/plugins/jquery-migrate-1.2.1.min.js');
	   $this->document->addStyle('../assets/editor/plugins/jquery-ui/jquery-ui.css');
	   $this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js');  	   
		$this->document->addStyle('../assets/editor/plugins/elfinder/css/elfinder.min.css');   
	   $this->document->addScript('../assets/editor/plugins/elfinder/js/elFinder.js');	
	   $this->document->addScript('../assets/editor/plugins/elfinder/js/ui/elfinder-ui.js');	
	   $this->document->addScript('../assets/editor/plugins/elfinder/js/commands/commands.js');
	   $this->document->addScript('../assets/editor/plugins/elfinder/js/i18n/elfinder.en.js');	
	   $this->document->addScript('../assets/editor/plugins/elfinder/js/proxy/elFinderSupportVer1.js');
   	
		$language_data = $this->language->load('avethemes/image_manager_plus');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		$data['image_manager_plus_command']  = $this->config->get('image_manager_plus_command'); 
		$data['image_manager_plus_status']  = $this->config->get('image_manager_plus_status'); 
		
		$this->load->model('user/user');		
       $user_info = $this->model_user_user->getUser($this->user->getId());
	   
       if(!empty($user_info)){
       		$data['user_group_id'] = $user_info['user_group_id'];
       }else{
       		$data['user_group_id'] = FALSE;
       }
	   
		if (isset($this->session->data['error'])) {
    		$data['error_warning'] = $this->session->data['error'];
    
			unset($this->session->data['error']);
 		} elseif (isset($this->error['warning'])) {
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
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		$data['token'] = $this->session->data['token'];
   		$data['filemanager'] = $this->url->link('ave/image_manager_plus/popup', 'token=' . $this->session->data['token'], 'SSL');
   		$data['action'] = $this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL');
		$data['clear'] = $this->url->link('ave/image_manager_plus/clear', 'token=' . $this->session->data['token'], 'SSL');
		$data['uninstall'] = $this->url->link('ave/image_manager_plus/uninstall', 'token=' . $this->session->data['token'], 'SSL');
		$data['log_url'] = $this->url->link('ave/image_manager_plus/log_file', 'token=' . $this->session->data['token'], 'SSL');
		$data['clear_cache'] = $this->url->link('ave/image_manager_plus/clear_cache', 'token=' . $this->session->data['token'], 'SSL');
		
		
		/*Setting*/ 
		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('image_manager_plus', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL'));		
		}
		/*User_group*/ 
		$user_group_data = array();
		$this->load->model('user/user_group');
		$data['user_groups'] = array();
		$user_group_results = $this->model_user_user_group->getUserGroups($user_group_data);
		foreach ($user_group_results as $result) {		
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name']
			);
		}
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this_template = 'avethemes/tool/elfinder.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function clear() {
		$this->load->language('avethemes/image_manager_plus');
		
		$handle = fopen(DIR_LOGS.$this->file, 'w+'); 
						
		fclose($handle); 			
		
		$this->session->data['success'] = $this->language->get('text_success');
		
		$this->response->redirect($this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL'));		
	}
	
	public function log_file() {
		/*Log*/
		if (file_exists(DIR_LOGS.$this->file)) {
			$data['log'] = file_get_contents(DIR_LOGS.$this->file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['log'] = '';
		}	
		$this_template = 'avethemes/tool/elfinder_log.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
	}

    protected function log_write($log) {	
		$file = DIR_LOGS . $this->file;		
		$handle = fopen($file, 'a+'); 		
		fwrite($handle, $log);			
		fclose($handle); 
    }
	public function popup(){			
		$elfinder_path = str_replace('system/','',DIR_SYSTEM).'assets/editor/plugins/elfinder/php/';
		error_reporting(0); 
		ini_set('max_file_uploads', 50);
		ini_set('upload_max_filesize','50M'); 
		require_once($elfinder_path . 'elFinderConnector.class.php');
		require_once($elfinder_path . 'elFinder.class.php');
		require_once($elfinder_path . 'elFinderSimpleLogger.class.php');
		require_once($elfinder_path . 'elFinderVolumeDriver.class.php');
		require_once($elfinder_path . 'elFinderVolumeLocalFileSystem.class.php');
		
		$myLogger = new elFinderSimpleLogger(DIR_LOGS.$this->file);
		
		if (isset($this->session->data['image_access'])) {
			$image_access = $this->session->data['image_access'];
			$session_token = $this->session->data['token'];
			if($image_access!=$session_token){
				$log = 'At time: ['.date('d.m H:s')."]\n";
				$log .= "\tUser Access: ".$this->user->getUserName()."\n";
				$log .= "\tIP Address: ".$this->request->server['REMOTE_ADDR'];
				unset($this->session->data['image_access']);
			}
		} else {
			$this->session->data['image_access'] = $this->session->data['token'];
		}
		
		
		$image_path = ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS']))?HTTPS_CATALOG:HTTP_CATALOG;
		$opts = array(
		'bind' => array(
			'mkdir mkfile rename duplicate upload rm paste' => array($myLogger, 'log'),
		),
		'roots' => array(
				array(
					'driver'     => 'LocalFileSystem',
					'path'       => DIR_IMAGE.'catalog', 
					'startPath'  => DIR_IMAGE.'catalog', 
					'URL'        => $image_path.'image/catalog', 
					// 'alias'      => 'File system',
					'uploadOrder'  => 'deny,allow',
					'mimeDetect' => 'internal',
					'tmbPath'    => DIR_IMAGE.'thumb',         // tmbPath to files (REQUIRED)
					'tmbURL'     => $image_path.'image/thumb',
					'utf8fix'    => true,
					//'uploadMaxSize'    => '0',
					'uploadMaxSize'    => '128M',
					'tmbCrop'    => false,
					'tmbBgColor' => 'transparent',
					'accessControl' => 'access',
					'copyOverwrite' => false,
					'uploadOverwrite' => false,
					// 'uploadDeny' => array('application', 'text/xml')
				)		
			)
		);
		// run elFinder
		$this->log_write($log);
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
	}
	public function clear_cache() {
		$this->language->load('avethemes/image_manager_plus');
		if ($this->user->hasPermission('modify', 'ave/image_manager_plus')) {
			$imgfiles = glob(DIR_IMAGE . 'cache/*');
			foreach($imgfiles as $imgfile){
						 $this->deldir($imgfile);
			}
			$this->session->data['success'] = $this->language->get('text_success');
    	}else{		
      		$this->session->data['error'] = $this->language->get('error_permission');  
		}		
		$this->response->redirect($this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL'));		
	}
    private function deldir($dirname){         
		if(file_exists($dirname)) {
			if(is_dir($dirname)){
                            $dir=opendir($dirname);
                            while($filename=readdir($dir)){
                                    if($filename!="." && $filename!=".."){
                                        $file=$dirname."/".$filename;
					$this->deldir($file); 
                                    }
                                }
                            closedir($dir);  
                            rmdir($dirname);
                        }
			else {@unlink($dirname);}			
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////
	//filemanager
	public function filemanager() {
		$this->load->model('user/user');		
       $user_info = $this->model_user_user->getUser($this->user->getId());
		$language_data = $this->language->load('avethemes/image_manager_plus');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$data['image_manager_plus_command']  = $this->config->get('image_manager_plus_command'); 
		$data['image_manager_plus_status']  = $image_manager_plus_status = $this->config->get('image_manager_plus_status'); 
		$data['token'] = $this->session->data['token'];
		$data['lang'] = $this->language->get('code');
		
	   
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
       if(!empty($user_info)){
       		$data['user_group_id'] = $user_info['user_group_id'];
       }else{
       		$data['user_group_id'] = FALSE;
       }
		$data['http_image'] = ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS']))?HTTPS_CATALOG:HTTP_CATALOG.'image/';
		

		$data['token'] = $this->session->data['token'];

		// Return the field ID for the file manager to set the value
		if (isset($this->request->get['field'])) {
			$data['field'] = $this->request->get['field'];
		} else {
			$data['field'] = '';
		}
		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}
		// Return the preview for the file manager to show a preview
		if (isset($this->request->get['previewsrc'])) {
			$data['previewsrc'] = $this->request->get['previewsrc'];
		} else {
			$data['previewsrc'] = '';
		}
		
		if($image_manager_plus_status==1){
			$this_template = 'avethemes/tool/elfinder_browse.tpl';
		}else{
					
				if (isset($this->request->get['filter_name'])) {
					$filter_name = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $this->request->get['filter_name']), '/');
				} else {
					$filter_name = null;
				}
		
				// Make sure we have the correct directory
				if (isset($this->request->get['directory'])) {
					$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
				} else {
					$directory = DIR_IMAGE . 'catalog';
				}
		
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
		
				$data['images'] = array();
		
				$this->load->model('tool/image');
		
				// Get directories
				$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);
		
				if (!$directories) {
					$directories = array();
				}
				// Get files
				$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
		
				if (!$files) {
					$files = array();
				}
				// Merge directories and files
				$images = array_merge($directories, $files);
		
				// Get total number of files and directories
				$image_total = count($images);
		
				// Split the array based on current page number and max number of items per page of 10
				$images = array_splice($images, ($page - 1) * 16, 16);
		
				$server = ($this->config->get('config_secure')==1&& ('on' == $_SERVER['HTTPS']))?HTTPS_CATALOG:HTTP_CATALOG;
				foreach ($images as $image) {
					$name = str_split(basename($image), 14);
		
					if (is_dir($image)) {
						$url = '';
		
						if (isset($this->request->get['field'])) {
							$url .= '&field=' . $this->request->get['field'];
						}
		
						if (isset($this->request->get['thumb'])) {
							$url .= '&thumb=' . $this->request->get['thumb'];
						}
						if (isset($this->request->get['previewsrc'])) {
							$url .= '&previewsrc=' . $this->request->get['previewsrc'];
						}
		
						$data['images'][] = array(
							'thumb' => '',
							'name'  => implode(' ', $name),
							'type'  => 'directory',
							'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
							'href'  => $this->url->link('ave/image_manager_plus/filemanager', 'token=' . $this->session->data['token'] . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, 'SSL')
						);
					} elseif (is_file($image)) {
						// Find which protocol to use to pass the full image link back		
						$data['images'][] = array(
							'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
							'name'  => implode(' ', $name),
							'type'  => 'image',
							'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
							'href'  => $server . 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
						);
					}
				}
		
				if (isset($this->request->get['directory'])) {
					$data['directory'] = urlencode($this->request->get['directory']);
				} else {
					$data['directory'] = '';
				}
		
				if (isset($this->request->get['filter_name'])) {
					$data['filter_name'] = $this->request->get['filter_name'];
				} else {
					$data['filter_name'] = '';
				}		
		
				// Parent
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$pos = strrpos($this->request->get['directory'], '/');
		
					if ($pos) {
						$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
					}
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$data['parent'] = $this->url->link('ave/image_manager_plus/filemanager', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
				// Refresh
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$url .= '&directory=' . urlencode($this->request->get['directory']);
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$data['refresh'] = $this->url->link('ave/image_manager_plus/filemanager', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
				$url = '';
		
				if (isset($this->request->get['directory'])) {
					$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
				}
		
				if (isset($this->request->get['filter_name'])) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
				}
		
				if (isset($this->request->get['field'])) {
					$url .= '&field=' . $this->request->get['field'];
				}
		
				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}
				if (isset($this->request->get['previewsrc'])) {
					$url .= '&previewsrc=' . $this->request->get['previewsrc'];
				}
		
				$pagination = new Pagination();
				$pagination->total = $image_total;
				$pagination->page = $page;
				$pagination->limit = 16;
				$pagination->url = $this->url->link('ave/image_manager_plus/filemanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
				$data['pagination'] = $pagination->render();
				
			$this_template = 'avethemes/tool/filemanager.tpl';
		}
		

		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'ave/image_manager_plus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	public function install() {
		//image_manager_status
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('image_manager_plus_installed', array('image_manager_plus_installed' => 1));
	
			$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager_plus'");	
			$this->db->query("INSERT INTO `". DB_PREFIX ."setting` (`store_id`,`code`, `key`, `value`, `serialized`) VALUES
	(0,'image_manager_plus', 'image_manager_plus_command', 'a:1:{i:1;a:20:{s:5:\"mkdir\";s:1:\"1\";s:6:\"mkfile\";s:1:\"1\";s:6:\"upload\";s:1:\"1\";s:6:\"reload\";s:1:\"1\";s:7:\"getfile\";s:1:\"1\";s:2:\"up\";s:1:\"1\";s:8:\"download\";s:1:\"1\";s:2:\"rm\";s:1:\"1\";s:9:\"duplicate\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:3:\"cut\";s:1:\"1\";s:5:\"paste\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:7:\"extract\";s:1:\"1\";s:7:\"archive\";s:1:\"1\";s:4:\"view\";s:1:\"1\";s:6:\"resize\";s:1:\"1\";s:4:\"sort\";s:1:\"1\";s:6:\"search\";s:1:\"1\";}}', 1);");
			$this->db->query("INSERT INTO `". DB_PREFIX ."setting` (`store_id`,`code`, `key`, `value`, `serialized`) VALUES
	(0,'image_manager_plus', 'image_manager_plus_status', '1', 0);");	

		/*Import XML*/ 
		$this->load->language('extension/installer');
		$json = array();

		$file = DIR_APPLICATION .  'view/template/avethemes/xml/elfinder.ocmod.xml';

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
								$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager_plus'");	
								$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%image_manager_plus%'");
							}
					} else {
						$json['error'] = $this->language->get('error_code');
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
					
					if (!$json) {
						$this->model_extension_modification->addModification($modification_data);
					}
				} catch(Exception $exception) {
					$json['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
				$this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
			}
	}
	public function uninstall() {	
		if($this->validate()){		
			$this->db->query("DELETE FROM `" . DB_PREFIX. "setting` WHERE `key` = 'image_manager_plus_installed'");			
			$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager_plus'");	
			$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%image_manager_plus%'");
			$this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
		}else{
			$this->response->redirect($this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
?>