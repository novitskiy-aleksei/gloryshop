<?php
class ControllerAveSliderRevolution extends Controller {
	private $error = array();
	public function index() {
		if (!$this->config->has('slider_revolution_installed')) {
			$this->response->redirect($this->url->link('ave/slider_revolution/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
    	$this->getList();
  	}
  	public function delete_selected() {
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/slider_revolution');
			
    	if (isset($this->request->post['selected']) && $this->validatePermission()) {	  
			foreach ($this->request->post['selected'] as $primary_id) {
				$this->model_avethemes_slider_revolution->delete($primary_id);
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
			
			$this->response->redirect($this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
  	public function export() {
		$this->load->language('avethemes/slider_revolution');
		$this->load->model('avethemes/slider_revolution');		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {
			$primary_id = 0;
			if(isset($this->request->post['primary_id'])){
				$primary_id = $this->request->post['primary_id'];
			}
  			$slider_exists = $this->model_avethemes_slider_revolution->checkSlider($primary_id);
			if (!$slider_exists) {
	  			$this->session->data['warning'] = $this->language->get('error_slider_exists');	
			}else{				
      		$slider_info = $this->model_avethemes_slider_revolution->getSlider($primary_id);			
			$layer_groups_info = $this->model_avethemes_slider_revolution->getAllLayerGroupByPrimaryId($primary_id);
			
			$slider = array(			
				'title'=>$slider_info['title'].'-Import',
				'configs'=>$slider_info['configs']
			);
			$export_data =  array(
				'slider'=>serialize($slider),
				'layer_groups'=>serialize($layer_groups_info)			
			);
			$this->load->model('avethemes/keyword');
			$export_name = $primary_id.'_'.$this->model_avethemes_keyword->strip_unicode($slider_info['title']).'-export';
			
			$this->response->addHeader('Pragma: public');
			$this->response->addHeader('Expires: 0');
			$this->response->addHeader('Content-Description: File Transfer');
			$this->response->addHeader('Content-Type: application/octet-stream');
			$this->response->addHeader('Content-Disposition: attachment; filename=RevoSlider_'.$export_name.'.json');
			$this->response->addHeader('Content-Transfer-Encoding: binary');
				
			$this->response->setOutput(serialize($export_data));
			$this->session->data['success'] =  sprintf($this->language->get('text_success_export_slider'), $slider_info['title']);
			}
    	}else{
			$this->response->redirect($this->url->link('error/permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
  	public function import() {	
		$this->load->language('avethemes/slider_revolution');
		$this->load->model('avethemes/slider_revolution');		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				$filecontent = array();
				if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
					$filecontent = unserialize(file_get_contents($this->request->files['import']['tmp_name']));
				}
				$content =array();
				foreach($filecontent as $key => $value){
					$content[$key] =$value;
				}
				if(isset($content['slider'])){
					$new_slider = unserialize($content['slider']);	
					if(is_array($new_slider)){
						$primary_id =  $this->model_avethemes_slider_revolution->addSlider($new_slider);
						$layer_groups = unserialize($content['layer_groups']);
						if($primary_id) {
							foreach($layer_groups as $key=>$layer_group ){
								$layer_group['layer_group_id'] = 0;
								$layer_group['primary_id'] = $primary_id;
								$this->model_avethemes_slider_revolution->saveLayersData($layer_group);
							}
								$this->session->data['success'] =  sprintf($this->language->get('text_success_import_slider'),$primary_id);
						} 
					}
				}
		}else{
	  			$this->session->data['warning'] = $this->language->get('error_import_slider');	
		}
		$redirect = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL');			  	
		$this->response->redirect($redirect);
	}

  	public function copy() {	
		$this->load->language('avethemes/slider_revolution');
		$this->load->model('avethemes/slider_revolution');		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {
			$primary_id = false;
			$info = '';
			foreach ($this->request->post['selected'] as $primary_id) {
				if(isset($primary_id)){
					$slider_exists = $this->model_avethemes_slider_revolution->checkSlider($primary_id);
					if (!$slider_exists) {
						$this->session->data['warning'] = $this->language->get('error_slider_exists');	
					}else{				
					$slider_info = $this->model_avethemes_slider_revolution->getSlider($primary_id);			
					$layer_groups_info = $this->model_avethemes_slider_revolution->getAllLayerGroupByPrimaryId($primary_id);
					$new_slider = array(			
						'title'=>$slider_info['title'].'-Duplicate',
						'configs'=>$slider_info['configs']
					);
					$new_id =  $this->model_avethemes_slider_revolution->addSlider($new_slider);
								if($new_id) {
									foreach($layer_groups_info as $key=>$layer_group ){
										$layer_group['layer_group_id'] = 0;
										$layer_group['primary_id'] = $new_id;
										$this->model_avethemes_slider_revolution->saveLayersData($layer_group);
									}
								} 
						$info .= '+'.$slider_info['title'];		
					$this->session->data['success'] =  sprintf($this->language->get('text_success_copy_slider'),$info);
					}
				}
			}
			$this->response->redirect($this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL'));
    	}else{
			$this->response->redirect($this->url->link('error/permission', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
	public function apply(){ 
		$this->load->language('avethemes/slider_revolution');
		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST')&&$this->validateSlider()) {
				$primary_id = $this->request->post['primary_id'];
			$this->load->model('avethemes/slider_revolution');		
			if($primary_id==0){
				$new_id = $this->model_avethemes_slider_revolution->addSlider($this->request->post);					
				$this->session->data['success'] = $this->language->get('text_success');		
				$json['success'] = $this->language->get('text_success');	
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('ave/slider_revolution/update','primary_id='.$new_id .'&token='. $this->session->data['token']));
			}else{
				$this->model_avethemes_slider_revolution->updateSlider($primary_id, $this->request->post);
				$json['success'] = $this->language->get('text_success');	
			}	
		}else{
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function insert(){
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->load->model('avethemes/slider_revolution');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSlider()) {
			$this->model_avethemes_slider_revolution->addSlider($this->request->post);			
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
			$this->response->redirect($this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	public function update(){
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->load->model('avethemes/slider_revolution');		
		$this->document->setTitle($this->language->get('heading_title'));	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSlider()) {
			$this->model_avethemes_slider_revolution->updateSlider($this->request->get['primary_id'], $this->request->post);
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
			$this->response->redirect($this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
  	private function getList() {
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('avethemes/slider_revolution');
				
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'title';
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
			'href'      => $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$data['insert'] = $this->url->link('ave/slider_revolution/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['export'] = $this->url->link('ave/slider_revolution/export', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$data['import'] = $this->url->link('ave/slider_revolution/import', 'token=' . $this->session->data['token']. $url, 'SSL');			
		$data['copy'] = $this->url->link('ave/slider_revolution/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$data['delete_selected'] = $this->url->link('ave/slider_revolution/delete_selected', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['sliders'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$slider_total = $this->model_avethemes_slider_revolution->getTotalSliders();
	
		$results = $this->model_avethemes_slider_revolution->getSliders($filter_data);
    	foreach ($results as $result) {				
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'class' => '',
				'href' => $this->url->link('ave/slider_revolution/update', 'token=' . $this->session->data['token'] . '&primary_id=' . $result['primary_id'] . $url, 'SSL')
			);
			$preview = $this->url->link('ave/slider_revolution/preview', 'token=' . $this->session->data['token'] . '&primary_id=' . $result['primary_id'] . $url, 'SSL');
			$data['sliders'][] = array(
				'primary_id' => $result['primary_id'],
				'title'        => $result['title'],
				'preview'        => $preview,
				'selected'    => isset($this->request->post['selected']) && in_array($result['primary_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}	 
 		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];		
			unset($this->session->data['warning']);
		} else if (isset($this->error['warning'])) {
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

		$data['sort_name'] = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
		$data['sort_date'] = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $slider_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
	$data['results'] = sprintf($this->language->get('text_pagination'), ($slider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($slider_total - $this->config->get('config_limit_admin'))) ? $slider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $slider_total, ceil($slider_total / $this->config->get('config_limit_admin')));
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/slider_revolution/slider_list.tpl';
		$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
  	}
	private function getForm() {  
		if (!$this->config->has('slider_revolution_installed')) {
			$this->response->redirect($this->url->link('ave/slider_revolution/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->document->addStyle('../assets/plugins/revolution-slider/editor/editor.css');
		
		$this->load->model('avethemes/slider_revolution');
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$model = $this->model_avethemes_slider_revolution; 

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
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);		

		$data['cancel'] = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];

		if (!isset($this->request->get['primary_id'])) { 
			$data['primary_id'] = 0;
			$data['action'] = $this->url->link('ave/slider_revolution/insert', 'token=' . $this->session->data['token'] , 'SSL');
		} else {
			$data['primary_id'] =  $this->request->get['primary_id'];
			$data['action'] = $this->url->link('ave/slider_revolution/update', 'token=' . $this->session->data['token'] . '&primary_id=' . $this->request->get['primary_id'], 'SSL');
		}	
		$primary_id = isset($this->request->get['primary_id']) ? $this->request->get['primary_id']:0;
		
		$data['preview'] = $this->url->link('ave/slider_revolution/preview', 'primary_id='.$primary_id.'&token=' . $this->session->data['token'], 'SSL');
		$data['manager_layer'] = $this->url->link('ave/slider_revolution/layer', 'primary_id='.$primary_id.'&token=' . $this->session->data['token'], 'SSL');
		
		
		$slider_info = $model->getSlider( $primary_id );
		
		$form_configs = array(
			'title'=>'Revolution slider #',
			'configs'=>array(
					'delay' => '9500',
					'startheight' => '417',
					'startwidth'  => '1150',
					'touchenabled' => 1,
					'onHoverStop' => 1,
					'shuffle'=>'0',
					'image_cropping' => '0',
					'shadow' => '2',
					'show_time_line' => '1',
					'time_line_position' => 'top',
					'background_color' => '#d9d9d9',
					'padding'=> '0px 0px',
					'margin' => '0px 0px 0px',
					'background_image' => '0',
					'background_url'  => '',
					'navigationType' => 'none',
					'navigationArrows' => 'nexttobullets',
					'navigationStyle' => 'round',
					'navOffsetHorizontal' => '0',
					'navOffsetVertical'   => '20',
					'show_navigator' => '0',
					'hideThumbs' => '200',
					'thumbHeight' => '50',
					'thumbWidth'  => '100',
					'thumbAmount' => '5',
					'hide_screen_width' => '',
					'custom_css' => ''
				)
		);
		foreach ($form_configs as $key => $value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif (!empty($slider_info)) {
				$data[$key] = isset($slider_info[$key])?$slider_info[$key]:$value;
			} else {
				$data[$key] = $value;
			}
		}
		$data['fullwidth'] = array('' => $this->language->get('Boxed'),
										  'fullwidth'  => $this->language->get('fullwidth'),
										  'fullscreen' => $this->language->get('Fullscreen') );
										  
		$data['yesno'] = array( 1=> $this->language->get('text_yes'), 0=>$this->language->get('text_no') );
		$data['edisa'] = array( 1=> $this->language->get('text_enable'), 0=>$this->language->get('text_disable'));

		$data['shadows'] = array(
			0  	=> $this->language->get('text_none'),
			1  => 1,
			2  => 2,
			3  => 3
		);
		$data['linepostions'] = array(
			'bottom'  => $this->language->get('text_bottom'),
			'top'     => $this->language->get('text_top')
		);
		$data['navigationTypes'] = array(
			'none'  => $this->language->get('text_none'),
			'bullet'     => $this->language->get('text_bullet'),
			'thumb'     => $this->language->get('text_thumbnail'),
			'both'     => $this->language->get('text_both')
				
		);
		$data['navigation_arrows'] = array(
			'none'    			 => $this->language->get('text_none'),
			'nexttobullets' 	 => $this->language->get('text_nexttobullets'),
			'solo'   => $this->language->get('text_solo')
			
				
		);
		$data['navigationStyle'] = array(
			'preview1' 	    => 'Preview 1',
			'preview2' 	    => 'Preview 2',
			'preview3' 	    => 'Preview 3',
			'preview4' 	    => 'Preview 4',
			'round' 	    => $this->language->get('text_round'),
			'navbar'        => $this->language->get('text_navbar'),
			'round-old'     => $this->language->get('text_round_old') ,
			'square-old'    => $this->language->get('text_square_old') ,
			'navbar-old'    => $this->language->get('text_navbar_old') 
				
		);					  
					
		$this_template = 'avethemes/slider_revolution/slider_form.tpl';
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function layer(){
		$this->load->controller('ave/shortcut');
		
		$this->document->addStyle('../assets/editor/plugins/jquery-chosen/chosen.css');
		$this->document->addScript('../assets/editor/plugins/jquery-chosen/chosen.js');
		$this->document->addStyle("../assets/global/css/typography.css");
		$this->document->addStyle("../assets/plugins/revolution-slider/settings.css");
		$this->document->addStyle('../assets/editor/plugins/jquery-ui/jquery-ui.css');
		$this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js');
		$this->document->addScript('../assets/plugins/revolution-slider/editor/editor.js');
		$this->document->addStyle('../assets/plugins/revolution-slider/editor/editor.css');
		$this->load->model('avethemes/slider_revolution');
		$model = $this->model_avethemes_slider_revolution; 
		
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		


		$this->load->model('tool/image');
		
		$data['placeholder'] = $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['objurl'] = $this->url;
		$data['objsession'] = $this->session;
		$data['objlang'] = $this->language;

		if( !isset($this->request->get['primary_id'])  || !$this->request->get['primary_id']){
			$this->response->redirect( $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL') );
		}	
		$data['primary_id'] =  $primary_id = (int)$this->request->get['primary_id'];
		$layer_group_id = isset($this->request->get['layer_group_id'] ) ? $this->request->get['layer_group_id'] : 0;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);	
		$data['token'] = $this->session->data['token'];
		$data['action'] = $this->url->link('ave/slider_revolution/savedata', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL');		
		$data['actionUpdatePostURL'] = $this->url->link('ave/slider_revolution/savepos', 'token=' . $this->session->data['token'], 'SSL');
		
		$slider_info = $model->getSlider($primary_id);
		if( !$slider_info ){
			$this->response->redirect( $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL') );
		}
		$data['sliders'] = $model->getSliders();
		$data['slider_info']  = $slider_info; 
		
		$url =   $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG; 
		if(!empty($slider_info['configs']['custom_css'])){
			if (strpos($slider_info['configs']['custom_css'],'//') !== false) {
				$this->document->addStyle($slider_info['configs']['custom_css']);
			}else{
				$this->document->addStyle($url.$slider_info['configs']['custom_css']);
			}
		}
		
		$data['sliderWidth']  = $sliderWidth = (int) $slider_info['configs']['startwidth'];  
		$data['sliderHeight'] = $sliderHeight = (int) $slider_info['configs']['startheight'];
		
		$data['lang'] = $lang = isset($this->request->get['lang'])?$this->request->get['lang']:1;
		$layers_group = $model->getLayerGroupByPrimaryId($primary_id,$lang);
		
		$data['layers_group'] = array(); 
		
		if(!empty($layers_group)) {
			foreach($layers_group as $layer_group){		
				$layer_image =	$this->model_tool_image->resize($layer_group['image'], round($sliderWidth/3), round($sliderHeight/3));;	
				$data['layers_group'][] = array(
					'layer_group_id'=>$layer_group['layer_group_id'],
					'title'			=>$layer_group['title'],
					'primary_id'	=>$layer_group['primary_id'],
					'image'			=>$layer_image,
					'status'		=>$layer_group['status'],
					'position'		=>$layer_group['position'],
					'language_id'	=>$lang,
					'edit'			=>$this->url->link('ave/slider_revolution/layer', 'layer_group_id='.$layer_group['layer_group_id'].'&primary_id='.$layer_group['primary_id'].'&lang='.$lang.'&token=' . $this->session->data['token'], 'SSL'),
					'clone'			=>$this->url->link('ave/slider_revolution/copythis', 'layer_group_id='.$layer_group['layer_group_id'].'&primary_id='.$layer_group['primary_id'].'&lang='.$lang.'&token=' .  $this->session->data['token'], 'SSL'),
					'delete'			=>$this->url->link('ave/slider_revolution/deleteLayerGroup', 'layer_group_id='.$layer_group['layer_group_id'].'&primary_id='.$layer_group['primary_id'].'&lang='.$lang.'&token=' . $this->session->data['token'], 'SSL'),
					'delete'			=>$this->url->link('ave/slider_revolution/deleteLayerGroup', 'layer_group_id='.$layer_group['layer_group_id'].'&primary_id='.$layer_group['primary_id'].'&lang='.$lang.'&token=' . $this->session->data['token'], 'SSL'),
				);
			} 
		}
		
		$this->load->model("localisation/language");
		$languages = $this->model_localisation_language->getLanguages();
		
		$data['languages'] = array();
		foreach($languages as $language){	
		 	$class = ($language['language_id'] == $lang)?'active':'';
			$data['languages'][] = array(
				'language_id'	=>$language['language_id'],
				'class'			=>$class,
				'name'			=>$language['name'],
				'image'			=>$language['image'],
				'href'			=>$this->url->link('ave/slider_revolution/layer', '&primary_id='.$primary_id.'&lang='.$language['language_id'].'&token=' . $this->session->data['token'], 'SSL'),
			);
		}
		$dslider = array('status' => 1);

	 
		$group_default_setting = array(
			'title' => '',
			'slider_title' => '',
			'slider_status'  => 1,
			'data-link' => '',
			'slider_usevideo' => '0',
			'slider_videoid' => '',
			'slider_videoplay' => '0',
 			'slider_rotation'   => '0',
			'slider_enable_link' => 0,
			'data-link'  => '',
			'data-thumb' => '',
			'slider_image'   => 'catalog/avethemes/bg.jpg',
			'layer_group_id'   => '',
			'image' => 'catalog/avethemes/bg.jpg',
			'dataimg-kenburns' => '',
			'dataimg-bgfit' => '',
			'dataimg-bgfitend' => '',
			'dataimg-bgposition' => '',
			'dataimg-bgpositionend' => '',
			'dataimg-ease' => '',
			'data-transition' => 'random',
			'data-delay'   => '0',
			'data-transition' => 'random',
			'data-masterspeed'    => '300',
			'data-slotamount' =>'7',	
			'slider_enable_link' => '',
			'layers_data'=> ''
				
		);
 
		 
		$slider = $model->getLayerGroup($layer_group_id); 
		
		$times = array();
		$layers = array(); 	

		$slider = array_merge($group_default_setting, $slider ); 

		if( $slider['layers_data'] ){
			$layers = unserialize($slider['layers_data']);
			
			foreach( $layers as $k=>$l ){
				$layers[$k]['layer_caption'] = addslashes( str_replace("'",'"',html_entity_decode( $l['layer_caption'] , ENT_QUOTES, 'UTF-8')) ); 
				$layers[$k]['layer_caption'] = preg_replace( "#\n|\r|\t#","", $layers[$k]['layer_caption']);
			}
		}

		$group_setting = isset($slider['group_setting']) ? unserialize( $slider['group_setting'] ) : array();
		$group_setting['slider_language_id']=$lang;
		$group_setting = array_merge($group_default_setting, $group_setting); 

		//print('<pre>');print_r($group_setting);print('</pre>'); 

		if( $group_setting['data-thumb'] ){
			$data['data_thumb'] =  $this->model_tool_image->resize(  $group_setting['data-thumb'], 
						$slider_info['configs']['thumbWidth'], $slider_info['configs']['thumbHeight'] );
		}else {
			$data['data_thumb'] = '';
		}
  
		$data['usevideo'] = array('0'=> $this->language->get('No'),'youtube'=>'Youtube','vimeo'=>'Vimeo');
		$data['yesno'] = array( 1=> $this->language->get('text_yes'), 0=>$this->language->get('text_no') );
		$data['onoff'] = array(''=> '','on'=> $this->language->get('text_on'), 'off'=>$this->language->get('text_off') );
		$data['edisa'] = array( 1=> $this->language->get('text_enable'), 0=>$this->language->get('text_disable'));
		$data['slider_title'] = $slider['title'];
		$data['group_setting'] = $group_setting; 
		$data['layers'] = $layers;
		
		
		/*Easings Data*/ 
		$easings = $this->easings();
		$data['easings'] = array();
		foreach ($easings as $value=>$label){			
		 $data['easings'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
		}
		/*Animations In Data*/ 
		$inanimations = $this->inanimations();
		$data['inanimations'] = array();
		foreach ($inanimations as $value=>$label){			
		 $data['inanimations'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
		}
		/*Animations Out Data*/ 
		$outanimations = $this->outanimations();
		$data['outanimations'] = array();
		foreach ($outanimations as $value=>$label){			
		 $data['outanimations'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
		}
		/*Transtions Data*/ 
		$transtions = $this->transtions();
		$data['transtions'] = array();
		foreach ($transtions as $value=>$label){			
		 $data['transtions'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
		}
		/*Parallaxlevels Data*/ 
		$parallaxlevels = $this->parallaxlevels();
		$data['parallaxlevels'] = array();
		foreach ($parallaxlevels as $value=>$label){			
		 $data['parallaxlevels'][] = array(
						'value'       =>$value,
						'label'        =>$label
					);
		}
		
		$data['layer_group_id']  = $layer_group_id;
		$data['slider_image'] = $slider['image'];  
		$data['slider_image_src'] = HTTP_CATALOG.'image/'.$slider['image'];
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/tool');
		$this_template = 'avethemes/slider_revolution/layers_form.tpl';
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
		
		
	}
	protected function parallaxlevels(){
	 	$parallaxlevels = array(
				''=>'None',
				'rs-parallaxlevel-0'=>'Level 0',
				'rs-parallaxlevel-1'=>'Level 1',
				'rs-parallaxlevel-2'=>'Level 2',
				'rs-parallaxlevel-3'=>'Level 3',
				'rs-parallaxlevel-4'=>'Level 4',
				'rs-parallaxlevel-5'=>'Level 5',
				'rs-parallaxlevel-6'=>'Level 6',
				'rs-parallaxlevel-7'=>'Level 7',
				'rs-parallaxlevel-8'=>'Level 8',
				'rs-parallaxlevel-9'=>'Level 9',
				'rs-parallaxlevel-10'=>'Level 10',
		);
		return $parallaxlevels;
	}
	protected function inanimations(){
	 	$inanimations = array(
				''=>'Choose Automatic',
				'fade'=>'Fade In',
				'sft'=>'Short from Top',
				'sfb'=>'Short from Bottom',
				'sfr'=>'Short from Right',
				'sfl'=>'Short from Left',
				'lft'=>'Long from Top',
				'lfb'=>'Long from Bottom',
				'lfr'=>'Long from Right',
				'lfl'=>'Long from Left',
				'skewfromleft'=>'Skew from Left',
				'skewfromright'=>'Skew from Right',
				'skewfromleftshort'=>'Skew Short from Left',
				'skewfromrightshort'=>'Skew Short from Right',				
				'randomrotate'=>'Random Rotate',			
				'customin'=>'Custom Animation In',
		);
		return $inanimations;
	}
	protected function outanimations(){
	 	$outanimations = array(
				''=>'Choose Automatic',
				'fadeout'=>'Fade Out',
				'stt'=>'Short to Top',
				'stb'=>'Short to Bottom',
				'str'=>'Short to Right',
				'stl'=>'Short to Left',
				'ltt'=>'Long to Top',
				'ltb'=>'Long to Bottom',
				'ltr'=>'Long to Right',
				'ltl'=>'Long to Left',
				'skewtoleft'=>'Skew to Left',
				'skewtoright'=>'Skew to Right',
				'skewtoleftshort'=>'Skew Short to Left',
				'skewtorightshort'=>'Skew Short to Right',				
				'randomrotateout'=>'Random Rotate',	
				'customout'=>'Custom Animation Out'
		);
		return $outanimations;
	}
	protected function transtions(){
	 	$transtions = array(
			'slideup' =>'Slide Up',
			'slidedown' =>'Slide Down',
			'slideright' =>'Slide Right',
			'slideleft' =>'Slide Left',
			'slidehorizontal' =>'Slide Horizontal (depending on Next/Previous)',
			'slidevertical' =>'Slide Vertical (depending on Next/Previous)',
			'boxslide' =>'Slide Boxes',
			'slotslide-horizontal' =>'Slide Slots Horizontal',
			'slotslide-vertical' =>'Slide Slots Vertical',
			'boxfade' =>'Fade Boxes',
			'slotfade-horizontal' =>'Fade Slots Horizontal',
			'slotfade-vertical' =>'Fade Slots Vertical',
			'fadefromright' =>'Fade and Slide from Right',
			'fadefromleft' =>'Fade and Slide from Left',
			'fadefromtop' =>'Fade and Slide from Top',
			'fadefrombottom' =>'Fade and Slide from Bottom',
			'fadetoleftfadefromright' =>'Fade To Left and Fade From Right',
			'fadetorightfadefromleft' =>'Fade To Right and Fade From Left',
			'fadetotopfadefrombottom' =>'Fade To Top and Fade From Bottom',
			'fadetobottomfadefromtop' =>'Fade To Bottom and Fade From Top',
			'parallaxtoright' =>'Parallax to Right',
			'parallaxtoleft' =>'Parallax to Left',
			'parallaxtotop' =>'Parallax to Top',
			'parallaxtobottom' =>'Parallax to Bottom',
			'scaledownfromright' =>'Zoom Out and Fade From Right',
			'scaledownfromleft' =>'Zoom Out and Fade From Left',
			'scaledownfromtop' =>'Zoom Out and Fade From Top',
			'scaledownfrombottom' =>'Zoom Out and Fade From Bottom',
			'zoomout' =>'ZoomOut',
			'zoomin' =>'ZoomIn',
			'slotzoom-horizontal' =>'Zoom Slots Horizontal',
			'slotzoom-vertical' =>'Zoom Slots Vertical',
			'fade' =>'Fade',
			'random-static' =>'Random Flat',
			'random' =>'Random Flat and Premium',
			'curtain-1' =>'Curtain from Left',
			'curtain-2' =>'Curtain from Right',
			'curtain-3' =>'Curtain from Middle',
			'3dcurtain-horizontal' =>'3D Curtain Horizontal',
			'3dcurtain-vertical' =>'3D Curtain Vertical',
			'cube' =>'Cube Vertical',
			'cube-horizontal' =>'Cube Horizontal',
			'incube' =>'In Cube Vertical',
			'incube-horizontal' =>'In Cube Horizontal',
			'turnoff' =>'TurnOff Horizontal',
			'turnoff-vertical' =>'TurnOff Vertical',
			'papercut' =>'Paper Cut',
			'flyin' =>'Fly In',
			'random-premium' =>'Random Premium',
			'random' =>'Random Flat and Premium'
		);
		return $transtions;
	}
	protected function easings(){
	 	$easings = array(
				''=>'No change',
				'Linear.easeNone'=>'Linear.easeNone',
				'Power0.easeIn'=>'Power0.easeIn - linear',
				'Power0.easeInOut'=>'Power0.easeInOut - linear',
				'Power0.easeOut'=>'Power0.easeOut - linear',
				'Power1.easeIn'=>'Power1.easeIn',
				'Power1.easeInOut'=>'Power1.easeInOut',
				'Power1.easeOut'=>'Power1.easeOut',
				'Power2.easeIn'=>'Power2.easeIn',
				'Power2.easeInOut'=>'Power2.easeInOut',
				'Power2.easeOut'=>'Power2.easeOut',
				'Power3.easeIn'=>'Power3.easeIn',
				'Power3.easeInOut'=>'Power3.easeInOut',
				'Power3.easeOut'=>'Power3.easeOut',
				'Power4.easeIn'=>'Power4.easeIn',
				'Power4.easeInOut'=>'Power4.easeInOut',
				'Power4.easeOut'=>'Power4.easeOut',
				'Quad.easeIn'=>'Quad.easeIn - same as Power1.easeIn',
				'Quad.easeInOut'=>'Quad.easeInOut- same as Power1.easeInOut',
				'Quad.easeOut'=>'Quad.easeOut- same as Power1.easeOut',
				'Cubic.easeIn'=>'Cubic.easeIn- same as Power2.easeIn',
				'Cubic.easeInOut'=>'Cubic.easeInOut- same as Power2.easeInOut',
				'Cubic.easeOut'=>'Cubic.easeOut- same as Power2.easeOut',
				'Quart.easeIn'=>'Quart.easeIn- same as Power3.easeIn',
				'Quart.easeInOut'=>'Quart.easeInOut- same as Power3.easeInOut',
				'Quart.easeOut'=>'Quart.easeOut- same as Power3.easeOut',
				'Quint.easeIn'=>'Quint.easeIn- same as Power4.easeIn',
				'Quint.easeInOut'=>'Quint.easeInOut- same as Power4.easeInOut',
				'Quint.easeOut'=>'Quint.easeOut- same as Power4.easeOut',
				'Strong.easeIn'=>'Strong.easeIn- same as Power4.easeIn',
				'Strong.easeInOut'=>'Strong.easeInOut- same as Power4.easeInOut',
				'Strong.easeOut'=>'Strong.easeOut- same as Power4.easeOut',
				'Back.easeIn'=>'Back.easeIn',
				'Back.easeInOut'=>'Back.easeInOut',
				'Back.easeOut'=>'Back.easeOut',
				'Bounce.easeIn'=>'Bounce.easeIn',
				'Bounce.easeInOut'=>'Bounce.easeInOut',
				'Bounce.easeOut'=>'Bounce.easeOut',
				'Circ.easeIn'=>'Circ.easeIn',
				'Circ.easeInOut'=>'Circ.easeInOut',
				'Circ.easeOut'=>'Circ.easeOut',
				'Elastic.easeIn'=>'Elastic.easeIn',
				'Elastic.easeInOut'=>'Elastic.easeInOut',
				'Elastic.easeOut'=>'Elastic.easeOut',
				'Expo.easeIn'=>'Expo.easeIn',
				'Expo.easeInOut'=>'Expo.easeInOut',
				'Expo.easeOut'=>'Expo.easeOut',
				'Sine.easeIn'=>'Sine.easeIn',
				'Sine.easeInOut'=>'Sine.easeInOut',
				'Sine.easeOut'=>'Sine.easeOut',
				'SlowMo.ease'=>'SlowMo.ease',
				
				
				'easeOutBack'=>'easeOutBack',
				'easeInQuad'=>'easeInQuad',
				'easeOutQuad'=>'easeOutQuad',
				'easeInOutQuad'=>'easeInOutQuad',
				'easeInCubic'=>'easeInCubic',
				'easeOutCubic'=>'easeOutCubic',
				'easeInOutCubic'=>'easeInOutCubic',
				'easeInQuart'=>'easeInQuart',
				'easeOutQuart'=>'easeOutQuart',
				'easeInOutQuart'=>'easeInOutQuart',
				'easeInQuint'=>'easeInQuint',
				'easeOutQuint'=>'easeOutQuint',
				'easeInOutQuint'=>'easeInOutQuint',
				'easeInSine'=>'easeInSine',
				'easeOutSine'=>'easeOutSine',
				'easeInOutSine'=>'easeInOutSine',
				'easeInExpo'=>'easeInExpo',
				'easeOutExpo'=>'easeOutExpo',
				'easeInOutExpo'=>'easeInOutExpo',
				'easeInCirc'=>'easeInCirc',
				'easeOutCirc'=>'easeOutCirc',
				'easeInOutCirc'=>'easeInOutCirc',
				'easeInElastic'=>'easeInElastic',
				'easeOutElastic'=>'easeOutElastic',
				'easeInOutElastic'=>'easeInOutElastic',
				'easeInBack'=>'easeInBack',
				'easeOutBack'=>'easeOutBack',
				'easeInOutBack'=>'easeInOutBack',
				'easeInBounce'=>'easeInBounce',
				'easeOutBounce'=>'easeOutBounce',
				'easeInOutBounce'=>'easeInOutBounce'
	);
		return $easings;
	}

	public function savepos(){
		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die( $this->language->get('error_permission') ); 
		}
		if( isset($this->request->post['layer_group_id'])  && is_array($this->request->post['layer_group_id']) ){
				$this->load->model('avethemes/slider_revolution');
				 foreach( $this->request->post['layer_group_id'] as $id => $pos ){
					 $this->model_avethemes_slider_revolution->updatePost((int)$id, $pos );
				 }
		}
		die('done');
	}
	public function copythis(){
		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die( $this->language->get('error_permission') ); 
		}
		$this->load->model('avethemes/slider_revolution');
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));
		
	 	$model = $this->model_avethemes_slider_revolution;
	 	if( isset($this->request->get['layer_group_id']) ){
	 		$lang = isset($this->request->get['lang'])?$this->request->get['lang']:1;
	 		
	 		$layer_group_id = (int) $this->request->get['layer_group_id'];
	 		$slider = $slider = $model->getLayerGroup( $layer_group_id );
	 		$slider['title'] = 'Copy Of ' . $slider['title'];
	 		$slider['layer_group_id'] = 0;
	 		$slider['language_id'] = $lang;
	 		$layer_group_id = $model->saveLayersData($slider);

	 		$url = $this->url->link('ave/slider_revolution/layer', 'layer_group_id='.$layer_group_id.'&primary_id='.$slider['primary_id'].'&lang='.$lang.'&token=' . $this->session->data['token'], 'SSL');
	 		$this->response->redirect( $url );
	 	}
	 	die("Having Error");
	}

	public function cloneLayerGroup(){

		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die( $this->language->get('error_permission') ); 
		}

		$get = $this->request->get;

		$primary_id = $get['primary_id'];
		$languageID = $get['lang'];
		$cloneGroupID = $get['clonegroup'];
		if($cloneGroupID == 0) {
			die("Please select a group sliders !!!!!");
		}
		$this->load->model('avethemes/slider_revolution');
		$this->model_avethemes_slider_revolution->cloneLayerGroup($primary_id, $cloneGroupID, $languageID);
	}
 	public function deleteLayerGroup(){
 		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
			$primary_id = 0; 
		}else {
			$this->load->model('avethemes/slider_revolution');
			if( isset($this->request->get['layer_group_id']) ){ 
				$this->model_avethemes_slider_revolution->deleteLayerGroup( (int)($this->request->get['layer_group_id']) );
			}
			$primary_id = $this->request->get['primary_id'];
		}

		$lang = isset($this->request->get['lang'])?$this->request->get['lang']:1;
		
		$url = $this->url->link('ave/slider_revolution/layer', 'primary_id='.$primary_id.'&lang='.$lang.'&token=' . $this->session->data['token'], 'SSL');
	 	$this->response->redirect( $url );
 	}
	public function savedata() {
		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->language->get('error_permission') );
		}
		$this->load->model('avethemes/slider_revolution');
		$language_data = $this->load->language('avethemes/slider_revolution');
		
	 	$output = new stdClass();
	 	$output->id =	0;
	 	$output->error = 1;
	 	$output->message = $this->language->get('text_could_not_save');
	 	$model = $this->model_avethemes_slider_revolution; 
		//$this->log->write(serialize($this->request->post)); 
	 	//echo '<pre>'; print_r($this->request->post) ; die;

	  	if( empty($this->request->post['slider_title']) ){
	  		$output->message = $this->language->get('error_missing_title');	
	  		echo json_encode( $output );exit();
	  	}
	  	if( $this->request->post ){
	  		$group_setting = serialize($this->request->post);
	  		$layers_data = array();

			if( isset($this->request->post['layers'])  && !empty($this->request->post['layers']) ){
				$times 		 	= $this->request->post['layer_time'];
				$tmp 			= $this->request->post['layers'];	

				$layers = $this->request->post['layers'];

				foreach ($layers as $key => $value ) {
						$value['data-start'] = $times[$value['layer_id']];
					 	$times[$value['layer_id']] = $value;
				}

				$k = 0;
				foreach( $times as $key => $value ) {
					if( is_array($times) ) {
						$value['layer_id'] = $k+1;
						$layers_data[$k] = $value;
						$k++;
					}
				}
			
				unset( $this->request->post['layer_time'] );
				unset( $this->request->post['layers'] );


				$group_setting = serialize( $this->request->post ); 
			}

			$data = array(
				'layers_data'  => serialize($layers_data),
				'primary_id'   => $this->request->post['primary_id'],
				'title'   	   => $this->request->post['slider_title'],
				'layer_group_id'=> $this->request->post['layer_group_id'],
				'image'        => $this->request->post['slider_image'],
				'group_setting'=>  $group_setting,	
				'status'       => $this->request->post['slider_status'],
				'language_id'  => $this->request->post['slider_language_id'],
				
			);
			$id = $model->saveLayersData( $data );
		 	$output->id     = $id;
		 	$output->error  = 0;
		}
 		echo json_encode( $output );exit();
	}

	public function previewLayer() {
		$this->load->model('avethemes/slider_revolution');
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get("text_preview_this_slider");

		if( !isset($this->request->post['slider_preview_data']) ){
			die( $this->language->get('text_could_not_show_preview') );
		}
		
		$layer_group =  json_decode(trim(html_entity_decode($this->request->post['slider_preview_data'])),true) ;

		$slider_info = $this->model_avethemes_slider_revolution->getSlider($layer_group['primary_id']);

		$data['configs'] = $configs =$slider_info['configs'];
		$url =   $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG; 
			$data['custom_css'] = false;
			if(!empty($configs['custom_css'])){
				if (strpos($configs['custom_css'],'//') !== false) {
					$data['custom_css'] = '<link rel="stylesheet" href="'.$configs['custom_css'].'" type="text/css"/>';
				}else{
					$data['custom_css'] = '<link rel="stylesheet" href="'.$url.$configs['custom_css'].'" type="text/css"/>';
				}
			}
			
			if( $layer_group['group_setting']['data-thumb'] ) {
				 $layer_group['group_setting']['data-thumb'] = $url.'image/'.$layer_group['group_setting']['data-thumb']; 
			}
			
		$data['slider'] = $layer_group;

		$this_template = 'avethemes/slider_revolution/preview_layers.tpl';

		$this->response->setOutput($this->load->view($this_template, $data));
	}
	// Preview Group Layers
	public function preview() {	
		$this->load->model('avethemes/slider_revolution');
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$this->document->setTitle($this->language->get('heading_title'));

		if( isset($this->request->get['primary_id']) ){
			$primary_id = (int)$this->request->get['primary_id'];
			$slider_info = $this->model_avethemes_slider_revolution->getSlider($primary_id);
			$data['configs'] = $configs = $slider_info['configs'];
			
			$url =   $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG; 
			$data['custom_css'] = false;
			if(!empty($configs['custom_css'])){
				if (strpos($configs['custom_css'],'//') !== false) {
					$data['custom_css'] = '<link rel="stylesheet" href="'.$configs['custom_css'].'" type="text/css"/>';
				}else{
					$data['custom_css'] = '<link rel="stylesheet" href="'.$url.$configs['custom_css'].'" type="text/css"/>';
				}
			}
			$language_id = isset($this->request->get['lang'])?$this->request->get['lang']:1;

			$layers_group =  $this->model_avethemes_slider_revolution->getLayerGroupByPrimaryId($primary_id, $language_id );

			foreach( $layers_group as $key=> $slider ){
				$slider["layers"] = array();
				$slider['group_setting'] = unserialize( $slider["group_setting"] ); 
				$slider['layers_data'] = unserialize( $slider["layers_data"] ); 
				
				if( $slider_info['configs']['image_cropping']) { 
					 $slider['main_image'] = $this->model_avethemes_slider_revolution->resize($slider['image'], $slider_info['configs']['startwidth'], 
					 								$slider_info['configs']['startheight'],'a');
				}else { 
					 $slider['main_image'] = HTTP_CATALOG."image/".$slider['image'];
				}	
				
				if( $slider['group_setting']['data-thumb'] ) {
					 $slider['group_setting']['data-thumb'] = $url.'image/'.$slider['group_setting']['data-thumb']; 
				}else {
					 $slider['group_setting']['data-thumb'] = $this->model_avethemes_slider_revolution->resize($slider['image'], $slider_info['configs']['thumbWidth'], 
					 								$slider_info['configs']['thumbHeight'],'a'); 
				}
				$layers_group[$key] = $slider;
			} 
 
			$data['layers_group'] = $layers_group; 

		}
		$this_template = 'avethemes/slider_revolution/preview_slider.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
			
	}

	public function typo(){
		$language_data = $this->load->language('avethemes/slider_revolution');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	

		$data['heading_title'] = $this->language->get("typo_management");

		if (isset($this->request->get['field'])) {
			$data['field'] = $this->request->get['field'];
		} else {
			$data['field'] = '';
		}

		if (isset($this->request->get['layer_id'])) {
			$data['layer_id'] = $this->request->get['layer_id'];
		} else {
			$data['layer_id'] = '';
		}

		if (isset($this->request->get['class-layer'])) {
			$data['class-layer'] = $this->request->get['class-layer'];
		} else {
			$data['class-layer'] = '';
		}
		$this_template = 'avethemes/slider_revolution/typo.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));

	}
	
	protected function validateSlider() {

		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		 
		if( !isset($this->request->post['configs']) ){
			$this->error['warning'] = $this->language->get('error_missing_data');
		}
		if(isset($this->request->post['title']) ){
			if (utf8_strlen($this->request->post['title']) < 1) {
				$this->error['warning'] = $this->language->get('error_missing_title');
			}
		}				

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	protected function validateSliderGroup() {

		if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		 
		if( !isset($this->request->post['slider']) ){
			$this->error['warning'] = $this->language->get('error_missing_slider_data');
		}elseif(  $this->request->post['slider'] && empty($this->request->post['slider']['title']) ){
			$this->error['warning'] = $this->language->get('error_missing_slider_title');
		}				

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
  	private function validatePermission() {
    	if (!$this->user->hasPermission('modify', 'ave/slider_revolution')) {
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
		$this->load->model('avethemes/slider_revolution');
		$this->model_avethemes_slider_revolution->checkInstall();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('slider_revolution_installed', array('slider_revolution_installed' => 1));		
		$this->response->redirect($this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function uninstall() {			
		$this->db->query("DELETE FROM `" . DB_PREFIX. "setting` WHERE `key` = 'slider_revolution_installed'");
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>