<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveShortcodes extends Controller {
	public function index($setting=array()) {
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/shortcodes');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		static $module = 0;
		$data['language_id'] = $language_id = $this->config->get('config_language_id');
		$this->load->model('tool/image');
		$data['text_more'] = $this->language->get('text_more');
		
		if (isset($setting['title'][$language_id])){
				$data['heading_title'] = html_entity_decode($setting['title'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$data['heading_title'] = false;
		}
		
		if (isset($setting['skill_title'][$language_id])){
				$data['skill_title'] = html_entity_decode($setting['skill_title'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$data['skill_title'] = false;
		}
		if (isset($setting['description'][$language_id])){
				$data['description'] = html_entity_decode($setting['description'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$data['description'] = false;
		}
		
		$template     = $setting['element'];
		if($setting['element']=='call_to_action'){
			$this->document->addStyle('assets/theme/widget/call_action.css');
		}
		
		if($setting['element']=='google_map'){
			$this->document->addScript('http://maps.google.com/maps/api/js?sensor=true');
			$this->document->addScript('assets/plugins/gmaps/gmaps.js');
		}
		if($setting['element']=='newsletter'){
      		$data['ave_newsletter_unsubscribe'] = $this->config->get('ave_newsletter_unsubscribe');	
	   		$this->document->addScript('assets/theme/js/newsletter.js');	
		}
			
		$data['icon']     = !empty($setting['icon'])?$setting['icon']:false;
		$data['heading_size'] = !empty($setting['heading_size'])?$setting['heading_size']:'';
		$data['heading_align'] = !empty($setting['heading_align'])?$setting['heading_align']:'';
		$data['section_image'] = !empty($setting['section_image'])?$setting['section_image']:false;
		$data['bgmode'] = !empty($setting['bgmode'])?$setting['bgmode']:'';
		$data['bgcolor'] = !empty($setting['bgcolor'])?$setting['bgcolor']:false;
		$data['bgimage'] = !empty($setting['bgimage'])?$setting['bgimage']:false;
		$data['paralax_class'] = isset($setting['paralax_class'])?$setting['paralax_class']:'';
		
		$data['desc_position'] = !empty($setting['desc_position'])?$setting['desc_position']:'left';
		
		$data['grid_limit'] = isset($setting['grid_limit'])?$setting['grid_limit']:3;
		$data['carousel_limit'] = isset($setting['carousel_limit'])?$setting['carousel_limit']:3;
		$data['display_type'] = isset($setting['display_type'])?$setting['display_type']:3;
		
		$data['display'] = $setting['display'];
		$data['sections'] = $setting['sections'];
		
		/*testimonial template*/ 
		if($setting['element']=='testimonial'){
			$data['testimonials'] = 	 $this->load->controller('content/testimonial/widget', $setting);
		}
		
		/*author_team template*/ 
		if($setting['element']=='author_team'){
			$template     = 'author';
			$setting['author_id'] = $setting['sections']['author_id'];
			$setting['description'] = $setting['sections']['description'];
			$data['author_team'] = 	 $this->load->controller('content/author/widget', $setting);
			
		}
		/*poll template*/ 
		if($setting['element']=='poll'){
			$setting['poll_id'] = $setting['sections']['poll_id'];
			$data['poll'] = 	 $this->load->controller('avethemes/community_poll', $setting);
			
		}
		/*free_download template*/ 
		if($setting['element']=='free_download'){
			$data['free_download'] = 	 $this->load->controller('content/article/free_download', $setting);
			
		}
		/*tags_cloud template*/ 
		if($setting['element']=='pricing'){
			$data['pricing_data'] = 	 $this->load->controller('avethemes/pricing', $setting);
			
		}
		/*sidebar_search template*/ 
		if($setting['element']=='sidebar_search'){
			$data['advanced_blog'] = $this->url->link('content/search');
			$data['advanced_product'] = $this->url->link('product/search');
				
			if (isset($this->request->get['filter_name'])) {
				$data['filter_name'] = $this->request->get['filter_name'];
			} else {
				$data['filter_name'] = $this->language->get('text_keyword');
			}
		}
		/*tags_cloud template*/ 
		if($setting['element']=='tags_cloud'){
			$data['tags_cloud'] = 	 $this->load->controller('avethemes/tags_cloud', $setting['sections']);
		}
		/*contact_form template*/ 
		if($setting['element']=='contact_form'){
			$template     = $setting['display'];
		}
		/*featured_desc template*/ 
		if($setting['element']=='featured_desc'){
			$template     = $setting['display'];
		}
		/*featured_block template*/ 
		if($setting['element']=='featured_block'){
			$template     = $setting['display'];
			$this->document->addStyle('assets/theme/widget/icon_boxed.css');
		}
		/*newsletter template*/ 
		if($setting['element']=='newsletter'&&in_array($position,$side_position)){
			$template = 'newsletter_sidebar';
		}
		/*featured_block template*/ 
		if($setting['element']=='tabs_section'){
			$template     = $setting['display'];
		}
		/*featured_group template*/ 
		if($setting['element']=='featured_group'){
			$template     = $setting['display'];
		}
		/*wobbly_slider template*/ 
		if($setting['element']=='wobbly_slider'){
			$this->document->addStyle('assets/theme/widget/wobbly_slide.css');
			$this->document->addScript('assets/plugins/wobbly/wobbly-min.js');
		}
		
		/*category_wall*/ 
		if($setting['element']=='category_wall'){
			$this->document->addStyle('assets/theme/widget/category_wall.css');
		}
		/*facebook_page template*/ 
		if($setting['element']=='facebook_page'){
			$this->document->addStyle('assets/theme/widget/fb_chat.css');
		}
		/*skill template*/ 
		if($setting['element']=='skill'){
			$this->document->addStyle('assets/theme/widget/progess.css');
			$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
			$template     = $setting['display'];
		}
		/*poll template*/ 
		if($setting['element']=='revoslider'){
			$setting['primary_id'] = $setting['sections']['primary_id'];
			$data['revoslider'] = 	 $this->load->controller('avethemes/slider_revolution', $setting);
			
		}

		$data['module'] = 'shortcodes_'.$template.'_'.$module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/shortcodes/'.$template.'.tpl';
		}
		
		return $this->load->view($this_template, $data);
	}
	}
}
?>