<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avetheme.com
 * @copyright	Copyright (C) January 2015 www.avetheme.com <@emai:luavietcms@gmail.com>.All rights reserved.
 * @license	GNU General Public License version 2
*******************************************************/
class Ave {	
	private $store_url;
	private $skin_id = 0;
	private $data = array();
	private $version = '1.0';
	private $data_text = array();
	
  	public function __construct($config,$request,$db) {
		define('ave_check',1);
		$this->config = $config;
		$this->request = $request;
		$this->db = $db;
	}
	public function store_url(){
		return $this->store_url;
	}
	public function getConfig($key){
		return $this->config->get($key);
	}
	public function theme(){
		return 'enar';
	}
	public function ocver(){
		return substr((string)str_replace('.','',VERSION),0,3);
	}
	public function init($key){
		$default_values =  $this->getDefaultValue();
		include_once('helper.php');
		$this->fc = $default_values[$key];
		$fc = $this->fc;
		$re = $this->$fc[17]();
		$collate = array($fc[15]=>$this->$fc[13](),$fc[16]=>$re[45]($this->$fc[14]($re[33].$fc[11].$fc[12])));
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}
		$helper = new Ave_helper($store_url,$re,$collate);
		$this->helper = $helper;
		$this->store_url = $store_url;
	}
	public function additionalData($param){
		foreach ($param as $key=>$value) {
				$this->data[$key] = $value; 
		}
	}
	public function initData($param){
		$default_values =  $this->getDefaultValue();
		if(!empty($param['theme_setting_data'])){
			$theme_setting = $param['theme_setting_data'];
			unset($param['theme_setting_data']);	
		}else{
			$theme_setting = $default_values;	
		}
		foreach ($param as $key=>$value) {
			$this->data[$key] = $value; 
		}
		/*Skin data*/ 		
		foreach ($default_values as $object=>$value) {
			 if (isset($theme_setting[$object])) {
    			$this->data[$object] = $theme_setting[$object];
			 }else{              	
				$this->data[$object] = $value; 
			 }
		} 	
		/*Text data*/ 
		$skin_text = $this->data['translate'];	
		$lang_code = $this->data['LanguageCode'];
		$available_texts =  $this->getTranslateText();  
      	foreach ($available_texts as $object=>$value) {
			 if (isset($skin_text[$object])) {  
				 $this->data_text[$object] =  $skin_text[$object];
			 }else{              	
				$this->data_text[$object] = $value; 
			 }
        }
	}
