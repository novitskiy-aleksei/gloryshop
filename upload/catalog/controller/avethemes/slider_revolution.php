<?php  
/******************************************************
 * @package Pav Sliders Layers module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesSliderRevolution extends Controller { 
	public function index( $setting ) { 
	if(defined('ave_check')){
		$data['ave'] = $this->ave;
		static $module = 0;

		$this->load->model('avethemes/slider_revolution');
		$this->load->model('tool/image');

		$model = $this->model_avethemes_slider_revolution;
		$primary_id = isset($setting['primary_id'])?(int)$setting['primary_id']:0;

		$this->document->addStyle('assets/global/css/typography.css');
		$this->document->addStyle('assets/plugins/revolution-slider/settings.css');
		$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.tools.min.js');	 
		$this->document->addScript('assets/plugins/revolution-slider/jquery.themepunch.revolution.min.js');	 


 	 	$url =   $this->config->get('config_secure') ? $this->config->get('config_ssl') : $this->config->get('config_url'); 
 		
 		$data['url'] = $url;

 		$slider_info = $model->getSliderGroupById( $primary_id );

 		$languageID = $this->config->get('config_language_id');

		$sliders = $model->getSlidersByGroupId($primary_id, $languageID);
		if(empty($sliders)){
			$sliders = $model->getSlidersByGroupId($primary_id, 1);
		}

		$data['configs'] = $configs =  $slider_info['configs'];
		
		if(!empty($configs['custom_css'])){
			if (strpos($configs['custom_css'],'//') !== false) {
				$this->document->addStyle($configs['custom_css']);
			}else{
				$this->document->addStyle($url.$configs['custom_css']);
			}
		}
	 
		if( isset($configs['fullwidth']) && (!empty($configs['fullwidth']) || $configs['fullwidth'] == 'boxed') ){
			$configs['image_cropping'] = false; 
		}
		foreach( $sliders as $key=> $slider ){
			$slider["layers"] = array();
			$slider['group_setting'] = unserialize( $slider["group_setting"] ); 
			$slider['layers_data'] = unserialize($slider["layers_data"]); 
			
			if( $configs['image_cropping']) { 
				 $slider['main_image'] = $model->resize($slider['image'], $configs['startwidth'], 
				 								$configs['startheight'],'a');
			}else { 
				 $slider['main_image'] = $url."image/".$slider['image'];
			}	
			if( $configs['image_cropping']) { 
				if( $slider['group_setting']['data-thumb'] ) {
					$slider['group_setting']['data-thumb'] = $model->resize( $slider['group_setting']['data-thumb'], $configs['thumbWidth'], 
					 								$configs['thumbHeight'],'a'); 
				}else {
					$slider['group_setting']['data-thumb'] = $model->resize($slider['image'], $configs['thumbWidth'], $configs['thumbHeight'],'a'); 
				}
			}else {
				if( $slider['group_setting']['data-thumb'] ) {
					 $slider['group_setting']['data-thumb']= $url."image/".$slider['group_setting']['data-thumb'];
				}else {
					 $slider['group_setting']['data-thumb'] = $url."image/".$slider['image'];
				}
				
			}
			$sliders[$key] = $slider;
		} 
		$data['sliders'] = $sliders; 

		$data['module'] = 'slider_revolution'.$module++;
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/revoslider_module.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/revoslider_module.tpl';
		} else {
			$this_template ='default/avethemes/template/shortcodes/revoslider_module.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	}
}
?>