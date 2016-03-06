<?php
class ControllerShortcodeHome extends Controller {
	public function index() {
		if ($this->config->get('skin_nav_shortcode')) {
			$this->document->setTitle($this->config->get('config_meta_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));
			$this->document->setKeywords($this->config->get('config_meta_keyword'));
	
			if (isset($this->request->get['route'])) {
				$this->document->addLink(HTTP_SERVER, 'canonical');
			}
			if (isset($this->request->get['temp'])) {
				$get_temp = $this->request->get['temp'];
				$parts = explode('-', (string)$this->request->get['temp']);
			}else {
				$get_temp = 'home';
				$parts = array(0=>'home');
			}
			
			$get_group = isset($parts[0])?$parts[0]:'home';
			
			//<!-- Specific Page Vendor and Views -->
			$this->document->addStyle('assets/theme/css/section_bg.css');
			$this->document->addStyle('assets/theme/widget/pricing.css');
			$this->document->addStyle('assets/theme/widget/progess.css');
			$this->document->addStyle('assets/theme/widget/filter-noUI.css');
			$this->document->addStyle('assets/theme/widget/tooltip.css');
			$this->document->addStyle('assets/theme/widget/call_action.css');
			$this->document->addStyle('assets/theme/css/animate.min.css');
			$this->document->addStyle('assets/theme/widget/icon_boxed.css');
			$this->document->addStyle('assets/theme/widget/wobbly_slide.css');
			$this->document->addStyle('assets/theme/widget/slider_four_slider.css');
			$this->document->addStyle('assets/theme/widget/featured_slide.css');
			$this->document->addStyle('assets/theme/widget/isotope_filter.css');
				
				//$this->document->addStyle('assets/theme/css/animate.min.css');
				//$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				//
		
			//Home group
			if($get_group=='home'){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				$this->document->addStyle('assets/plugins/revolution-slider/settings.css');
				$this->document->addStyle('assets/plugins/revolution-slider/revolution.css');
				$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.tools.min.js');
				$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.revolution.min.js');
				$this->document->addScript('assets/plugins/revolution-slider/revolution_init.js');
			}
			
			if($get_temp=='home-2'){
				$this->document->addStyle('assets/plugins/mediaelement/mediaelementplayer.css');
				$this->document->addScript('assets/plugins/mediaelement/mediaelement-and-player.min.js');			
				
				
				
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				$this->document->addScript('assets/plugins/gmaps/gmaps_init.js');
				
			}
			if($get_temp=='home-3'){
				$this->document->addScript('assets/plugins/videobackground/jquery.videobackground.js');
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
			}
			if($get_temp=='home-4'){
				
				$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
				$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
				
	
	
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
			}
			if($get_temp=='home-5'){
				$this->document->addScript('assets/plugins/wobbly/wobbly-min.js');
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
			}
			if($get_temp=='home-one-page1'){
				$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
				$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
				
				
				$this->document->addScript('assets/plugins/nav/jquery.nav.js');
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
				$this->document->addScript('assets/plugins/youtube_player/youtube_player.min.js');
				
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
				
			}
			
			if($get_temp=='home-one-page2'){
				
				$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
				$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
				
				
				$this->document->addScript('assets/plugins/nav/jquery.nav.js');
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
			}
			if(strpos($get_temp, 'home-header-transparent') !== false){
				$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
				$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
				
				
			}
			//Blog group		
			if($get_group=='blog'){
				$this->document->addStyle('assets/plugins/mediaelement/mediaelementplayer.css');
				$this->document->addScript('assets/plugins/mediaelement/mediaelement-and-player.min.js');
							
			}
			if($get_temp=='blog-timeline'||strpos($get_temp, 'blog-masonry') !== false||strpos($get_temp, 'portfolio-') !== false){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
				
				$this->document->addStyle('assets/plugins/owl-carousel/owl.carousel.min.css');
				$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');	
					
			}
	
			//Page group	
			if($get_temp=='page-contact-us'){
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				
			}
			if($get_temp=='page-coming-soon'){
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
				
			}
			
			//Slider group	
			if($get_temp=='slider-wobbly'){
				$this->document->addScript('assets/plugins/wobbly/wobbly-min.js');
				
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			if(strpos($get_temp, 'slider-camera') !== false){
				$this->document->addStyle('assets/plugins/cameraslider/camera.css');
				$this->document->addScript('assets/plugins/cameraslider/camera.min.js');
				
			}
			
			
			if(strpos($get_temp, 'slider-owl-gallery') !== false){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
				
				$this->document->addStyle('assets/plugins/owl-carousel/owl.carousel.min.css');
				$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');	
					
			}
			if(strpos($get_temp, 'slider-flex') !== false){
				$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
				$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
				
				
			}
			if(strpos($get_temp, 'slider-four-boxes') !== false){
				$this->document->addStyle('assets/plugins/cameraslider/camera.css');
				$this->document->addScript('assets/plugins/cameraslider/camera.min.js');
				$this->document->addScript('assets/plugins/boxesFx/boxesFx.js');
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
				
			}
			if(strpos($get_temp, 'slider-owl') !== false){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			if(strpos($get_temp, 'slider-revolution') !== false){			
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
				
				$this->document->addStyle('assets/plugins/revolution-slider/settings.css');
				$this->document->addStyle('assets/plugins/revolution-slider/revolution.css');
				$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.tools.min.js');
				$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.revolution.min.js');
				$this->document->addScript('assets/plugins/revolution-slider/revolution_init.js');
			}
			
			if($get_temp=='slider-scattered'){
				$this->document->addStyle('assets/plugins/scattered-slider/scattered-slider.css');
				$this->document->addScript('assets/plugins/photostack/photostack.js');
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
				
			}
			//Shop group	
			if($get_temp=='shop'||$get_temp=='shop-check-out'){
				
				$this->document->addStyle('assets/plugins/scattered-slider/scattered-slider.css');
				$this->document->addScript('assets/plugins/nouislider/jquery.nouislider.all.min.js');				
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			
			//Elements group	
			if($get_temp=='elements-maps'){
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				$this->document->addScript('assets/plugins/world-maps/jquery.mousewheel.min.js');
				$this->document->addScript('assets/plugins/world-maps/raphael-min.js');
				$this->document->addScript('assets/plugins/world-maps/jquery.mapael.js');
				$this->document->addScript('assets/plugins/world-maps/france_departments.js');
				$this->document->addScript('assets/plugins/world-maps/world_countries.js');
				$this->document->addScript('assets/plugins/world-maps/usa_states.js');
				$this->document->addScript('assets/plugins/world-maps/examples.js');
				
				$this->document->addScript('https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true');
				$this->document->addScript('assets/plugins/gmaps/gmaps.js');
				$this->document->addScript('assets/plugins/gmaps/gmaps_init.js');
			}
			if($get_temp=='elements-charts'){
				$this->document->addScript('assets/plugins/chart/chart.min.js');
				$this->document->addScript('assets/plugins/chart/chart-functions.js');
				
				$this->document->addScript('assets/plugins/isotope/isotope.min.js');
				
			}
			
			if($get_temp=='elements-background-video'){
				$this->document->addScript('assets/plugins/videobackground/jquery.videobackground.js');
				
				$this->document->addScript('assets/plugins/youtube_player/youtube_player.min.js');
			}
		
			if(strpos($get_temp, 'home') !== false||strpos($get_temp, 'blog-') !== false||strpos($get_temp, 'elements-carousel') !== false||$get_temp=='elements-testimonials'||$get_temp=='elements-team'||strpos($get_temp, 'page-about') !== false){
				$this->document->addStyle('assets/plugins/owl-carousel/owl.carousel.min.css');
				$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');	
					
			}
			
			if($get_temp=='elements-pies-and-skills'||$get_temp=='elements-icon-boxes'||$get_temp=='elements-counters'){
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');				
			}
				$this->document->addStyle('assets/plugins/owl-carousel/owl.carousel.min.css');
				$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');	
					
				
			if (isset($this->request->get['footer_temp'])) {
				$footer_temp = $this->request->get['footer_temp'];
			}else {
				$footer_temp = 'footer';
			}
			if (isset($this->request->get['header_temp'])) {
				$header_temp = $this->request->get['header_temp'];
			}else {
				$header_temp = 'header';
			}
			//$data['footer'] = $this->load->controller('shortcode/common/footer',array('footer'=>$footer_temp));
			//$data['header'] = $this->load->controller('shortcode/common/header',array('header'=>$header_temp));
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
        
			
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/shortcode/'.$get_group.'/'.$get_temp.'.html')) {
				$this_template = $this->config->get('config_template') . '/avethemes/shortcode/'.$get_group.'/'.$get_temp.'.html';
			} else {
				$this_template = 'default/avethemes/shortcode/'.$get_group.'/'.$get_temp.'.html';
			}
			$this->response->setOutput($this->load->view($this_template, $data));
		}else{
			
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('shortcode/home')
			);
			
			$this->document->setTitle('Page not found!');

			$data['heading_title'] = 'Page not found!';

			$data['text_error'] = 'Page not found!';

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}