/********************************************************/
/*      			. getDefaultValue					*/
/********************************************************/	
	public function skin_configs() {
	 $skin_configs = array(
					/*Contact Page*/ 
					'skin_lic_key'	=> 'F95903-18AC02-5DB7',
					'skin_purchase_code'	=> '',
					'skin_lic_message'	=> '',
					'skin_lang_dir'	=> array('en'=>'ltr'),
					'skin_nav_shortcode'	=>'0',
					'skin_minify_code'	=>'0',
					'skin_seo_optimize'	=>'1',
					'skin_internal_link'	=>'0',
					'skin_sub_domain'	=>'',
					'skin_compression_html'	=>'0',
					'skin_remove_comment'	=>'0',
					'skin_oc_comment'	=>'1',
					/*Optimizer*/ 	
					'skin_css_delivery'	=>'0',
					'skin_put_js_bottom'	=>'0',
					'skin_cp_enabled'					=>'1',
					'skin_cp_user'					=>'1',
					'skin_social_data'			=>array(0=>array('icon'=>FALSE,'link'=>FALSE,'title'=>FALSE,'sort_order'=>FALSE,'target'=>FALSE)),
					'skin_query_details'					=>'1',
					'skin_footer_info_title'			=>array(),
					'skin_footer_info_desc'			=>array(),
					'skin_header_step_info'			=>array(
													 array(
														'icon'=>'fa fa-truck',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Goal definition'),
														'description'=>array(1=>'Lorem ipsum')
													  ),
													 array(
														'icon'=>'fa fa-gift',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Analyse'),
														'description'=>array(1=>'Adipisicing eiusmod')
													  ),
													 array(
														'icon'=>'fa fa-phone',
														'href'=>'',
														'target'=>'_blank',
														'title'=>array(1=>'Implementation'),
														'description'=>array(1=>'Sed unde')
													  )
													),	
					'skin_powered_desc' =>array(),
					'skin_payment_icons_status'			=>0, 
					'skin_payment_icons_data'			=>array('image'=>FALSE,'sort_order'=>FALSE,'title'=>FALSE), 
					'skin_zoom_image_width'			=>'960',
					'skin_zoom_image_height'			=>'960',
					'skin_layout_refresh'=>'0',
					'skin_layout_builder_show_option'=>'hide_module_option',
					'skin_layout_builder_module_display'=>1,
					'skin_layout_builder_preview_urls'=>unserialize('a:15:{i:6;a:2:{s:9:"layout_id";s:1:"6";s:11:"preview_url";s:31:"index.php?route=account/account";}i:10;a:2:{s:9:"layout_id";s:2:"10";s:11:"preview_url";s:33:"index.php?route=affiliate/account";}i:3;a:2:{s:9:"layout_id";s:1:"3";s:11:"preview_url";s:44:"index.php?route=product/category&amp;path=20";}i:7;a:2:{s:9:"layout_id";s:1:"7";s:11:"preview_url";s:29:"index.php?route=checkout/cart";}i:12;a:2:{s:9:"layout_id";s:2:"12";s:11:"preview_url";s:31:"index.php?route=product/compare";}i:8;a:2:{s:9:"layout_id";s:1:"8";s:11:"preview_url";s:35:"index.php?route=information/contact";}i:15;a:2:{s:9:"layout_id";s:2:"15";s:11:"preview_url";s:48:"index.php?route=content/article&amp;article_id=1";}i:14;a:2:{s:9:"layout_id";s:2:"14";s:11:"preview_url";s:49:"index.php?route=content/category&amp;content_id=1";}i:4;a:2:{s:9:"layout_id";s:1:"4";s:11:"preview_url";s:27:"index.php?route=common/home";}i:1;a:2:{s:9:"layout_id";s:1:"1";s:11:"preview_url";s:27:"index.php?route=common/home";}i:11;a:2:{s:9:"layout_id";s:2:"11";s:11:"preview_url";s:60:"index.php?route=information/information&amp;information_id=4";}i:5;a:2:{s:9:"layout_id";s:1:"5";s:11:"preview_url";s:36:"index.php?route=product/manufacturer";}i:2;a:2:{s:9:"layout_id";s:1:"2";s:11:"preview_url";s:49:"index.php?route=product/product&amp;product_id=42";}i:13;a:2:{s:9:"layout_id";s:2:"13";s:11:"preview_url";s:30:"index.php?route=product/search";}i:9;a:2:{s:9:"layout_id";s:1:"9";s:11:"preview_url";s:35:"index.php?route=information/sitemap";}}')
					
		);
		return $skin_configs;
	}
	public function getDefaultValue(){
				$footer_info_display = array(1,2,3,4,5,6,7,8,9);
				$default_values = array(
					/*Layout*/ 
					'skin_color'	=> '#0dc0c0',
					'animated'					=>'with-animated',
					'preloader'					=>'with-loading',
					'nav_btn_mode'					=>'',
					'color_mode'					=>'body_light',
					'primary_btn'					=>'btn-primary-base',
					'default_btn'					=>'default-btn',
					'nav_transparent'					=>'header_not_transparent',
					'navigation_mode'					=>'header_light',
					'navigation_sub'					=>'sub_nav_dark',
					'custom_logo'					=>'0',
					'config_custom_logo'					=>'image/catalog/logo.png',
					'header_top_status'					=>'header_top_show',
					'header_top_color'					=>'header-top-default',
					'cart_status'					=>'1',
					'body_style'					=>'body-wide',
					'translate'						=>array(),
					'desktop'						=>array(),
					'layout_desktop_left'			=>array(),
					'layout_desktop_right'			=>array(),
					'layout_desktop_content'		=>array(),
					
					'tablet'						=>array(),
					'layout_tablet_rest'			=>array(),
					
					'extra_top_left'			=>'3',
					'extra_top_right'				=>'9',
					'extra_bottom_left'			=>'3',
					'extra_bottom_right'				=>'9',
					'different_desktop_extra_top_left'				=>array(),
					'different_desktop_extra_top_right'				=>array(),
					'different_desktop_extra_bottom_left'				=>array(),
					'different_desktop_extra_bottm_right'			=>array(),	
									
					'different_tablet_extra_top_left'		=>array(),
					'different_tablet_extra_top_right'		=>array(),
					'different_tablet_extra_bottom_left'	=>array(),
					'different_tablet_extra_bottom_right'	=>array(),	
						
					'layout_tablet_extra_top_left'			=>'12',
					'layout_tablet_extra_top_right'				=>'12',
					'layout_tablet_extra_bottom_left'			=>'12',
					'layout_tablet_extra_bottom_right'				=>'12',
					
					
					'top_left'			=>'3',
					'top_right'				=>'9',
					'bottom_left'			=>'3',
					'bottom_right'				=>'9',
					'different_desktop_top_left'				=>array(),
					'different_desktop_top_right'				=>array(),
					'different_desktop_extra_top_left'				=>array(),
					'different_desktop_extra_top_right'				=>array(),
					'different_desktop_bottom_left'				=>array(),
					'different_desktop_bottom_right'			=>array(),	
					'different_desktop_extra_bottom_left'				=>array(),
					'different_desktop_extra_bottom_right'			=>array(),					
					'different_tablet_top_left'		=>array(),
					'different_tablet_top_right'		=>array(),
					'different_tablet_bottom_left'	=>array(),
					'different_tablet_bottom_right'	=>array(),								
					
					
					'layout_tablet_top_left'			=>'12',
					'layout_tablet_top_right'				=>'12',
					'layout_tablet_bottom_left'			=>'12',
					'layout_tablet_bottom_right'				=>'12',
					'default_tablet_layout'				=>'left',
					'desktop_left'				=>'3',
					'desktop_right'				=>'3',
					'desktop_content'			=>'6',
					'tablet_content'			=>'8',
					'tablet_rest'				=>'4',
					'mobile'					=>array(
									'column_left'		=>'xs-visible',
									'column_right'		=>'xs-visible',
									'pre_header'		=>'xs-visible',
									'after_header'		=>'xs-visible',
									'top'				=>'xs-visible',
									'top_extra'			=>'xs-visible',
									'extra_top'			=>'xs-visible',
									'extra_bottom'		=>'xs-visible',
									'bottom'			=>'xs-visible',
									'bottom_extra'		=>'xs-visible',
									'pre_footer'		=>'xs-visible'
					),									
					'ajax_search'				=>'with-ajax_search',			
					'search_status'				=>1,					
					'search_image_width'			=>'120',			
					'search_image_height'			=>'75',			
					'search_result_limit'		=>'4',	
					'back_to_top'				=>'1',
					
					/*Body*/
					'body_bg'					=>'0',
					/*Main Content*/ 		
					'name_display_type'			=>'name_1line',
					'image_flip'				=>'image_flip',
					/*Header*/ 		
					'header_bg'					=>'0',
					'header_fixed'				=>'header-scroll',
					'header_style'				=>'header_style_1',
					'header_top_style'			=>'dark',
					'header_quick_support'			=>'1',
					'menu_count_item'			=>'0',
					
					'menu_sort'	=>'nav_catalog,nav_content,skin_pin_brand,skin_pin_product,skin_pin_information,skin_pin_download,nav_shortcode',
					
					'nav_catalog_status'		=>'1',         
					'nav_content_status'			=>'1',
					'skin_pin_brand_status'			=>'0', 
					'skin_pin_product_status'		=>'0',
					'skin_pin_information_status'	=>'0',
					'skin_pin_download_status'		=>'0',
					
					'skin_pin_product'		=>array(),
					'skin_pin_download'		=>array(),
					'nav_catalog'	=>array(),
					
					'skin_pin_brand_limit'		=>'5',
					'skin_pin_logo_width'		=>'240',
					'skin_pin_logo_height'		=>'150',
					/*Category*/
					'preview_category_thumb'		=>'1',
					'preview_desc_limit'		=>'64',
					'preview_image_width'		=>'240',
					'preview_image_height'		=>'150',
					'preview_content_image_width'		=>'240',
					'preview_content_image_height'		=>'150',
					
					'category_refine'		=>'show',
					'category_btn_cart'		=>'1',
					'category_btn_whistlist'		=>'1',
					'category_btn_compare'		=>'1',
					'category_special_label'		=>'1',
					
					'btn_quickview'		=>'1',	
					'btn_cart'		=>'1',	
					'btn_whistlist'		=>'1',	
					'btn_compare'		=>'1',	
					
					'related_with_special'		=>'0',
					'ribbon_special_status'		=>'1',	
					'ribbon_featured_status'	=>'1',			
					'ribbon_latest_status'		=>'1',		
					'ribbon_bestseller_status'	=>'1',	
					
					/*Default Footer*/ 				
					'footer_support_bg'			=>'green-meadow-bg',
					'default_footer_sort'	=>'information,service,extras,account',
					
					'footer_style'			=>'footer_dark',		
					'footer_information'		=>array('icon'=>'','status'=>1,'display'=>array(1,2,3,4,5,6,7,8,9)),
					'footer_service'			=>array('icon'=>'','status'=>1,'display'=>array(1,2,3,4,5,6,7,8,9)),
					'footer_extras'				=>array('icon'=>'','status'=>1,'display'=>array(1,2,3,4,5,6,7,8,9)),
					'footer_account'			=>array('icon'=>'','status'=>1,'display'=>array(1,2,3,4,5,6,7,8,9)),					
					'oc' 						=> array('helper','init','val','stt','minify','createOutput','minScript',
														'minScripts','minStyle','minStyles','parse','_lic','_key',
														'theme','getConfig','tm','cp','ref'),
					/*Custom Footer*/
					'powered_position'		=>'pull-left',
					'skin_pin_information_title'			=>array(), 
					'skin_pin_download_title'			=>array(), 
					'skin_pin_product_title'			=>array(), 
					'skin_pin_brand_title'			=>array(), 
					'social_status'			=>'0',
					/*Orther*/ 
					'custom_js_status'	=>'1',
					'custom_css_status'	=>'1',
					'custom_css'	=>'/*Custom Css*/',
					'custom_js'	=>'/*Custom Javascript*/',	
					'main_shadow'		=>'',		
					
					'body_font'				=>'Open Sans',
					'heading_font'			=>'Oswald',
					'name_font'				=>'Open Sans',
					'price_font'			=>'Open Sans',
					'product_related'		=>array(
						'type'		=>'carousel-grid',	
						'status'		=>'1',	
						'grid_limit'		=>'4',//3 item
						'carousel_limit'		=>'3',//3 item
						'carousel_autoplay'		=>'false'
					),
					'product_binding'		=>array(
						'image_type'		=>'1',	
						'zoom_type'			=>'',	
						'zoomWindowWidth'	=>'400',	
						'zoomWindowHeight'	=>'400',	
						'lensSize'	=>'150',	
						'lightbox_skin'		=>'metro-black',	
						'add_image_view'		=>'owl-carousel',
						'special_label'		=>'1',
						'addthis_widget'		=>'1',
						'btn_cart'		=>'1',
						'btn_whistlist'		=>'1',
						'btn_compare'		=>'1'
					),
					/*Pin navigation Binding*/ 		
					'pin_binding'		=>array(
						'image_width'		=>'400',
						'image_height'		=>'400',
						'carousel_limit'		=>'4'//2 item
					),
					'button_css'			=>array(					
					),
					'body_css'			=>array(	
								'body_bg_custom_image'		=>'',							
								'body_font_size'			=>'13',
								'body_bg_color'				=>'#fafafa',
								'body_font_weight'			=>'',
								'body_bg_image'				=>'',
								'body_bg_position'			=>'center top',
								'body_bg_repeat'			=>'repeat',
								'body_bg_attachment'		=>'scroll',
								'body_bg_size'				=>'',
								'body_color'				=>'#555',
								'body_letter_spacing'			=>'0',
								'link_color'				=>'#0dc0c0',
								'link_hover_color'			=>'#0dc0c0',
								'link_active_color'			=>'#037da6',
								'selection_color'			=>'#fff',	
								'selection_bg'			=>'#0dc0c0'
					),		
					'catalog_css'			=>array(	
								'name_font_weight'			=>'500',
								'name_font_size'			=>'15.5',
								'name_font_style'			=>'normal',
								'name_text_transform'			=>'none',
								'name_color'			=>'#555',
								'name_hover_color'			=>'#E84D1C',
								'name_letter_spacing'			=>'0',
													
								'price_font_weight'			=>'500',
								'price_font_size'			=>'18',
								'price_new_color'			=>'#e84d1c',
								'price_old_color'			=>'#bbb',
								'price_tax_color'			=>'#555',
								'price_letter_spacing'			=>'0',
								'rating_color'				=>'#ffb200',
								'special_bg'				=>'#12b1c6',
								'featured_bg'				=>'#e74c3c',
								'latest_bg'				=>'#79AF33',
								'bestseller_bg'				=>'#9854B3'
					)
					
				);	
			
			return $default_values;
	}
    
	public function checkWrapper($view,$position){	
		$return = $view;
		$wide_position = array(
			'pre_header',
			'after_header',
			'extra_top',
			'extra_bottom',
			'pre_footer'	
		);
		 if(in_array($position,$wide_position)){
			$return = '<div class="container">'.$view.'</div>'; 
		 }
		return $return;	
	}
	public function sidePosition(){	
		$side_position = array(
			'column_left',
			'column_right',
			'top_left',
			'top_right',
			'bottom_left',
			'bottom_right'	
		);
		return $side_position;	
	}	
	public function validate(){
		$fc = $this->fc;
		$data=array(
			'task'		=>$fc[2],
			'handle'	=>''
		);	
		return $this->$fc[0]->$fc[1]($data);
	}
	public function rStatus(){
		$fc = $this->fc;
		$data=array(
			'task'		=>$fc[3],
			'handle'	=>''
		);	
		return $this->$fc[0]->$fc[1]($data);
	}
	public function writeOutput($file,$output) {
		$this->helper->writeOutput($file,$output);
	}
	public function createOutput($param){
		$fc = $this->fc;
		$return='';
		$key ='';
		if(isset($param['key'])){			
			$key = $param['key'];
		}
		$data=array(
			'task'		=>$fc[5],
			'handle'	=>$param,
		);	
		$return = $this->$fc[0]->$fc[1]($data);
		
		if(!empty($key)&&!empty($return)){
			$this->data[$key] = $return; 	
		}
		return $return;
	}
