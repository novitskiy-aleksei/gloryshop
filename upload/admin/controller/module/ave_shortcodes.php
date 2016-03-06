<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveShortcodes extends Controller { 
	private $error = array(); 
	private $skill_desc = array (1=>'&lt;h2 class=&quot;title1 upper&quot;&gt;Skills Description&lt;/h2&gt; &lt;p&gt;Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.&lt;/p&gt; &lt;p&gt;and scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum available, but the majority have to suffered alteration iner some form with injected randomised words which.&lt;/p&gt; &lt;ul class=&quot;list1 gray clearfix&quot;&gt; &lt;li&gt;Multiple Layout&lt;/li&gt; &lt;li&gt;Awesome Shortcodes&lt;/li&gt; &lt;li&gt;Browser Compatibility&lt;/li&gt; &lt;li&gt;Easy to Edit Animations&lt;/li&gt; &lt;li&gt;Parallax Effect&lt;/li&gt; &lt;li&gt;Responsive Design&lt;/li&gt; &lt;/ul&gt;');
	
	
	public function apply(){ 
		$this->load->language('module/ave_shortcodes');
		$this->load->model('extension/module');
		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST')&&$this->validateForm()) {
				$module_id = $this->request->get['module_id'];
			if($module_id==0){
				$this->model_extension_module->addModule('ave_shortcodes', $this->request->post);
				$new_id = $this->db->getLastId();					
				$this->session->data['success'] = $this->language->get('text_success');		
				$json['success'] = $this->language->get('text_success');	
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('module/ave_shortcodes','token='. $this->session->data['token'].'&module_id='.$new_id));
			}else{
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
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
	public function index() {
		$data['redirect'] = $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'], 'SSL');
		$data['import_module'] = $this->url->link('feed/visual_layout_builder/import_module', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_module'] = $this->url->link('feed/visual_layout_builder/export_module', '&code=ave_shortcodes&token=' . $this->session->data['token'] , 'SSL');
		
		
		$language_data = $this->load->language('module/ave_shortcodes');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($this->language->get('heading_title'));	
		$data['rstatus'] = $this->ave->validate();
		$data['heading_title'] = $this->language->get('heading_title');
		$data['animations'] = $this->ave->getAnimations();
		
		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];
		$data['elements'] = $this->elements();
		
		$this->document->addStyle('../assets/theme/css/section_bg.css');
		$this->document->addStyle('../assets/theme/widget/pricing.css');
		$this->document->addStyle('../assets/theme/widget/progess.css');
		$this->document->addStyle('../assets/theme/widget/tooltip.css');
		$this->document->addStyle('../assets/theme/widget/call_action.css');
		$this->document->addStyle('../assets/theme/css/heading.css');
		$this->document->addStyle('../assets/theme/css/animate.min.css');
		
		
		$this->load->model('extension/module');
		$data['module_data'] = array();
		$modules = $this->model_extension_module->getModulesByCode('ave_shortcodes');
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
								'delete'      => $this->url->link('module/ave_shortcodes/delete', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL'),
								'href'      => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], 'SSL')
							);
					}
		}	

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('ave_shortcodes', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['token'] = $this->session->data['token'];
		
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
			'href' => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		if (isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => 'Module ID: '.$this->request->get['module_id'],
				'href' => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['module_id'] = 0;
			$data['action'] = $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['module_id'] = $this->request->get['module_id'];
			$data['action'] = $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['add'] = $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}	
		$this->load->model('tool/image');	
		$data['placeholder'] = $no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$name = 'Module name';
		$element = '';
		$sections = '';
		$this->load->model('avethemes/shortcodes');	
		if (isset($this->request->get['element'])) {
			$element = $this->request->get['element'];
			$name = $this->language->get('text_'.$element);
			$sections = $this->model_avethemes_shortcodes->getSections($element);
		}		
		if($element=='skill'){
			$description	=$this->skill_desc; 
		}else{
			$description	=''; 
		}
		$form_configs = array(
            'name' => $name,
            'status' => 1,
			'animation'=>'fadeInUp',
            'paralax_class' => '',
			'element'=>$element,
            'display' => '',
            'display_type' => '',
            'display_style' => '',
            'grid_limit' => '4',
            'carousel_limit' => '3',
            'title' => array (1=>'Any title'),
            'skill_title' => array (1=>'Our skill'),
            'desc_position' => 'left',
            'description' => $description,
            'icon' => 'fa fa-rocket',
            'heading_align' => 'centered',
            'heading_size' => '',
            'bgmode' => '',
            'section_image' => 'catalog/avethemes/looking1.jpg',
            'bgimage' => '',
            'bgcolor' => '',
            'sections' => $sections
		);
		$module_content = array();
	
		
		
		foreach ($form_configs as $key => $value){
			if (isset($this->request->post[$key])) {
				$module_content[$key] = $data[$key] = $this->request->post[$key];
			} elseif (!empty($module_info)&&!isset($this->request->get['element'])) {
				$module_content[$key] = $data[$key] = isset($module_info[$key])?$module_info[$key]:$value;
				isset($module_info[$key])?$module_info[$key]:$value;
			} else {
				$data[$key] = $value;
				$module_content[$key] = $value;
			}
		}
		$this_template = 'avethemes/shortcodes/main_section.tpl';		
		
		$this->load->controller('ave/shortcut');
		$data['module_content'] = $this->load->controller('module/ave_shortcodes/module_data',$module_content);
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');;
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	public function getSections($element) {
		
	}
	
	public function delete() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (isset($this->request->get['module_id']) && $this->user->hasPermission('modify', 'extension/module')) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->index();
	}
	public function module_data($config=array()) {
		$data['tlangs'] = $data['flangs'] = array();
		$data['token'] = $this->session->data['token'];
		$this->load->model('tool/image');	
		$data['placeholder'] = $no_image = $this->model_tool_image->resize('no_image.png', 100, 100);
		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['animations'] = $this->ave->getAnimations();
		
		$language_data = $this->load->language('module/ave_shortcodes');
			foreach($language_data as $key=>$value){
				$data[$key] = $value;
			}
		if(!empty($config)&&file_exists(DIR_TEMPLATE.'avethemes/shortcodes/'.$config['element'].'.tpl')){
			foreach ($config as $key => $value){
					$data[$key] = $value;
			}
			/*author_team*/ 
			if($config['element']=='testimonial'){
				$this->load->model('avethemes/testimonial');		
				$data['testimonials'] = $this->model_avethemes_testimonial->getTestimonials();
				
				 if(isset($config['sections']['custom_testimonial'])){
						$data['testimonial_datas'] = array();
						foreach ($config['sections']['custom_testimonial'] as $testimonial_id) {
									$testimonial_info = $this->model_avethemes_testimonial->getTestimonial($testimonial_id);			
									if ($testimonial_info) {
										 $data['testimonial_datas'][] = array(
											'testimonial_id' => $testimonial_info['testimonial_id'],
											'customer_name'       => $testimonial_info['customer_name'].' - '.utf8_substr(strip_tags(html_entity_decode($testimonial_info['message'], ENT_QUOTES, 'UTF-8')), 0, 40) . '..'
										);
									}
					}
				} 
		
			}
			/*revoslider*/ 
			if($config['element']=='revoslider'){
				$data['insert_slider'] = $this->url->link('ave/slider_revolution/insert', 'token=' . $this->session->data['token'], 'SSL');
				$this->load->model('avethemes/slider_revolution');
				$data['revosliders'] = $this->model_avethemes_slider_revolution->getSliders();
			}
			/*author_team*/ 
			if($config['element']=='author_team'){
				$this->load->model('avethemes/author');		
				$data['authors'] = $this->model_avethemes_author->getAuthors();
			}
			/*poll*/ 
			if($config['element']=='poll'){
				$this->load->model('avethemes/poll');		
				
				$data['poll_insert'] = $this->url->link('ave/poll', 'token=' . $this->session->data['token'], 'SSL');
				$data['polls'] = $this->model_avethemes_poll->getPolls();
			}
			/*facebook*/ 
			if($config['element']=='facebook_page'||$config['element']=='facebook_comment'){
				$this->load->model('avethemes/global');	
				$data['flangs'] = $this->model_avethemes_global->getFacebookLang();
			}
			/*twitter*/ 
			if($config['element']=='twitter_timeline'){
				$this->load->model('avethemes/global');	
				$data['tlangs'] = $this->model_avethemes_global->getTwitterLang();
			}
			
			
			/*Free download*/ 
			if($config['element']=='free_download'){
				 if(isset($config['sections']['free_file'])){
						$this->load->model('avethemes/download');
						$data['download_datas'] = array();
						foreach ($config['sections']['free_file'] as $download_id) {	
							$download_info = $this->model_avethemes_download->getDownload($download_id);			
							if ($download_info) {
								$data['download_datas'][] = array(
									'download_id' => $download_info['download_id'],
									'name'       => $download_info['name']
								);
							}
						}
				 }
			}
			
			$this_template = 'avethemes/shortcodes/'.$config['element'].'.tpl';		
			return $this->load->view($this_template, $data);
		}
	}
	
	
    public function cloneSection() {
		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST')&& $this->validate()){
			$json['clone_html'] = html_entity_decode(str_replace('sections['.$this->request->post['clone_row'].']','sections['.$this->request->post['section_row'].']',$this->request->post['clone_html']), ENT_QUOTES, 'UTF-8');
			$json['success'] =1;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ave_shortcodes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/ave_shortcodes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!isset($this->request->post['sections'])) {
			$this->error['warning'] = $this->language->get('error_sections');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	protected function elements() {
		$this->load->language('module/ave_shortcodes');
		$url = '';
		if (isset($this->request->get['module_id'])) {
			$url .= '&module_id=' . $this->request->get['module_id'];
		}
		$elements[] = array(
			'label'  => $this->language->get('text_section_title'),
			'key'  => 'section_title',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=section_title')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_category_wall'),
			'key'  => 'category_wall',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=category_wall')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_description_block'),
			'key'  => 'description_block',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=description_block')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_facebook_page'),
			'key'  => 'facebook_page',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=facebook_page')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_facebook_comment'),
			'key'  => 'facebook_comment',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=facebook_comment')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_disqus_comment'),
			'key'  => 'disqus_comment',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=disqus_comment')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_google_comment'),
			'key'  => 'google_comment',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=google_comment')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_twitter_timeline'),
			'key'  => 'twitter_timeline',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=twitter_timeline')
		);
		
		$elements[] = array(
			'label'  => $this->language->get('text_social_link'),
			'key'  => 'social_link',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url . '&element=social_link')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_tabs_section'),
			'key'  => 'tabs_section',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=tabs_section')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_accordion_section'),
			'key'  => 'accordion_section',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=accordion_section')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_featured_desc'),
			'key'  => 'featured_desc',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=featured_desc')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_featured_block'),
			'key'  => 'featured_block',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=featured_block')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_featured_slider'),
			'key'  => 'featured_slider',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=featured_slider')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_featured_group'),
			'key'  => 'featured_group',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=featured_group')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_text_slider'),
			'key'  => 'text_slider',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=text_slider')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_wobbly_slider'),
			'key'  => 'wobbly_slider',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=wobbly_slider')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_pricing'),
			'key'  => 'pricing',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=pricing')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_call_to_action'),
			'key'  => 'call_to_action',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=call_to_action')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_custom_video'),
			'key'  => 'custom_video',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=custom_video')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_counter'),
			'key'  => 'counter',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=counter')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_skill'),
			'key'  => 'skill',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=skill')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_google_map'),
			'key'  => 'google_map',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=google_map')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_contact_form'),
			'key'  => 'contact_form',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=contact_form')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_contact_block'),
			'key'  => 'contact_block',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=contact_block')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_contact_info'),
			'key'  => 'contact_info',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=contact_info')
		);/*
		$elements[] = array(
			'label'  => $this->language->get('text_quote_form'),
			'key'  => 'quote_form',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=quote_form')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_testimonial_form'),
			'key'  => 'testimonial_form',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=testimonial_form')
		);*/ 
		$elements[] = array(
			'label'  => $this->language->get('text_testimonial'),
			'key'  => 'testimonial',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=testimonial')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_newsletter'),
			'key'  => 'newsletter',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=newsletter')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_sidebar_search'),
			'key'  => 'sidebar_search',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=sidebar_search')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_tags_cloud'),
			'key'  => 'tags_cloud',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=tags_cloud')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_live_preview'),
			'key'  => 'live_preview',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=live_preview')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_free_download'),
			'key'  => 'free_download',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=free_download')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_poll'),
			'key'  => 'poll',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=poll')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_author_team'),
			'key'  => 'author_team',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=author_team')
		);
		$elements[] = array(
			'label'  => $this->language->get('text_revoslider'),
			'key'  => 'revoslider',
			'value'  => $this->url->link('module/ave_shortcodes', 'token=' . $this->session->data['token'].$url. '&element=revoslider')
		);
		return $elements;
	}
}
?>