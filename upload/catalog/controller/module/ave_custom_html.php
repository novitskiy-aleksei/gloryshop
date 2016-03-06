<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveCustomHtml extends Controller {
	public function index($setting=array()) {
		if(defined('ave_check')&&!empty($setting['module_description'])){
		$data['ave'] = $this->ave;
			if(strpos($setting['element'], 'skill') !== false){
				$this->document->addStyle('assets/theme/widget/progess.css');
				$this->document->addScript('assets/plugins/global-plugins.js');
				$this->document->addScript('assets/plugins/progressbar/progressbar.min.js');
			}
			$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
			$data['side_position'] = $side_position = $this->ave->sidePosition();
			$language_id 	= $this->config->get('config_language_id');
			
			$description = html_entity_decode($setting['module_description'][$language_id]['description'], ENT_QUOTES, 'UTF-8');
			$description = str_replace('../assets/','assets/',$description);
			$description = str_replace('../image/','image/',$description);
			$data['description'] = $description;
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/module/custom_html.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/module/custom_html.tpl';
			} else {
				$this_template = 'default/avethemes/template/module/custom_html.tpl';
			}
			return $this->load->view($this_template, $data);
		}
	}
}
?>