/********************************************************/
/*      			. handleMinify					 	 */
/********************************************************/	
	public function handleMinify($output) {
		if (isset($this->request->server['HTTPS'])) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}
		if(is_array($output)){
			return $output;
		}else{
			$fc = $this->fc;
			$return = $output;
			$query_data = isset($this->db->query_data)?$this->db->query_data:false;
			$minify_checker = strripos($output,'data-minify-checker');
			if (($minify_checker !== false)&&$this->getConfig('ave_installed')==1) {
					$config = array(
								'minify_checker'	=> $minify_checker,	
								'image_url'	=>	$store_url.'image/',	
								'skin_sub_domain'	=> $this->getConfig('skin_sub_domain'),	
								'skin_internal_link'	=> $this->getConfig('skin_internal_link'),	
								'skin_compression_html'	=> $this->getConfig('skin_compression_html'),	
								'skin_remove_comment'	=> $this->getConfig('skin_remove_comment'),	
								'skin_put_js_bottom'	=> $this->getConfig('skin_put_js_bottom'),	
								'skin_css_delivery'		=> 0,	
								'skin_minify_code'		=> $this->getConfig('skin_minify_code'),
								'skin_query_details'	=> $this->getConfig('skin_query_details'),
								'ave_installed'		=> $this->getConfig('ave_installed'),
								'image_manager_status'	=> $this->getConfig('image_manager_status')
								);
					$data=array(		
						'task'	=>'minify',
						'handle'	=> array(
											'output'=>$output,
											'query_data'=> $query_data,	
											'config'=> $config
										)
					);
					$return = $this->$fc[0]->$fc[1]($data);
			}
			return $return;
		}
	}
