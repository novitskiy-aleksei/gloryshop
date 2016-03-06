<?php
class ControllerAveNewsletter extends Controller {
	private $error = array();
	public function index() {
		$this->load->model('avethemes/global');
		$this->model_avethemes_global->checkSubscribe();
		$this->getList();
	}

	public function insert() {
		$language_data = $this->load->language('avethemes/newsletter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/newsletter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_newsletter->addEmail($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getForm();
	}
	public function update() {
		$language_data = $this->load->language('avethemes/newsletter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));		
		
		$this->load->model('avethemes/newsletter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_newsletter->editEmail($this->request->get['email_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getForm();
	}
	public function export() {
		if ($this->user->hasPermission('modify', 'ave/newsletter')) {			
			$this->response->addHeader('Pragma: public');
			$this->response->addHeader('Expires: 0');
			$this->response->addHeader('Content-Description: File Transfer');
			$this->response->addHeader('Content-Type: application/octet-stream');
			$this->response->addHeader('Content-Disposition: attachment; filename=subcriber_emails.csv');
			$this->response->addHeader('Content-Transfer-Encoding: binary');
			
			$this->load->model('avethemes/newsletter');
			$fields=array('email_id','email','firstname','lastname','subscribed','code','store_id');			
			$this->response->setOutput($this->model_avethemes_newsletter->export($fields));
		} else {
			$this->response->redirect($this->url->link('error/permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function csvImport($file, $delim=",") {

		$this->load->model('setting/setting');
		$this->load->model('avethemes/newsletter');
		$this->load->model('sale/customer');
		
		//load any existing settings and set correct values
		$settings = $this->model_setting_setting->getSetting('subcriber_import');
		foreach ($settings as $key => $value) {
			if($value != '') {
				$settings[$key] = $value ? $this->ave->decodeSetting($value) : $value;
			}
		}
		
		//get the delimiter and use the set one
		if(isset($settings['subcriber_import_delimiter']) && $settings['subcriber_import_delimiter'] != '') {
			//if tab, assign it to actual tab not /t
			if ($settings['subcriber_import_delimiter'] == '\t') {
				$settings['subcriber_import_delimiter'] = "\t";
			}
			$delim = $settings['subcriber_import_delimiter'];
		}
		
		
		//table driven fields
		$customer_data = array(
			'firstname' => '',
			'lastname' => '',
			'email' => '',
			'subscribed	' => '',
			'code' => '',
			'store_id' => 0
		);
		
	    $fh = fopen($file, 'r');

		// Get headings
		$headings = fgetcsv($fh, 0, $delim);
		$num_cols = count($headings);
	    $num_rows = 0;

	    //Read the file as csv
	    while (($row = fgetcsv($fh, 0, $delim)) !== FALSE) {

			//skip product if broken row (although broken row probably means broken whole file)
			if (count($row) != $num_cols) {
	    		continue;
	    	}
	    	
			$raw_data = array(); // will contain product from csv
	    	$customer = array();  // will contain new customer to add
	    	$raw_data = array_combine($headings, $row);

	    	//if the customer contains a skip value, skip the customer
	    	if(isset($settings['subcriber_import_ignore_field']) && isset($settings['subcriber_import_ignore_value'])) {
	    		if(isset($settings['subcriber_import_ignore_field']) && isset($data[$settings['subcriber_import_ignore_field']]) && isset($raw_data[$data[$settings['subcriber_import_ignore_field']]]) && $raw_data[$data[$settings['subcriber_import_ignore_field']]] == $settings['subcriber_import_ignore_value']) {
	    			continue;
	    		}
	    	}	    	
    		
			// loop over customer_data array adding product table data
			foreach ($customer_data as $field => $default_value) {
				if (isset($data[$field]) && isset($raw_data[$data[$field]])) {
					$customer[$field] = $raw_data[$data[$field]];
				}
				else {
					$customer[$field] = $default_value;
				}
			}
			
			// Is this an update?
	        $update_id = 0;
	        
        	if (isset($customer['email']) && ($customer['email'] != '')) {
        		$update_value = $customer['email'];
        		$update_id = $this->model_avethemes_newsletter->getSubcriberByEmail($update_value);
        	}
        	

 	        //EXISTING PRODUCT:
 	        if ($update_id) {
        		$this->model_avethemes_newsletter->editEmail($update_id, $customer);
 	        } else {
 	        	//NEW PRODUCT
        		$this->model_avethemes_newsletter->addEmail($customer);
        		$this->total_items_added++;
	       	}	
	       	//ADD THE CUSTOMER
	       	$num_rows++;
	       	
	    }

	    fclose($fh);

	    return $num_rows;
	}
	
	public function delete() { 
		$language_data = $this->load->language('avethemes/newsletter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));		
		
		$this->load->model('avethemes/newsletter');
		
		if (isset($this->request->post['selected'])) {
      		foreach ($this->request->post['selected'] as $id) {
				$this->model_avethemes_newsletter->deleteEmail($id);	
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		$language_data = $this->load->language('avethemes/newsletter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ave_newsletter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$config_data = array(
			'ave_newsletter_unsubscribe'=>1,
			'ave_newsletter_mail_status'=>1,
			'ave_newsletter_registered'=>1,
		);
	
        foreach ($config_data as $key=>$value) {
            if (isset($this->request->post[$key])) {
                $data[$key] = $this->request->post[$key];
            } elseif($this->config->has($key)) {
                $data[$key] = $this->config->get($key);
            } else{
                $data[$key] = $value;
			}
        }	
		


		
		$this->load->model('setting/setting');
		$this->load->model('avethemes/newsletter');
		
		$field_data = array(
			'firstname',
			'lastname',
			'email',
			'subscribed',
			'code',
			'store_id'
		);
		
		$data['language']= array();
		$data['field_data'] = $field_data;
		//load each language item
		foreach ($field_data as $field) {		
			if (isset($this->request->post[$field])) {
				//add each field setting to settings array
				$data[$field] = $this->request->post[$field];
			}else{
				$data[$field] = $field;
			}			
			$data['language'][$field] = $this->language->get('text_'.$field);
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$filter_subscribed = $this->request->get['filter_subscribed'];
		} else {
			$filter_subscribed = null;
		}

		if (isset($this->request->get['filter_list'])) {
			$filter_list = $this->request->get['filter_list'];
		} else {
			$filter_list = null;
		}

		if (isset($this->request->get['filter_store'])) {
			$filter_store = $this->request->get['filter_store'];
		} else {
			$filter_store = null;
		}

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
		
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_limit_admin');
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}

		if (isset($this->request->get['filter_store'])) {
			$url .= '&filter_store=' . $this->request->get['filter_store'];
		}
		
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
       		'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

  		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		
		$data['insert'] 		= $this->url->link('ave/newsletter/insert', 'token=' . $this->session->data['token']. $url, 'SSL');
		$data['delete'] 		= $this->url->link('ave/newsletter/delete', 'token=' . $this->session->data['token']. $url, 'SSL');
		$data['export'] 		= $this->url->link('ave/newsletter/export', 'token=' . $this->session->data['token']. $url, 'SSL');	
		$data['import'] 		= $this->url->link('ave/newsletter', 'token=' . $this->session->data['token']. $url, 'SSL');	
				
		$data['text_oc_title']  = $this->language->get('text_oc_title');
		$data['text_csv_title']  = $this->language->get('text_csv_title');
		$data['text_export']  = $this->language->get('text_export');
		$data['text_default'] = $this->language->get('text_default');	
		$data['text_import']  = $this->language->get('text_import');
		$data['upload_excel'] = $this->language->get('text_import');
		$data['text_sample']  = $this->language->get('text_sample');
		
		
		$data['tab_email_list']  = $this->language->get('tab_email_list');
		$data['tab_export']  = $this->language->get('tab_export');
		$data['tab_import']  = $this->language->get('tab_import');
		
		$data['entry_tab']  = $this->language->get('entry_tab');
		$data['entry_delimiter']  = $this->language->get('entry_delimiter');
		$data['entry_contains']  = $this->language->get('entry_contains');
		$data['entry_ignore_fields']  = $this->language->get('entry_ignore_fields');
		$data['entry_export']  = $this->language->get('entry_export');
		$data['entry_import']  = $this->language->get('entry_import');
		$data['button_export']  = $this->language->get('button_export');
		$data['button_import']  = $this->language->get('button_import');
		
		$data['help_import'] = $this->language->get('help_import');
		
		if(isset($this->request->get['page'])) {
	            $page = $this->request->get['page'];
		}else{
		        $page = 1;
		}
	
		$data['emails'] = array();
		
		
		$filter_data = array(
			'filter_name'		=> $filter_name,
			'filter_email'		=> $filter_email,
			'filter_subscribed'	=> $filter_subscribed,
			'filter_list'		=> explode(',', $filter_list),
			'filter_store'		=> $filter_store,
			'sort'				=> $sort,
			'order'				=> $order,
			'start'				=> ($page - 1) * $limit,
			'limit'				=> $limit
		);
		
		
		$email_total = $this->model_avethemes_newsletter->getTotal($filter_data);		
		$results = $this->model_avethemes_newsletter->getList($filter_data);

		foreach ($results as $result) {
			$action = array();
			if($result['subscribed']){
					$action[] = array(
						'text' => $this->language->get('button_unsubscribe'),
						'href' => $this->url->link('ave/newsletter/unsubscribe', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'], 'SSL')
					);	
			}else{
				$action[] = array(
					'text' => $this->language->get('button_subscribe'),
					'href' => $this->url->link('ave/newsletter/subscribe', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'], 'SSL')
				);	
			}
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/newsletter/update', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'], 'SSL')
			);		
		
			$data['emails'][] = array(
				'email_id' 		 => $result['email_id'],
				'name' 		 => $result['name'],
				'email' 	 => $result['email'],
				'subscribed' 		 => $result['subscribed'],
				'store_name' => $result['store_id']?$result['store_name']:$this->language->get('text_default'),
				'action'     => $action
			);
		}	
	 
 		$settings = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			//save the current settings
			$settings = $this->request->post;
			foreach ($settings as $key => $value) {
				$settings[$key] = $this->ave->encodeSetting($value);
			}
			$this->model_setting_setting->editSetting('subcriber_import', $settings);
			
			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
				$content = file_get_contents($this->request->files['import']['tmp_name']);
			} else {
				$content = false;
			}
			
			if ($content) {
				$this->csvImport($this->request->files['import']['tmp_name']);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->error['warning'] = $this->language->get('error_empty');
			}
		}
		
		//load any existing settings and set correct values
		$settings = $this->model_setting_setting->getSetting('subcriber_import');
		foreach ($settings as $key => $value) {
			if($value != '') {
				$data[$key] = $value ? $this->ave->decodeSetting($value) : $value;
			} else {
				$data[$key] = '';
			}
		}
		
		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];	
			unset($this->session->data['warning']);
		}elseif (isset($this->error['warning'])) {
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
		
		if (isset($this->session->data['total_imported_emails'])) {
			$data['success'] = sprintf($this->language->get('message_imported'),$this->session->data['total_imported_emails']); 
			unset($this->session->data['total_imported_emails']);
		}
		
 		if (isset($this->session->data['total_existing_emails'])) {
			$data['error_warning'] = sprintf($this->language->get('message_already_imported'),$this->session->data['total_existing_emails']);
			unset($this->session->data['total_existing_emails']);
		}
		
			$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
											
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}

		if (isset($this->request->get['filter_store'])) {
			$url .= '&filter_store=' . $this->request->get['filter_store'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_name'] = $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_email'] = $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
		$data['sort_subscribed'] = $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . '&sort=subscribed' . $url, 'SSL');
		$data['sort_store'] = $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . '&sort=store_id' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}

		if (isset($this->request->get['filter_store'])) {
			$url .= '&filter_store=' . $this->request->get['filter_store'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		
		
		$pagination = new Pagination();
		$pagination->total = $email_total;
		$pagination->page  = $page;
		$pagination->limit = $limit;
		$pagination->text  = $this->language->get('text_pagination');
		$pagination->url   = $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

$data['results'] = sprintf($this->language->get('text_pagination'), ($email_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($email_total - $this->config->get('config_limit_admin'))) ? $email_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $email_total, ceil($email_total / $this->config->get('config_limit_admin')));
	

		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		$data['token'] = $this->session->data['token'];
		
			$data['limits'] = array();
			
			$data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=' . $this->config->get('config_catalog_limit'), 'SSL')
				);
					
			$data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=50', 'SSL')
			);

			$data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=100', 'SSL')
			);
			
			$data['limits'][] = array(
				'text'  => 500,
				'value' => 500,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=500', 'SSL')
			);	
			
			$data['limits'][] = array(
				'text'  => 1000,
				'value' => 1000,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=1000', 'SSL')
			);
			
			$data['limits'][] = array(
				'text'  => 2000,
				'value' => 2000,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=2000', 'SSL')
			);
			
			$data['limits'][] = array(
				'text'  => 5000,
				'value' => 5000,
				'href'  => $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token'] . $url . '&limit=5000', 'SSL')
			);
			
			
		$data['filter_limit'] = $limit;
		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_subscribed'] = $filter_subscribed;
		$data['filter_list'] = explode(',', $filter_list);
		$data['filter_store'] = $filter_store;
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['sort_name'] = $this->url->link('ave/newsletter/', 'token=' . $this->session->data['token']);
		
		$this_template = 'avethemes/service/subscribe_list.tpl';
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view($this_template, $data));
 	}

