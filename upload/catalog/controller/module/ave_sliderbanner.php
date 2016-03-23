<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveSliderBanner extends Controller {
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$this->load->language('avethemes/global_lang');
		$data['ave'] = $this->ave;
		$data['language_id'] = $this->config->get('config_language_id');
		$data['thumb_display'] = isset($setting['thumb_display'])?$setting['thumb_display']:false;
		$data['mobile_display'] = isset($setting['mobile_display'])?$setting['mobile_display']:'';
		$data['carousel_autoplay'] = isset($setting['carousel_autoplay'])?$setting['carousel_autoplay']:3000;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['smartSpeed']     = (isset($setting['smartSpeed'])&&!empty($setting['smartSpeed']))?$setting['smartSpeed']:'900';
		static $module = 0;
		$this->load->model('tool/image');
			
			
		$data['text_larger'] = $this->language->get('text_larger');
		$data['text_more'] = $this->language->get('text_more');
			
			$width = 320;
			$height = 200;		
		if (!empty($setting['image_width'])&&!empty($setting['image_height'])) {			
			$width = $setting['image_width'];
			$height = $setting['image_height'];
		}
					
			$popup_width = 800;
			$popup_height = 500;
		if (!empty($setting['popup_width'])&&!empty($setting['popup_height'])) {			
			$popup_width = $setting['popup_width'];
			$popup_height = $setting['popup_height'];
		}
			$thumb_width = 120;
			$thumb_height = 75;
		if (!empty($setting['thumb_width'])&&!empty($setting['thumb_height'])) {			
			$thumb_width = $setting['thumb_width'];
			$thumb_height = $setting['thumb_height'];
		}
		
		$template = 'slider_flat_slider';		
		if (!empty($setting['display'])) {	
			$template = $setting['display'];
		}
		
		$carousel_limit = '6';		
		if (!empty($setting['carousel_limit'])) {	
			$carousel_limit = $setting['carousel_limit'];
		}
		$grid_limit = '4';		
		if (!empty($setting['grid_limit'])) {	
			$grid_limit = $setting['grid_limit'];
		}
		
		if (!empty($setting['custom_title'][$this->config->get('config_language_id')])) {
      		$heading_title = html_entity_decode($setting['custom_title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
      		$heading_title = '';		
		}
		
		if (!empty($setting['custom_description'][$this->config->get('config_language_id')])) {
			$description = html_entity_decode($setting['custom_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
			$description='';
		}
		if($template=='slider_cover-photo'){
			$this->document->addStyle('assets/theme/widget/featured_slide.css');
		}
		
		if($template=='slider_four_slider'){
			$this->document->addStyle('assets/theme/widget/slider_four_slider.css');
			$this->document->addScript('assets/plugins/boxesFx/boxesFx.js');
		}
		if($template=='slider_camera_slider'){
			$this->document->addStyle('assets/plugins/cameraslider/camera.css');
			$this->document->addScript('assets/plugins/cameraslider/camera.min.js');
			
		}
		if($template=='slider_flex_slider'){
			$this->document->addStyle('assets/plugins/flexslider/flexslider.css');
			$this->document->addScript('assets/plugins/flexslider/flexslider-min.js');
			
			
		}
		
		if($template=='slider_popup-gallery'||$template=='slider_cover-photo'){
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/skin/smooth-skin/skin.css');
			$this->document->addStyle('assets/plugins/jquery-lightbox/css/lightbox.css');
			$this->document->addScript('assets/plugins/jquery-mousewheel/jquery.mousewheel.js');
			$this->document->addScript('assets/plugins/jquery-lightbox/js/lightbox.min.js');
		}
				
		$data['carousel_limit']=$carousel_limit;	
		$data['grid_limit']=$grid_limit;	
		$data['width']=$width;		
		$data['height']=$height;
		$data['slide_width']=$width;		
		$data['slide_height']=$height;
		$data['description']=$description;		
		$data['heading_title']=$heading_title;
		$language_id = $this->config->get('config_language_id');
		$data['banners'] = array();
		$data['bgmode']=$setting['bgmode'];
		
		$banner_info = $setting['banner_image'];
		  
		foreach ($banner_info as $info) {
			if ($this->request->server['HTTPS']) {
				$full_image = HTTPS_SERVER.'image/'.$info['image'];
			} else {
				$full_image = HTTP_SERVER.'image/'.$info['image'];
			}
		
				$title = isset($info['title'][$language_id]) ? html_entity_decode($info['title'][$language_id], ENT_QUOTES, 'UTF-8') : '';
				$title2 = isset($info['title2'][$language_id]) ? html_entity_decode($info['title2'][$language_id], ENT_QUOTES, 'UTF-8') : '';
				$title3 = isset($info['title3'][$language_id]) ? html_entity_decode($info['title3'][$language_id], ENT_QUOTES, 'UTF-8') : '';
				$title4 = isset($info['title4'][$language_id]) ? html_entity_decode($info['title4'][$language_id], ENT_QUOTES, 'UTF-8') : '';
				
			if ($info['image'] && file_exists(DIR_IMAGE . $info['image'])) {
				$popup =  $this->model_tool_image->resize($info['image'], $popup_width, $popup_height);
				$image =  $this->model_tool_image->resize($info['image'], $width, $height);
				$thumb =  $this->model_tool_image->resize($info['image'], $thumb_width, $thumb_height);
			} else {
				$popup =  $this->model_tool_image->resize('no_image.png', $popup_width, $popup_height);
				$image =  $this->model_tool_image->resize('no_image.png', $width, $height);
				$thumb =  $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
			}		
			if (file_exists(DIR_IMAGE . $info['image'])) {
				$data['banners'][] = array(
					'title' => $title,
					'title2' => $title2,
					'title3' => $title3,
					'title4' => $title4,
					'link'  => $info['link'],
					'full_image' => $full_image,
					'popup' => $popup,					
					'image' => $image,				
					'thumb' => $thumb
				);
			}
		}
		
		$data['module'] = 'sliderbanner_'.$template.'_'.$module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/banner/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/banner/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/banner/'.$template.'.tpl';
		}
        return $this->load->view($this_template, $data);
		}
	}
}
?>