/********************************************************/
/*      			. minScript					 	   */
/********************************************************/	
	public function minScript($script) {
		$fc = $this->fc;
		$data=array(
			'task'		=>$fc[6],
			'handle'	=>$script,
		);	
		return $this->$fc[0]->$fc[1]($data);
	}	
	
/********************************************************/
/*      			. stripUnicode				 	   */
/********************************************************/		
	public function stripUnicode($str){	
		if(!$str) return false;//
		$unicode = array(	
		 'a'=>'ą|æ|å|ä|á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
		 'A'=>'Ą|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		 'n'=>'ñ',
		 'N'=>'Ñ',
		 'Y'=>'¥',
		 'd'=>'đ',
		 'D'=>'Đ',
		 'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		 'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		 'i'=>'í|ì|ỉ|ĩ|ị',	  
		 'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		 'o'=>'ø|ö|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		 'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		 'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		 'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		 'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		 'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		 ''=>'~|!|@|#|$|%|^|&|*|(|)|(|+|?|"|\'|:|;|?|>|<|,|.',
		 '-'=>' |_-|-_|/|--|---|----',
		);
		foreach($unicode as $nonsign=>$sign) {
		  $array = explode("|",$sign);
		  $str = str_replace($array,$nonsign,$str);
		}	
		$str = strtolower($str);
		$patterns = $replacements = array();
		$patterns[0] = '/(&amp;|&)/i';
		$replacements[0] = '-and-';
		$patterns[1] = '/[^a-zA-Z01-9]/i';
		$replacements[1] = '-';
		$patterns[2] = '/(-+)/i';
		$replacements[2] = '-';
		$patterns[3] = '/(-$|^-)/i';
		$replacements[3] = '';
		$str = preg_replace($patterns, $replacements, $str);
		return $str;
	}
/********************************************************/
/*      			. minScripts				 	   */
/********************************************************/		
	public function minScripts($scripts) {
		$fc = $this->fc; 
		$data=array(
			'task'	=>$fc[7],
			'handle'	=>$scripts,
		);	
		return $this->$fc[0]->$fc[1]($data);
	}	
/********************************************************/
/*      			. minStyle				 	   */
/********************************************************/
	public function minStyle($style) {
		$fc = $this->fc;
		$data=array(
			'task'		=>$fc[8],
			'handle'	=>$style,
		);	
		return $this->$fc[0]->$fc[1]($data);
	}
/********************************************************/
/*      			. minStyles				 	   		*/
/********************************************************/		
	public function minStyles($styles) {
		$fc = $this->fc; 
		$data=array(
			'task'	=>$fc[9],
			'handle'	=>$styles,
		);	
		return $this->$fc[0]->$fc[1]($data);
	}	
