<?php
 /**
  * Custom footer module creates structure layout with rows and columns which standard bootstrap 3
  * and show modules inside each column in very flexiabel way without coding.
  * 
  * @version    $Id$
  * @package    Opencart 2
  * @author http://www.avethemes.com
  * @copyright  Copyright (C) 2015 avethemes.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @addition   this license does not allow theme provider using in theirs themes to sell on marketplaces.
  * @website  http://www.avethemes.com
  */

class ControllerAvethemesCustomFooter extends Controller {
	/**
	 * index action 
	 */
	public function index() {
		if($this->config->get('ave_custom_footer_status')==1){
			$setting = array(
				'class'=>$this->config->get('ave_custom_footer_data'),
				'layout'=>$this->config->get('ave_custom_footer_layout')
			);
			if(!empty($setting)){
			$layouts = json_decode($setting['layout']);
	
			$data['layouts'] = $this->buildLayoutData($layouts ,1);
			
			$data['url'] =  $this->config->get('config_secure') ? $this->config->get('config_ssl') : $this->config->get('config_url');
			
			$data['class'] = isset($setting['class'])?$setting['class']:'';
	
			$tpl = '/avethemes/template/child/ave_footer_builder.tpl';
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .$tpl)) {
				$template = $this->config->get('config_template') .$tpl;
			} else {
				$template = 'default'.$tpl;
			}
			$data['template'] = $template;
	
			return $this->load->view($template, $data);
			}
		}
	}
	/**
	 * looping render layout structures and module content inside cols and rows.
	 *
	 * @return Array $layout
	 */
    public function buildLayoutData($rows,$rl=1 ){ 
        $layout = array();
		if(!empty($rows)){
				foreach( $rows as $rkey =>  $row ){
					$row->level=$rl;
		
					$row = $this->mergeRowData( $row );
		 
					foreach( $row->cols as $ckey => $col ){
						$col = $this->mergeColData( $col );
						foreach( $col->widgets as  $wkey => $w ){
						   if( isset($w->module) ){
								$w->content = $this->renderModule(array('code'=>$w->module) );
						   }
						}
						if( isset($col->rows) ){
							$col->rows = $this->buildLayoutData( $col->rows, $rl+1 );     
						}
						$row->cols[$ckey] = $col;
					}
		   
					$layout[$rkey] = $row;
				}
		}
        return $layout;
    }

    /**
	 * direct rendering content of module by code
	 * 
	 * @return HTML Stream
	 */
	public function renderModule( $module  ){
		$part = explode('.', $module['code']);
			
		if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
			return $this->load->controller('module/' . $part[0]);
		}
		
		if (isset($part[1])) {
			$this->load->model('extension/module');
			$setting_info = $this->model_extension_module->getModule($part[1]);
			
			if ($setting_info && $setting_info['status']) {
				return $this->load->controller('module/' . $part[0], $setting_info);
			}
		}
		return ;
	}

	/**
	 * make attributes information for column
	 *
	 * @param Array $col
	 * @return Array $col
	 */
	public function mergeColData( $col ){
		$col->attrs = '';
        if( isset($col->clss) && $col->clss ){
			$col->clss = trim( $col->clss );
		}else {
			$col->clss = '';
		}
        return $col;
	}

	/**
	 * make attributes information for rows such as background,padding, margin
	 * 
	 * @param Array $row
	 * @return Array $row
	 */
	public function mergeRowData( $row ){
		$row->attrs = '';
		$styles = array();

		if( isset($row->clss) && $row->clss ){
			$row->clss =  trim( $row->clss );
		}else {
			$row->clss = '';
		}

		return $row;
	}
}
?>