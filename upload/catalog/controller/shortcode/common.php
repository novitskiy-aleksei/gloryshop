<?php
class ControllerShortcodeCommon extends Controller {
	public function index() {
		return false;
	}
	public function header($setting) {
		if (!empty($setting['header'])) {
			$template = $setting['header'];
		}else{
			$template = 'header';
		}
		$data['title'] = $this->document->getTitle();

		
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		if ($this->config->get('config_google_analytics_status')) {
			$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		} else {
			$data['google_analytics'] = '';
		}

		$data['name'] = $this->config->get('config_name');


		$this->load->language('common/header');
		
		$classes = array();
		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$classes[] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$classes[] = 'common-home';
		}
		$gests = array(
			'body_boxed',
			'dark',
			'preloader1',
			'preloader2',
			'preloader3',
			'header_light',
			'dark_sup_menu',
			'menu_button_mode',
			'header_transparent',
			'navigation_aside',
			'menu_style',
			'menu_style',
			'menu_style',
			'menu_style',
		);
		
		foreach($gests as $key){
			if (isset($this->request->get[$key])) {
				$classes[] = $this->request->get[$key];
				$data[$key] = $this->request->get[$key];
			}else{
				$data[$key] = false;
			}
		}
		if (isset($this->request->get['header_mode'])) {
			$data['header_mode']= $this->request->get['header_mode'];
		}else {
			$data['header_mode'] = 'header_light';
		}
		
		$data['class'] = implode(' ', $classes);
		
		
		$data['menu'] = $this->load->controller('shortcode/common/menu');
			$data['message'] = '<section class="section section-message"><div class="alert alert-success"><div class="content"><i class="fa fa-info"></i> Message: You\'re visiting to the html shortcode area. It is only reference static html data for developer!</div></div></section>';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/shortcode/common/'.$template.'.html')) {
			$this_template =  $this->config->get('config_template') . '/avethemes/shortcode/common/'.$template.'.html';
		} else {
			$this_template =  'default/avethemes/shortcode/common/'.$template.'.html';
		}
		return $this->load->view($this_template, $data);
	}
	public function menu() {
		$gests = array(
		'color'=>NULL,
		'shop'=>NULL,
		'signin'=>NULL,
		);
		foreach($gests as $key=>$value){
			if (isset($this->request->get[$key])) {
				$data[$key] = true;
			}else{
				$data[$key] = NULL;
			}
		}
		$get_temp = 'home';
		if (isset($this->request->get['temp'])) {
			$get_temp = $this->request->get['temp'];
		}
		if ($get_temp =='home-one-page2') {
			$menu = 'menu2';
		}elseif ($get_temp =='home-one-page1') {
			$menu = 'menu1';
		}else{
			$menu = 'menu';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/shortcode/common/'.$menu.'.html')) {
			$this_template = $this->config->get('config_template') . '/avethemes/shortcode/common/'.$menu.'.html';
		} else {
			$this_template = 'default/avethemes/shortcode/common/'.$menu.'.html';
		}
		return $this->load->view($this_template, $data);
	}
	public function footer($setting) {
		if (!empty($setting['temp'])) {
			$template = $setting['temp'];
		}else{
			$template = 'footer';
		}
		
		$data['scripts'] = $this->document->getScripts();
		
		$data['informations'] = array();
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/shortcode/common/'.$template.'.html')) {
			$this_template =  $this->config->get('config_template') . '/avethemes/shortcode/common/'.$template.'.html';
		} else {
			$this_template =  'default/avethemes/shortcode/common/'.$template.'.html';
		}
		return $this->load->view($this_template, $data);
	}
}