/********************************************************/
/*      			.parseJson					 	   	*/
/********************************************************/
	public function parseJson($param,$type){	
		$fc = $this->fc; 
		$data=array(
			'task'	=>$fc[10],
			'handle'	=>array('output'=>$param,'type'=>$type)
		);	
		return $this->$fc[0]->$fc[1]($data);
	}
	public function getTranslateText(){
		$texts =array(
					'text_all'					=>'All',
					'text_extras'					=>'Extras',
					'text_shopping_cart'				=>'Shopping cart',
					'search_here'				=>'Search here...',
					'featured_label'			=>'Hot',
					'special_label'				=>'Off',
					'bestseller_label'			=>'Best',
					'latest_label'				=>'New',
					'text_my_account'			=>'My Account',
					'text_register_account'		=>'Register Account',
					'text_manager_account'		=>'Manager Account',
					'text_welcome'				=>'Welcome',
					'text_logout'				=>'Logout',
					'text_login'				=>'Login',
					'text_whist_list'			=>'Wish List',
					'text_price'				=>'Price',
					'btn_quickview'				=>'Quickview',
					'btn_details'				=>'Details',
					'back_to_top'				=>'Back to Top',
					'text_subscribe'			=>'Subscribe',
					'text_unsubscribe'			=>'Unsubscribe',
					'text_catalog'				=>'Catalog',
					'text_pages'				=>'Pages',
					'text_content'				=>'Content',
					'checkout_account'			=>'Account Option',
					'checkout_billing'			=>'Billing address',
					'checkout_delivery_address'	=>'Delivery address',
					'checkout_delivery_method'	=>'Delivery method',
					'checkout_payment'			=>'Payment method',
					'checkout_confirm'			=>'Confirm Order',
					'text_back'			=>'Back'
				);	
			
			return $texts;
	}
	public function text($key){	
		$return = $key;
		$lang_code = $this->data['LanguageCode'];
		if($key=='btn_quickview'&&$this->data['btn_quickview']==0){
			$key = 'btn_details';
		}
		if(!empty($this->data_text[$key][$lang_code])){
			$return = $this->data_text[$key][$lang_code];
		}else if(!empty($this->data_text[$key])){
			$return = $this->data_text[$key];
		}else if(!empty($skin_text[$key])){
			$return = $this->data_text[$key];
		}
			return $return;
		
	}
	public function get($keys){
		$return = false;
		if (!is_array($keys)) {
				$key = $keys;
    			$return =(isset($this->data[$key]) ? $this->data[$key] : false);				
		}else if(is_array($keys)){			
			$value='';
			foreach ($keys as $key) {
				if(isset($this->data[$key])){
					$value .= $this->data[$key].' ';
				}
			}
			$return = $value;
		} 
		return $return;
	}	
	public function layout($key){
		$layout_id=$this->getLayoutID();	
		$lang_code = $this->data['LanguageCode'];
			$layout['dir']= '';
			$layout['direction']= 'ltr';
		/*Add Dynamic Key*/ 
		if(!empty($this->data['skin_lang_dir'])&&isset($this->data['skin_lang_dir'][$lang_code])){
			if($this->data['skin_lang_dir'][$lang_code]=='rtl'){
			$layout['dir']= '-rtl';
			$layout['direction']= 'rtl';
			}
		}
		/**/ 
		$layout['pre_header'] 	= $this->data['mobile']['pre_header'];	
		$layout['after_header'] = $this->data['mobile']['after_header'];	
		$layout['extra_top'] 	= $this->data['mobile']['extra_top'];	
		$layout['extra_bottom'] = $this->data['mobile']['extra_bottom'];	
		$layout['pre_footer'] 	= $this->data['mobile']['pre_footer'];	
		
		/*Top Left Right */ 	
		if(!empty($this->data['different_desktop_top_left'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$calc_top_left= $this->data['different_desktop_top_left'][$layout_id];
		}else{
			$calc_top_left=$this->data['top_left'];
		}		
		if(!empty($this->data['different_tablet_top_left'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$calc_layout_tablet_top_left= $this->data['different_tablet_top_left'][$layout_id];
		}else{
			$calc_layout_tablet_top_left=$this->data['layout_tablet_top_left'];
		}				
		if(!empty($this->data['different_desktop_top_right'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$calc_top_right= $this->data['different_desktop_top_right'][$layout_id];
		}else{
			$calc_top_right=$this->data['top_right'];
		}		
		if(!empty($this->data['different_tablet_top_right'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$calc_layout_tablet_top_right= $this->data['different_tablet_top_right'][$layout_id];
		}else{
			$calc_layout_tablet_top_right=$this->data['layout_tablet_top_right'];
		}	
		
		$top_left			=	$calc_top_left;
		$layout_tablet_top_left	=	$calc_layout_tablet_top_left;
		$top_right			=	$calc_top_right;
		$layout_tablet_top_right	=	$calc_layout_tablet_top_right;
		
		if($this->getTotalModule('top_left')==0){
			$top_right			=	$calc_top_left+$calc_top_right;
			$layout_tablet_top_right	=	$calc_layout_tablet_top_left+$calc_layout_tablet_top_right;
			$layout_tablet_top_right	=	($layout_tablet_top_right<=12)?$layout_tablet_top_right:12;
			$top_left			=	0;
			$layout_tablet_top_left	=	0;			
		}
		if($this->getTotalModule('top_right')==0){
			$top_left			=	$calc_top_left+$calc_top_right;
			$layout_tablet_top_left	=	$calc_layout_tablet_top_left+$calc_layout_tablet_top_right;
			$layout_tablet_top_left	=	($layout_tablet_top_left<=12)?$layout_tablet_top_left:12;
			$top_right			=	0;
			$layout_tablet_top_right	=	0;			
		}
		
		$top_left_prefix=($top_left<12)?'column-left ':'';
		
		$layout['top_left'] = $top_left_prefix.'column-fix col-md-'.$top_left.' col-sm-'.$layout_tablet_top_left.' '.$this->data['mobile']['top'];   
		
		$top_right_prefix=($top_right<12)?'column-right ':'';
		$layout['top_right'] = $top_right_prefix.'column-fix col-md-'.$top_right.' col-sm-'.$layout_tablet_top_right.' '.$this->data['mobile']['top'];   
		
		
		/*Calculator Extra Bottom */ 	
		if(!empty($this->data['different_desktop_bottom_left'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$calc_bottom_left= $this->data['different_desktop_bottom_left'][$layout_id];
		}else{
			$calc_bottom_left=$this->data['bottom_left'];
		}	
		if(!empty($this->data['different_tablet_bottom_left'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$calc_layout_tablet_bottom_left= $this->data['different_tablet_bottom_left'][$layout_id];
		}else{
			$calc_layout_tablet_bottom_left=$this->data['layout_tablet_bottom_left'];
		}				
		if(!empty($this->data['different_desktop_bottom_right'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$calc_bottom_right= $this->data['different_desktop_bottom_right'][$layout_id];
		}else{
			$calc_bottom_right=$this->data['bottom_right'];
		}	
		if(!empty($this->data['different_tablet_bottom_right'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$calc_layout_tablet_bottom_right= $this->data['different_tablet_bottom_right'][$layout_id];
		}else{
			$calc_layout_tablet_bottom_right=$this->data['layout_tablet_bottom_right'];
		}	
		$bottom_left			=	$calc_bottom_left;
		$layout_tablet_bottom_left		=	$calc_layout_tablet_bottom_left;
		$bottom_right			=	$calc_bottom_right;
		$layout_tablet_bottom_right	=	$calc_layout_tablet_bottom_right;
		if($this->getTotalModule('bottom_left')==0){
			$bottom_right			=	$calc_bottom_left+$calc_bottom_right;
			$layout_tablet_bottom_right	=	$calc_layout_tablet_bottom_left+$calc_layout_tablet_bottom_right;
			$layout_tablet_bottom_right	=	($layout_tablet_bottom_right<=12)?$layout_tablet_bottom_right:12;
			$bottom_left			=	0;
			$layout_tablet_bottom_left	=	0;			
		}
		if($this->getTotalModule('bottom_right')==0){
			$bottom_left			=	$calc_bottom_left+$calc_bottom_right;
			$layout_tablet_bottom_left	=	$calc_layout_tablet_bottom_left+$calc_layout_tablet_bottom_right;
			$layout_tablet_bottom_left	=	($layout_tablet_bottom_left<=12)?$layout_tablet_bottom_left:12;
			$bottom_right			=	0;
			$layout_tablet_bottom_right	=	0;		
		}
		
		$bottom_left_prefix=($bottom_left<12)?'column-left ':'';
		$layout['bottom_left'] = $bottom_left_prefix.'column-fix col-md-'.$bottom_left.' col-sm-'.$layout_tablet_bottom_left.' '.$this->data['mobile']['bottom'];   
		
		$bottom_right_prefix=($bottom_right<12)?'column-right ':'';
		$layout['bottom_right'] = $bottom_right_prefix.'column-fix col-md-'.$bottom_right.' col-sm-'.$layout_tablet_bottom_right.' '.$this->data['mobile']['bottom'];		
		
		/*Add Dynamic Key*/ 	
		if(!empty($this->data['desktop'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$layout['desktop_layout']= $this->data['desktop'][$layout_id];
		}else{
			$layout['desktop_layout']='';
		}		
		
		/*Add Dynamic Key*/ 	
		if(!empty($this->data['layout_desktop_left'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$desktop_left= $this->data['layout_desktop_left'][$layout_id];
		}else{
			$desktop_left=$this->data['desktop_left'];
		}			
		if(!empty($this->data['layout_desktop_right'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$desktop_right= $this->data['layout_desktop_right'][$layout_id];
		}else{
			$desktop_right=$this->data['desktop_right'];
		}					
		if(!empty($this->data['layout_desktop_content'][$layout_id])&&$this->data['desktop'][$layout_id]!='default'){
			$desktop_content= $this->data['layout_desktop_content'][$layout_id];
		}else{
			$desktop_content=$this->data['desktop_content'];
		}		
		/*Add Dynamic Key*/ 
		if(!empty($this->data['tablet'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$tablet_layout= $this->data['tablet'][$layout_id];
		}else{
			$tablet_layout=$this->data['default_tablet_layout'];
		}
		/*Add Dynamic Key*/ 
		if(!empty($this->data['layout_tablet_rest'][$layout_id])&&$this->data['tablet'][$layout_id]!='default'){
			$tablet_rest_size=$this->data['layout_tablet_rest'][$layout_id];
		}else{			
			$tablet_rest_size=$this->data['tablet_rest'];
		}
		$tablet_rest=($tablet_rest_size==0)?'12':$tablet_rest_size;
		$tablet_left=($tablet_layout=='left')?$tablet_rest:'0';	
		$tablet_right=($tablet_layout=='right')?$tablet_rest:'0';
			    	
		$content_col=1;   	
		$dcols=0;
		$tcols=0;
		if($this->getTotalModule('column_left')>0){
			$dcols=$dcols+$desktop_left;
			$tcols=$tcols+$tablet_left;
			$content_col=$content_col+1;   	
		}	
		if($this->getTotalModule('column_right')>0){
			$dcols=$dcols+$desktop_right;
			$tcols=$tcols+$tablet_right;
			$content_col=$content_col+1;   	
		}
		$desktop_content_col=12-$dcols;
		$tablet_content_col=($tcols==12)?12:12-$tcols;
		/*Add Dynamic Key*/ 
		$left_prefix=($desktop_left<=4)?'column-small ':'';
		$right_prefix=($desktop_right<=4)?'column-small ':'';
		$content_prefix=($desktop_content_col<=4)?'column-small ':'';
		
		$layout['column_left'] = $left_prefix.' column-fix col-md-'.$desktop_left.' col-sm-'.$tablet_left.' col-xs-12 '.$this->data['mobile']['column_left'];   
		$layout['column_right'] = $right_prefix.' column-fix col-md-'.$desktop_right.' col-sm-'.$tablet_right.' col-xs-12 '.$this->data['mobile']['column_right'];
		$layout['content'] = $content_prefix.' column-fix col-md-'.$desktop_content_col.' col-sm-'.$tablet_content_col.' col-xs-12 ';
		/*Add Dynamic Key*/ 
		$body_class = array();
		$body_class[] ='bar_left ';		
		if(!$this->data['config_maintenance']&&$this->data['ave_installed']&&$this->data['config_template']==$this->theme()){	
			$body_class[] = $this->data['ajax_search'];
		}	
		
		$body_class[] = 'layout-'.$this->stripUnicode($this->getRoute());
		if($this->data['btn_quickview']==1){
			$body_class[] = 'with-quickview';
		}
		
		$body_class[] = $this->data['preloader'];
		$body_class[] = $this->data['animated'];
		$body_class[] = $this->data['body_style'];
		$body_class[] = $this->data['color_mode'];
		$body_class[] = $this->data['footer_style'];
		$body_class[] = $this->data['header_top_status'];
		$body_class[] = $this->data['header_top_color'];
		$body_class[] = $this->data['nav_transparent'];
		$body_class[] = $this->data['navigation_mode'];
		$body_class[] = $this->data['navigation_sub'];
		$body_class[] = 'layout-'.$layout['desktop_layout'];
		$body_class[] = 'content-'.$content_col.'-column';		
		$body_class[] = $this->data['header_fixed'];
		$body_class[] = $this->data['header_style'];
		$body_class[] = 'direction-'.$layout['direction'];
		$body_class[] = $this->data['name_display_type'];
		$body_class[] = $this->data['nav_btn_mode'];
				
		$layout['body'] = implode (' ',$body_class);	
		if(!empty($layout[$key])){
			return $layout[$key];
		}else{
			return FALSE;
		}
	}
	/*All module*/ 
	
	public function getRoute() {
		if (isset($this->request->get['route'])) {
			$getRoute = (string)$this->request->get['route'];
		} else {
			$getRoute = 'common/home';
		}
		return $getRoute;
	}
	public static $all_modules = array();	
	public function getAllModules() {
		if (!empty(self::$all_modules)) {
			return self::$all_modules;
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module");
		return self::$all_modules = $query->rows;
	}
	public function getModule($module_id) {
		$all_modules = $this->getAllModules();
		$return = false;
		foreach ($all_modules as $module) {
			if ($module_id == $module['module_id']) {
				$module_info[$module_id] = $this->decodeSetting($module['setting']);
				$return = $module_info[$module_id];
			}
		}
		return $return;
	}
	
	/*All layout module*/ 
	public static $all_layout_modules = array();
	
	public function getAllLayoutModules() {
		if (!empty(self::$all_layout_modules)) {
			return self::$all_layout_modules;
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module ORDER BY sort_order ASC");
		if ($query->num_rows) {
			return self::$all_layout_modules = $query->rows;
		}
	}
	public function getLayoutModulesByPosition($layout_id,$position) {
		$all_layout_modules = $this->getAllLayoutModules();
		$layout_modules = array();
		if(!empty($all_layout_modules)){
			foreach ($all_layout_modules as $layout_module) {
				if ($layout_id == $layout_module['layout_id']&&$position==$layout_module['position']) {
					$layout_modules[] = $layout_module;
				}
			}
		}
		return $layout_modules;
	}
	
	public function getTotalModule($position){
		$layout_id=$this->getLayoutID();
    	$module_total = 0;
		$modules = $this->getLayoutModulesByPosition($layout_id,$position);
		foreach ($modules as $module) {
			$part = explode('.', $module['code']);
			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
				$module_total++;
			}
						
			if (isset($part[1])) {
				$setting_info = $this->getModule((int)$part[1]);	
				if (!empty($setting_info) && $setting_info['status']) {
					$module_total++;
				}
			}
		}
		return $module_total;
	}
/********************************************************/
/*      			. Create Image					    */
/********************************************************/	

	public function image($filename, $width, $height,$type = "") {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		$info = pathinfo($filename);
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directory = dirname(str_replace('../', '', $new_image));													
			if (!is_dir(DIR_IMAGE.$directory)){
				@mkdir(DIR_IMAGE.$directory,  0777, true);
			}
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height, $type);
				$image->save(DIR_IMAGE.$new_image);	
			} else {
				copy(DIR_IMAGE.$old_image, DIR_IMAGE.$new_image);	
			}
		}
		return $this->store_url . 'image/' . $new_image;
	}
/********************************************************/
/*      			. Color Convert					    */
/********************************************************/
	public function HexToRGB($hex) {
		$hex = str_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
 
		return implode(', ', $rgb);
	} 
	public function RGBToHex($r, $g, $b) {
		$hex = "#";
		$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT); 
		return $hex;
	}
	public function getLayoutID() {
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}
		$layout_id = 0;
		
		if ($route == 'content/category' && isset($this->request->get['content_id'])) {
			$path = explode('_', (string)$this->request->get['content_id']);
				
			$layout_id = $this->getContentLayoutId(end($path));			
		}		
		if ($route == 'content/article' && isset($this->request->get['article_id'])) {
			$layout_id = $this->getArticleLayoutId($this->request->get['article_id']);
		}
		
		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$path = explode('_', (string)$this->request->get['path']);
				
			$layout_id = $this->getCategoryLayoutId(end($path));			
		}
		
		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$layout_id = $this->getProductLayoutId($this->request->get['product_id']);
		}
		
		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$layout_id = $this->getInformationLayoutId($this->request->get['information_id']);
		}		
		if (!$layout_id) {
			$layout_id = $this->getLayoutIDByRoute($route);
		}
		return $layout_id;
		
  	}
	/*LayoutID*/
	private static $all_layout = array();
	public function getLayoutIDByRoute($route) {
		$route_str = str_replace('/','_',$route);
		$layout_id=0;
		if (!empty(self::$all_layout)) {	
			if(isset(self::$all_layout[$route_str])){
				$layout_id = self::$all_layout[$route_str];
			}
		}else{
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE CONCAT(route, '%') AND store_id = '" . (int)$this->data['config_store_id'] . "' ORDER BY route DESC LIMIT 1");	
			if ($query->num_rows) {
				$layout_id=$query->row['layout_id'];
			}
			self::$all_layout[$route_str]=$layout_id;
		}	
		return $layout_id;
	}
	/*getContentLayoutId*/
	private static $article_layout_id = NULL;	
	private function getStaticArticleLayoutID($article_id,$route_layout_id) {
		if (self::$article_layout_id!=NULL) {
			return self::$article_layout_id;
		}
		$layout_id = $route_layout_id;
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_layout WHERE article_id = '" . (int)$article_id . "' AND store_id = '" .(int)$this->data['config_store_id']. "'");
		if ($query->num_rows) {
			$layout_id = $query->row['layout_id'];
		} 
		return self::$article_layout_id = $layout_id;
	}
	public function getArticleLayoutId($article_id) {
		$route_layout_id = $this->getLayoutIDByRoute('content/article');
		$layout_id = $this->getStaticArticleLayoutID($article_id,$route_layout_id);
		return $layout_id;
	}
	/*getContentLayoutId*/
	private static $content_layout_id = NULL;	
	private function getStaticContentLayoutID($content_id,$route_layout_id) {
		if (self::$content_layout_id!=NULL) {
			return self::$content_layout_id;
		}
		$layout_id = $route_layout_id;
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_to_layout WHERE content_id = '" . (int)$content_id . "' AND store_id = '" .(int)$this->data['config_store_id']. "'");
		if ($query->num_rows) {
			$layout_id = $query->row['layout_id'];
		} 
		return self::$content_layout_id = $layout_id;
	}
	public function getContentLayoutId($content_id) {
		$route_layout_id = $this->getLayoutIDByRoute('content/category');
		$layout_id = $this->getStaticContentLayoutID($content_id,$route_layout_id);
		return $layout_id;
	}
	/*getCategoryLayoutId*/ 
	private static $category_layout_id = NULL;	
	private function getStaticCategoryLayoutID($category_id,$route_layout_id) {
		if (self::$category_layout_id!=NULL) {
			return self::$category_layout_id;
		}
		$layout_id = $route_layout_id;
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" .(int)$this->data['config_store_id']. "'");
		if ($query->num_rows) {
			$layout_id = $query->row['layout_id'];
		} 
		return self::$category_layout_id = $layout_id;
	}
	public function getCategoryLayoutId($category_id) {
		$route_layout_id = $this->getLayoutIDByRoute('product/category');
		$layout_id = $this->getStaticCategoryLayoutID($category_id,$route_layout_id);
		return $layout_id;
	}
	/*getProductLayoutId*/ 
	private static $product_layout_id = NULL;	
	private function getStaticProductLayoutID($product_id,$route_layout_id) {
		if (self::$product_layout_id!=NULL) {
			return self::$product_layout_id;
		}
		$layout_id = $route_layout_id;
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" .(int)$this->data['config_store_id']. "'");
		if ($query->num_rows) {
			$layout_id = $query->row['layout_id'];
		} 
		return self::$product_layout_id = $layout_id;
	}
	public function getProductLayoutId($product_id) {
		$route_layout_id = $this->getLayoutIDByRoute('product/product');
		$layout_id = $this->getStaticProductLayoutID($product_id,$route_layout_id);
		return $layout_id;
	}
	private static $information_layout_id = NULL;	
	private function getStaticInformationLayoutID($information_id,$route_layout_id) {
		if (self::$information_layout_id!=NULL) {
			return self::$information_layout_id;
		}
		$layout_id = $route_layout_id;
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" .(int)$this->data['config_store_id']. "'");
		if ($query->num_rows) {
			$layout_id = $query->row['layout_id'];
		} 
		return self::$information_layout_id = $layout_id;
	}
	public function getInformationLayoutId($information_id) {
		$route_layout_id = $this->getLayoutIDByRoute('information/information');
		$layout_id = $this->getStaticInformationLayoutID($information_id,$route_layout_id);
		return $layout_id;
	}
/********************************************************/
/*      . Fonts						             		*/
/********************************************************/
	public function getRegularFonts(){
		 /*Regular fonts array*/
	 $fonts = array('Open Sans', 'Open Sans Light', 'Open Sans Semibold', 'Open Sans Extrabold','Open Sans','Arial', 'Verdana', 'Helvetica', 'Lucida Grande', 'Trebuchet MS', 'Times New Roman', 'Tahoma', 'Georgia');
			return $fonts;	
	}
	private $oc = array('helper','init','val','stt','minify','createOutput','minScript','minScripts','minStyle','minStyles','parse','_lic','_key','theme','getConfig','tm','cp','ref');
	private function ref(){			
		$h = HTTP_SERVER;
		$return = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,'skin',$h,'.','_','array','request','server','HTTP','HOST','parse_url','str_replace','md5','sha1','strtoupper','substr','strpos','md5x','val','implode','str_split','serialize','name','host','www','-','local','task','data','handle','config','get',127,'json_encode','json_decode','base64_encode','base64_decode');
		return $return;
	}
	public function encodeSetting($setting) {	
		$oc_ver =  substr((string)str_replace('.','',VERSION),0,3);
		if($oc_ver<210){
			return serialize($setting); 
		}else{
			return json_encode($setting, true);
			
		}
	}
	public function decodeSetting($setting) {	
		$oc_ver =  substr((string)str_replace('.','',VERSION),0,3);
		if($oc_ver<210){
			return unserialize($setting);
		}else{
			return json_decode($setting, true);
		}
	}
	public function getGoogleFonts(){
		 /*Google fonts array*/
		 $fonts = array(				
		 	'ABeeZee','Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Asap','Asset','Astloch','Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Federant','Federo','Felipa','Fenix','Finger Paint','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Habibi','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny','Herr Von Muellerhoff','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata','Inder','Indie Flower','Inika','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow','Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kameron','Karla','Kaushan Script','Kavoon','Keania One','Kelly Slab','Kenia','Khmer','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','La Belle Aurore','Lancelot','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Libre Baskerville','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miss Fajardose','Modern Antiqua','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Patua One','Paytone One','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Port Lligat Sans','Port Lligat Slab','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono','Prosto One','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Raleway','Raleway Dots','Rambla','Rammetto One','Ranchers','Rancho','Rationale','Redressed','Reenie Beanie','Revalia','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sail','Salsa','Sanchez','Sancreek','Sansita One','Sarina','Satisfy','Scada','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Special Elite','Spicy Rice','Spinnaker','Spirax','Squada One','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Sunshiney','Supermercado One','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Telex','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Yanone Kaffeesatz','Yellowtail','Yeseva One','Yesteryear','Zeyada');
	return $fonts;
	}	
	public function getAnimations(){
		 $animations = array('fadeIn'=>'FadeIn', 'fadeInUp'=>'FadeInUp', 'fadeInDown'=>'FadeInDown', 'fadeInLeft'=>'FadeInLeft', 'fadeInRight'=>'FadeInRight', 'fadeInUpBig'=>'FadeInUpBig', 'fadeInDownBig'=>'FadeInDownBig', 'fadeInLeftBig'=>'FadeInLeftBig', 'fadeInRightBig'=>'FadeInRightBig', 'bounceIn'=>'BounceIn', 'bounceInUp'=>'BounceInUp', 'bounceInDown'=>'BounceInDown', 'bounceInLeft'=>'bounceInLeft', 'bounceInRight'=>'bounceInRight', 'rotateIn'=>'RotateIn', 'rotateInUpLeft'=>'RotateInUpLeft', 'rotateInDownLeft'=>'RotateInDownLeft', 'rotateInUpRight'=>'RotateInUpRight', 'rotateInDownRight'=>'RotateInDownRight', 'flash'=>'Flash', 'shake'=>'Shake', 'bounce'=>'Bounce', 'tada'=>'Tada', 'swing'=>'Swing', 'wobble'=>'Wobble');
			return $animations;	
	}
	public function getColors(){
		 $colors = array('blue'=>'Blue','blue-sky'=>'Blue Sky','blue-hoki'=>'Blue Hoki','blue-steel'=>'Blue Steel','blue-madison'=>'Blue Madison','blue-chambray'=>'Blue Chambray','blue-ebonyclay'=>'Blue Ebonyclay','turquoise'=>'Blue Turquoise','green'=>'Green','green-meadow'=>'Green Meadow','green-seagreen'=>'Green Seagreen','green-turquoise'=>'Green Turquoise','green-haze'=>'Green Haze','green-jungle'=>'Green Jungle','aqua'=>'Green Aquamarine','red'=>'Red','crimson'=>'Red Crimson','red-pink'=>'Red Pink','red-sunglo'=>'Red Sunglo','red-intense'=>'Red Intense','red-thunderbird'=>'Red Thunderbird','red-flamingo'=>'Red Flamingo ','yellow'=>'Yellow','yellow-gold'=>'Yellow Gold','yellow-casablanca'=>'Yellow Casablanca','yellow-crusta'=>'Yellow Crusta','yellow-lemon'=>'Yellow Lemon','yellow-saffron'=>'Yellow Saffron','purple'=>'Purple','purple-plum'=>'Purple Plum','purple-medium'=>'Purple Medium','purple-studio'=>'Purple Studio','purple-wisteria'=>'Purple Wisteria','purple-seance'=>'Purple Seance','grey'=>'Grey','grey-cascade'=>'Grey Cascade','grey-silver'=>'Grey Silver','grey-steel'=>'Grey Steel','grey-cararra'=>'Grey Cararra','grey-dark'=>'Dark Grey','cyan'=>'Cyan','violetred'=>'Violetred','default'=>'- default -');
			return $colors;	
	}
}
?>