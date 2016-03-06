<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesPricing extends Controller {
	public function index($setting=array()) {
		if(defined('ave_check')){
			
			$this->document->addStyle('assets/theme/widget/pricing.css');
			
			
		static $module = 0;
		$data['ave'] = $this->ave;
		$language_id = $this->config->get('config_language_id');
		$this->load->language('avethemes/pricing_table');
		$this->load->model('tool/image');
		$data['text_more'] = $this->language->get('text_more');
		
		if (isset($setting['title'][$language_id])){
				$data['heading_title'] = html_entity_decode($setting['title'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$data['heading_title'] = false;
		}
		
		$template     = $setting['display'];
		$display     = $setting['display_type'];
		$data['heading_align'] = !empty($setting['heading_align'])?$setting['heading_align']:'';
		$data['icon']     = !empty($setting['icon'])?$setting['icon']:false;
		$data['bgcolor'] = !empty($setting['bgcolor'])?$setting['bgcolor']:false;
		$data['bgimage'] = !empty($setting['bgimage'])?$setting['bgimage']:false;
		$data['grid_limit'] = isset($setting['grid_limit'])?$setting['grid_limit']:'4';
		$data['grid_md'] = ($data['grid_limit']!=4||$data['grid_limit']!=12)?6:$data['grid_limit'];
		$data['carousel_limit']  = isset($setting['carousel_limit'])?$setting['carousel_limit']:'3';
		
		$number_sections = count($setting['sections']);	
		
		$data['sections'] = array();
		
		$section_row = 0;
		
		foreach($setting['sections'] as $section){
			
			if (!empty($section['image'])&&file_exists(DIR_IMAGE . $section['image'])){
				$image = 'image/'.$section['image'];
			} else {
				$image = false;
			}
			
			if (!empty($section['title'][$language_id])){
				$title = html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$title = false;
			}
			
			if (isset($section['description'][$language_id])){
				$description = html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$description = false;
			}
			if (isset($section['more_desc'][$language_id])){
				$more_desc = html_entity_decode($section['more_desc'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$more_desc = false;
			}
			if (isset($section['btn_title'][$language_id])){
				$btn_title = html_entity_decode($section['btn_title'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$btn_title = false;
			}
			
			if (isset($section['line_price'][$language_id])){
				$line_price = html_entity_decode($section['line_price'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_price = false;
			}
			if (isset($section['line_currency'][$language_id])){
				$line_currency = html_entity_decode($section['line_currency'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_currency = false;
			}
			if (isset($section['line_period'][$language_id])){
				$line_period = html_entity_decode($section['line_period'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_period = false;
			}
			if (isset($section['line_feature1'][$language_id])){
				$line_feature1 = html_entity_decode($section['line_feature1'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature1 = false;
			}
			if (isset($section['line_feature2'][$language_id])){
				$line_feature2 = html_entity_decode($section['line_feature2'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature2 = false;
			}
			if (isset($section['line_feature3'][$language_id])){
				$line_feature3 = html_entity_decode($section['line_feature3'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature3 = false;
			}
			if (isset($section['line_feature4'][$language_id])){
				$line_feature4 = html_entity_decode($section['line_feature4'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature4 = false;
			}
			if (isset($section['line_feature5'][$language_id])){
				$line_feature5 = html_entity_decode($section['line_feature5'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature5 = false;
			}
			if (isset($section['line_feature6'][$language_id])){
				$line_feature6 = html_entity_decode($section['line_feature6'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature6 = false;
			}
			if (isset($section['line_feature7'][$language_id])){
				$line_feature7 = html_entity_decode($section['line_feature7'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature7 = false;
			}
			if (isset($section['line_feature8'][$language_id])){
				$line_feature8 = html_entity_decode($section['line_feature8'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$line_feature8 = false;
			}
			
			
			
			if (isset($section['description'][$language_id])){
				$description = html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8');
			} else {
				$description = false;
			}

			$data['sections'][$section_row] = array(
				'id'          => 'table-' . $module . '-' . $section_row,
				'title'       => $title,
				'description'       => $description,
				'more_desc'       => $more_desc,
				'price'       => $line_price,
				'currency_code'       => $line_currency,
				'period'       => $line_period,
				'feature1'       => $line_feature1,
				'feature2'       => $line_feature2,
				'feature3'       => $line_feature3,
				'feature4'       => $line_feature4,
				'feature5'       => $line_feature5,
				'feature6'       => $line_feature6,
				'feature7'       => $line_feature7,
				'feature8'       => $line_feature8,
				'state'       => $section['state'],
				'btn_title'       => $btn_title,
				'href'       => $section['href'],
				'target'       => $section['target'],
				'image'       => $image,
				'icon'       => $section['icon']
			);
			$section_row++;
			
		}

		$data['module'] = 'pricing_'.$display.'_'.$module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'_'.$display.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/'.$template.'_'.$display.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/shortcodes/'.$template.'_'.$display.'.tpl';
		}
		
		return $this->load->view($this_template, $data);
	}
	}
}
?>