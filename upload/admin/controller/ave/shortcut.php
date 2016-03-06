<?php    
class ControllerAveShortcut extends Controller {   
  	public function index() {
		
	   $this->document->addStyle('../assets/editor/plugins/jquery-ui/jquery-ui.css');
	   $this->document->addScript('../assets/editor/plugins/jquery-ui/jquery-ui.js'); 
	   
		$this->document->addStyle('../assets/editor/plugins/spectrum/spectrum.css');
		$this->document->addScript('../assets/editor/plugins/spectrum/spectrum.js');
	   
		$this->document->addStyle('../assets/global/css/colors.css');
		$this->document->addStyle('../assets/editor/css/socials.css');
		
		$this->document->addStyle('../assets/editor/css/form.css');
		$this->document->addScript('../assets/editor/js/form.js');	
			
		$this->document->addStyle('../assets/editor/css/slider.css');
  	}
  	public function blog() {
		$route = '';
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}
		$find[0] = '/\/update/';
		$find[1] = '/\/insert/';
		$find[2] = '/\/edit/';
		$replace[0] = $replace[1] =$replace[2] = '';
		$data['route'] = preg_replace($find, $replace, $route); 
		
		$language_data = $this->load->language('avethemes/shortcut');
		
		$data['shortcuts'][] = array(
				'route' => 'ave/article',
				'text' => $this->language->get('text_article'),
				'class' => 'fa-newspaper-o',
				'href' => $this->url->link('ave/article', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/category',
				'text' => $this->language->get('text_category'),
				'class' => 'fa-folder-o',
				'href' => $this->url->link('ave/category', 'token=' . $this->session->data['token'], 'SSL')
		);	
		$data['shortcuts'][] = array(
				'route' => 'ave/service',
				'text' => $this->language->get('text_service'),
				'class' => 'fa-trophy',
				'href' => $this->url->link('ave/service', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/author',
				'text' => $this->language->get('text_author'),
				'class' => 'fa-users',
				'href' => $this->url->link('ave/author', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/comment',
				'text' => $this->language->get('text_comment'),
				'class' => 'fa-comment-o',
				'href' => $this->url->link('ave/comment', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['shortcuts'][] = array(
				'route' => 'ave/download',
				'text' => $this->language->get('text_download'),
				'class' => 'fa-download',
				'href' => $this->url->link('ave/download', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['shortcuts'][] = array(
				'route' => 'ave/poll',
				'text' => $this->language->get('text_poll'),
				'class' => 'fa-area-chart',
				'href' => $this->url->link('ave/poll', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['shortcuts'][] = array(
				'route' => 'ave/dashboard',
				'text' => $this->language->get('text_setting'),
				'class' => 'fa-gear',
				'href' => $this->url->link('ave/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$this_template =  'avethemes/content/shortcut.tpl';
		return $this->load->view($this_template, $data);
	}
  	public function service() {
		$route = '';
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}
		$find[0] = '/\/update/';
		$find[1] = '/\/insert/';
		$find[2] = '/\/edit/';
		$replace[0] = $replace[1] =$replace[2] = '';
		$data['route'] = preg_replace($find, $replace, $route); 
		
		$language_data = $this->load->language('avethemes/shortcut');
		$data['shortcuts'][] = array(
				'route' => 'ave/quote',
				'text' => $this->language->get('text_quote'),
				'class' => 'fa-legal',
				'href' => $this->url->link('ave/quote', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/testimonial',
				'text' => $this->language->get('text_testimonial'),
				'class' => 'fa-comment-o',
				'href' => $this->url->link('ave/testimonial', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/contact',
				'text' => $this->language->get('text_contact'),
				'class' => 'fa-pencil-square-o',
				'href' => $this->url->link('ave/contact', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['shortcuts'][] = array(
				'route' => 'ave/newsletter',
				'text' => $this->language->get('text_newsletter'),
				'class' => 'fa-envelope-o',
				'href' => $this->url->link('ave/newsletter', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		
		$this_template =  'avethemes/content/shortcut.tpl';
		return $this->load->view($this_template, $data);
		
	}
  	public function tool() {
		$route = '';
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}
		$find[0] = '/\/update/';
		$find[1] = '/\/insert/';
		$find[2] = '/\/edit/';
		$replace[0] = $replace[1] =$replace[2] = '';
		$data['route'] = preg_replace($find, $replace, $route); 
		
		$language_data = $this->load->language('avethemes/shortcut');
		$data['shortcuts'][] = array(
				'route' => 'feed/visual_layout_builder',
				'text' => $this->language->get('text_layout_composer'),
				'class' => 'fa-cubes',
				'href' => $this->url->link('feed/visual_layout_builder', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/skin',
				'text' => $this->language->get('text_theme_manager'),
				'class' => 'fa-eyedropper',
				'href' => $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/image_manager_plus',
				'text' => $this->language->get('text_image_manager'),
				'class' => 'fa-folder-o',
				'href' => $this->url->link('ave/image_manager_plus', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/seo_keyword',
				'text' => $this->language->get('text_seo_keyword'),
				'class' => 'fa-eye',
				'href' => $this->url->link('ave/seo_keyword', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/ocmod_manager',
				'text' => $this->language->get('text_modification'),
				'class' => 'fa-code',
				'href' => $this->url->link('ave/ocmod_manager', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/slider_revolution',
				'text' => $this->language->get('text_revslider'),
				'class' => 'fa-film',
				'href' => $this->url->link('ave/slider_revolution', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['shortcuts'][] = array(
				'route' => 'ave/custom_footer',
				'text' => $this->language->get('text_custom_footer'),
				'class' => 'fa-tasks',
				'href' => $this->url->link('ave/custom_footer', 'token=' . $this->session->data['token'], 'SSL')
		);
		$this_template =  'avethemes/content/shortcut.tpl';
		return $this->load->view($this_template, $data);
		
	}
}
?>