	private function getForm() {
	
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_error_install']=$this->language->get('text_error_install');
		
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_subscribed'] = $this->language->get('entry_subscribed');
		
		
		$data['text_default'] = $this->language->get('text_default');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

			$list_data = $this->config->get('newsletter_design_subscribe_list');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['error_firstname'])) {
			$data['error_firstname'] = $this->error['error_firstname'];
		} else {
			$data['error_firstname'] = '';
		}
		
 		if (isset($this->error['error_email_exist'])) {
			$data['error_email_exist'] = $this->error['error_email_exist'];
		} else {
			$data['error_email_exist'] = '';
		}
		
  		$data['breadcrumbs'] = array();

  		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

  		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['email_id'])) {
			$data['action'] = $this->url->link('ave/newsletter/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('ave/newsletter/update', 'token=' . $this->session->data['token'] . '&email_id=' . $this->request->get['email_id'], 'SSL');
		}
		
		$data['token'] = $this->session->data['token'];
		  
    	$data['cancel'] = $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['email_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$email_info = $this->model_avethemes_newsletter->getEmail($this->request->get['email_id']);
		}
		
		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		
		if (isset($this->request->post['store_id'])) {
			$data['store_id'] = $this->request->post['store_id'];
		} elseif (isset($email_info)) {
			$data['store_id'] = $email_info['store_id'];
		} else {
			$data['store_id'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($email_info)) {
			$data['firstname'] = $email_info['firstname'];
		} else {
			$data['firstname'] = '';
		}
		
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($email_info)) {
			$data['lastname'] = $email_info['lastname'];
		} else {
			$data['lastname'] = '';
		}
		
		if (isset($this->request->post['subscribed'])) {
			$data['subscribed'] = $this->request->post['subscribed'];
		} elseif (isset($email_info)) {
			$data['subscribed'] = $email_info['subscribed'];
		} else {
			$data['subscribed'] = 1;
		}
		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (isset($email_info)) {
			$data['code'] = $email_info['code'];
		} else {
			$data['code'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (isset($email_info)) {
			$data['email'] = $email_info['email'];
		} else {
			$data['email'] = '';
		}
		
			
		$this_template = 'avethemes/service/subscribe_form.tpl';
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/service');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	public function unsubscribe() {

		$this->load->model('avethemes/newsletter');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['email_id']))
			$this->model_avethemes_newsletter->unsubscribe($this->request->get['email_id']);

		$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function subscribe() {
		$this->load->model('avethemes/newsletter');
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['email_id']))
			$this->model_avethemes_newsletter->subscribe($this->request->get['email_id']);

		$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function add() {
		$this->load->language('avethemes/newsletter');
		$this->load->model('avethemes/newsletter');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_subscribed'])) {
			$url .= '&filter_subscribed=' . $this->request->get['filter_subscribed'];
		}

		if (isset($this->request->get['filter_list'])) {
			$url .= '&filter_list=' . $this->request->get['filter_list'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}	
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->post['emails']) && isset($this->request->post['store_id'])) {
			$count = $this->model_avethemes_newsletter->add($this->request->post, $this->config->get('newsletter_design_key'));
			$this->session->data['success'] = sprintf($this->language->get('text_success'), $count);
		}

		$this->response->redirect($this->url->link('ave/newsletter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'ave/newsletter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	private function validateForm() {
		
	$this->load->model('avethemes/newsletter');
		
		if (!$this->user->hasPermission('modify', 'ave/newsletter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

	 if(!filter_var($this->request->post['email'],FILTER_VALIDATE_EMAIL)){
		$this->error['error_firstname'] = $this->language->get('error_email');
		}
		
	 	if(isset($this->request->get['email_id']) and $this->request->get['email_id']!=""){
		    
			if($this->model_avethemes_newsletter->checkmail($this->request->post['email'],$this->request->post['store_id'],$this->request->get['email_id']))
			 $this->error['error_email_exist'] = $this->language->get('error_email_exist');
			 
		}else{
			
		   if($this->model_avethemes_newsletter->checkmail($this->request->post['email'],$this->request->post['store_id']))
		   $this->error['error_email_exist'] = $this->language->get('error_email_exist');
		 
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
?>