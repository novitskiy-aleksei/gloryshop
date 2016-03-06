<?php 
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avetheme.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class Ave_helper {
	private $store_url = HTTP_SERVER;
  	public function __construct($store_url,$ref,$collate) {
		define('DIR_STORE', str_replace('system/','',DIR_SYSTEM));
		$this->rf = $ref;
		$this->collate = $collate;
		$this->store_url = $store_url;
		include_once('JSMin.php');
	}	
	private function minify($data){
		$output = $data['output'];
		$rf = $this->rf;		
		if($this->stt()!=$rf[0]){
		$config	= $data['config'];
		$key = md5(json_encode(array($config,$output)));
		$file= DIR_STORE . 'assets/cache/html/'.$key.'.html.gz';
		
		$query_key = substr(md5(json_encode($data['query_data'])),0,12);
		$query_file= DIR_STORE . 'assets/cache/query/'.$query_key.'.html';
		$detail = '';
		
		//Handle Performance	
						$query_detail = '';
		if (!file_exists($query_file)&&defined('ave_start_time')&&is_array($data['query_data'])) {
						$endtime = microtime();
						$endtime = explode(' ', $endtime);
						$endtime = $endtime['1'] + $endtime['0'];
						
						$highlight = array('SELECT','LEFT JOIN', 'INNER JOIN ',' LCASE', 'DISTINCT', 'NOW','FROM', 'WHERE', 'AND',' SET ',
											'ORDER BY', 'GROUP BY', 'LIMIT', 'INSERT',' INTO', ' VALUES', 'UPDATE', ' OR ', 'HAVING', 'OFFSET', 'NOT IN',
											' IN ', ' LIKE', 'NOT LIKE', 'COUNT', ' MAX', ' MIN', ' ON ',' AS ','ASC', 'CONCAT', 'DESC', 'AVG', 'SUM', '(', ')');
						
						$db_time = 0;
						foreach ($data['query_data'] as $query){
							$db_time += $query['time'];
						}
						$performance = array(
							'memory'		=>number_format(memory_get_usage()),
							'loadingtime'	=>number_format($endtime - ave_start_time, 4),
							'queries'		=>count($data['query_data']),
							'db_time'		=>number_format($db_time, 4)
						);
						 unset($endtime);
				 
	$query_detail .= '<div class="mpadding"><div><ul class="list-group">';
	 $query_detail .= '<li class="list-group-item"><label class="control-label">Page:</label>  <span class="pull-right">'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'</span></li>';
	 $query_detail .= '<li class="list-group-item"><label class="control-label">Loading Time:</label>  <span class="pull-right">'.$performance['loadingtime'].' s</span></li>';
	 $query_detail .= '<li class="list-group-item"><label class="control-label">Memory Usage:</label>  <span class="pull-right">'.$performance['memory'].' bytes</span></li>';
	 $query_detail .= '<li class="list-group-item"><label class="control-label">Total Queries:</label>  <span class="pull-right">'.$performance['queries'].'</span></li>';
	 $query_detail .= '<li class="list-group-item"><label class="control-label">Query Time:</label>  <span class="pull-right">'.$performance['db_time'].' s</span></li>';
	 $query_detail .= '</ul></div>';
						 if($config['skin_query_details']=='1'){
							$query_detail .= '<div class="dtable"><ul class="table-row">';
							 $query_detail .= '<li class="table-cell w10p">Num:&nbsp;'.$performance['queries'].'</li>';
							 $query_detail .= '<li class="table-cell w15p">Time:&nbsp;'.$performance['db_time'].' s</li>';
							 $query_detail .= '<li class="table-cell w75p">Queries:</li>';
							$query_detail .= '</ul> ';
										$qtime = array();
										foreach ($data['query_data'] as $key => $row)
										{
											$qtime[$key] = $row['time'];
										}
										array_multisort($qtime, SORT_DESC, $data['query_data']);
											$i=1;
											foreach ($data['query_data'] as $query){
												foreach ($highlight as $bold){
													$query['query'] = str_replace($bold, '<b>'.$bold.'</b>', $query['query']);
												}
												$query_detail .= '<ul class="table-row">';
												$query_detail .= '<li class="table-cell w10p text-center">'.$i.'</li>';
												$query_detail .= '<li class="table-cell w15p">'.$query['time'].'</li>';
												$db_prefix = DB_PREFIX;
												if(!empty($db_prefix)){
													$query_detail .= '<li class="table-cell w75p"><p class="code">'.str_replace($db_prefix,'***',$query['query']).';</p></li>';
												}else{
													$query_detail .= '<li class="table-cell w75p"><p class="code">'.$query['query'].';</p></li>';												
												}
												$query_detail .= '</ul>';
											$i++;
											}
									$query_detail .= '</div>';
						 }//skin_query_details enabled
									
						$this->writeOutput($query_file,base64_encode($query_detail));
						$query_detail = NULL;
						$query_files = glob(DIR_STORE . 'assets/cache/query/*');
						foreach($query_files as $qfile){
							if (is_file($qfile)) {
								if (filemtime($qfile) < time() - 1200&&file_exists($qfile)) {
									@unlink($qfile);
								}
							}
						}
		}
		//End Handle Performance
	
		$in_minify = false;
		$skin_compression = ($config['skin_compression_html'])?'skin_compression_html':'skin_remove_comment';
		$compare		= array($skin_compression,'skin_css_delivery','skin_put_js_bottom','skin_minify_code','skin_internal_link');
		foreach ($config as $k=>$v){if(in_array($k,$compare)&&$v==1){$in_minify = true;}}
		if ($in_minify==true && $this->val()==true) {
			if (file_exists($file)){
				$output = file_get_contents($file);
			}else{//file not exist
					preg_match_all('/<link(.*)href="(.*?)"(.*)>/',$output,$first_link,1);
					$output = preg_replace("/<link(.*)href=\"(.*?)\"(.*)>/",'here_is_first_link', $output, 1);
					
					preg_match_all('!(<pre.*?>.*?</pre>)!is',$output,$pre);		
					$output = preg_replace('!(<pre.*?>.*?</pre>)!is', 'here_is_inline_pre', $output);	
									
					preg_match_all('!(<textarea.*?>.*?</textarea>)!is',$output,$textarea);			
						
					$output = preg_replace('!(<textarea.*?>.*?</textarea>)!is', 'here_is_inline_textarea', $output);
					
					preg_match_all('!(<\!--\[if.*?>.*?<\!\[endif]-->)!is',$output,$iefix);				
					
					$output = preg_replace('!(<\!--\[if.*?>.*?<\!\[endif]-->)!is','here_is_inline_iefix', $output);
					
						preg_match_all('!(<script.*?>.*?</script>)!is',$output,$scripts);
						$inline_js = $this->handleInlineJs($scripts,$config);					
						$output = preg_replace('!(<script.*?>.*?</script>)!is', 'here_is_script', $output);
						
						preg_match_all('/<link(.*)href="(.*?)"(.*)>/',$output,$link);					
						$style_link = $this->handleMinifyLink($link,$config);
						$output = preg_replace("/<link(.*)href=\"(.*?)\"(.*)>/",'here_is_stylesheet', $output);				
						
						preg_match_all('!(<style.*?>.*?</style>)!is',$output,$css);		
						$style_css 	= $this->handleMinifyCss($css,$config);		
						$output = preg_replace('!(<style.*?>.*?</style>)!is', 'here_is_inline_css', $output);	
					
					$output = $this->minHtml($output,$config);
					
					if (!empty($config['skin_sub_domain'])) {
						$output = str_replace($config['image_url'],$config['skin_sub_domain'],$output);
					}
					if ($config['skin_internal_link']=='1') {
						$output = str_replace("\"".$this->store_url."\"","\"this_store_url\"",$output);
						$output = str_replace(" src=\"".$this->store_url," src=\"",$output);
						$output = str_replace(" href=\"".$this->store_url," href=\"",$output);
						$output = str_replace("\"this_store_url\"","\"".$this->store_url."\"",$output);	
					}	
					if (!empty($textarea[0])) {				
						foreach ($textarea[0] as $original) {
							$output = preg_replace('!here_is_inline_textarea!', $original, $output,1);
						}		
					} 				
					if (!empty($pre[0])) {
						foreach ($pre[0] as $original) {
							$output = preg_replace('!here_is_inline_pre!', $original, $output,1);
						}
					} 	
					if (!empty($first_link[0])) {
						foreach ($first_link[0] as $original) {
							$output = preg_replace('!here_is_first_link!', $original, $output,1);
						}
					} 
					if (!empty($iefix[0])) {
						foreach ($iefix[0] as $original) {
							$output = preg_replace('!here_is_inline_iefix!', $original, $output,1);
						}
					} 
						if (!empty($link[0])) {
							if($config['skin_css_delivery']==1){
								foreach ($link[0] as $original) {
									$output = preg_replace('!here_is_stylesheet!','', $output,1);
								}
							}else{
								foreach ($style_link as $original) {
									$output = preg_replace('!here_is_stylesheet!', $original, $output,1);
								}
							}
						} 
						if (!empty($css[0])) {				
							if($config['skin_css_delivery']==1){
								foreach ($css[0] as $original) {
									$output = preg_replace('!here_is_inline_css!', '', $output,1);
								}
							}else{
								foreach ($style_css as $original) {
									$output = preg_replace('!here_is_inline_css!', $original, $output,1);
								}
							}
						} 
						if (!empty($scripts[0])) {
							if($config['skin_put_js_bottom']==1){
								foreach ($scripts[0] as $original) {
									$output = preg_replace('!here_is_script!','', $output,1);
								}
							}else{
								foreach ($inline_js as $original) {
									$output = preg_replace('!here_is_script!',$original, $output,1);
								}				
							}
						}
						if ($config['skin_css_delivery']==1) {
							if(strripos($output,'</title>') !== false ) {
								$output = preg_replace("/name=\"viewport\"\/>/i","name=\"viewport\"/>".$style_link.$style_css, $output, 1);
							}else if(strripos($output,'</head>') !== false ) {
								$output = preg_replace("/<\/head>/i",$style_link.$style_css."</head>", $output, 1);
							}else{
								$output = $style_link.$style_css.$output;				
							}
						}
						if ($config['skin_put_js_bottom']=='1') {
							if( ($pos = strripos($output,'</body>')) !== false ) {
								$output  = substr_replace($output,$inline_js.'</body>',$pos,7);
							}else{
								$output = $output .$inline_js;
							}
						}	
						$output = str_replace("here_is_script","",$output);
						$output = str_replace("here_is_stylesheet","\\00",$output);
						$output = str_replace("here_is_inline_css","\\00",$output);
					$output = str_replace("here_is_inline_iefix","\\00",$output);
					$output = str_replace("here_is_inline_textarea","\\00",$output);
					$output = str_replace("here_is_inline_pre","\\00",$output);
					$output = str_replace("here_is_first_link","\\00",$output);
				}//end minify output	
				$output = preg_replace("/[\r\n]+/","\n",$output);		
				$output = str_replace("|&lt;","&laquo;",$output);
				$output = str_replace("&gt;|","&raquo;",$output);
				if ($config['minify_checker']==true){
					$this->writeOutput($file,$output);
				}
				$html_files = glob(DIR_STORE . 'assets/cache/html/*');
				foreach($html_files as $hfile){
					if (is_file($hfile)) {
						if (filemtime($hfile) < time() - 3600&&file_exists($hfile)) {
							@unlink($hfile);
						}
					}
				}		
			
			}
		$output  = str_replace('id="body_elem"','id="body_elem" data-q="'.$query_key.'"',$output);
	}//if valid 
		return $output;	
	}
	public function init($data=array()){		
			$return = $this->$data['task']($data['handle']);
			return $return;
	}
	private function val(){
		$st = $this->rf[0];
		$rt = $this->stt();
		if($rt!=false){
			$st = $this->rf[1];
		}
		return $st;
	}
	private function name(){
		$rf = $this->rf;
		$hv =  parse_url($rf[34]);	
		if(!empty($hv['host'])){
			$hn = $hv['host']; 
		}else{
			$hn = $_SERVER['HTTP_HOST'];
		}
		$hn = str_replace('www.', '',$hn);
		return $hn;
	}
	private function parse($param){
		$data = $param['output'];
		$type = $param['type'];
		$rf = $this->rf;		
		$return = $rf[0];		
		if($this->stt()!=$rf[0]){
			if($type=='e'){
				$output['key']	= 	$rf[44]($rf[67]($rf[65]($data)));
				$output['value']	= 	$rf[67]($rf[65]($data));
				$return=$rf[65]($output);
			}
			if($type=='i'){
				$code = $rf[66]($data,1);
				$key = $rf[44]($code['value']);
				if($key == $code['key']){
						$return= $rf[66]($rf[68]($code['value']),1);
				}
			}
		}
		return $return;
	}
	private function stt(){
		$rf = $this->rf;
		$rt = $rf[0];	
		$pr =$this->collate;
		$hn =$this->name();	
		$hs = $rf[44]($rf[45]($rf[45]($hn.$pr['tm'])));
		
		if ($rf[48]($hn,$rf[58].$rf[55])!== false||$rf[48]($hn,$rf[64].$rf[35].$rf[0].$rf[35].$rf[0].$rf[35].$rf[1]) !==false){
			$rt = $this->rf[2];
		}
		if ($rf[45]($rf[51]($rf[57],$rf[52]($rf[46]($rf[47]($rf[44]($rf[45]($hs.$rf[49])),$rf[4],$rf[16])),$rf[6]))) == $pr['cp']) {			
	  		$rt = $this->rf[1];			
		}
		return $rt;
	}
	private function handleMinifyLink($link,$config) {
		$return ='';
		$link_arrs=array();
		//handle link to stylesheet
		if (!empty($link[0])) {
			foreach ($link[0] as $value) {
				if($value){	
					if(strpos($value,'href="assets/cache/css/') == false&&strpos($value,'href="') == true&&$config['skin_minify_code']==1) {
							preg_match('/href=\"(.*?)\"/s', $value,$href);
							$filename=preg_replace('/^.+[\\\\\\/]/', '',$href[1]);
							$file_ext =substr(strrchr($filename, '.'), 1);	
							$minify = $this->minStyle(array('href'=>$href[1]));
							$minify = preg_replace('/href="(.*?)"/', 'href="'.$minify.'"', $value);							
						$link_arrs[]=$minify;
					} else if (strpos($value,'href="assets/cache/css/') !== false&&strpos($value,'href="') == true) {
							$link_arrs[]=$value;
					}else{			
						$link_arrs[]=$value;		
					}	
				} 
			}
		} 
		if($config['skin_css_delivery']==1){
			foreach ($link_arrs as $link_return) {
				$return .= $link_return.$this->isBreak($config);				
			}
			return $return;
		}else{
			return $link_arrs;			
		}
	}
	private function handleMinifyCss($css,$config) {
		$return ='';
		$css_arrs=array();
		//handle inline css	
		if (!empty($css[0])) {
			foreach ($css[0] as $value) {					
				$css_arrs[]=($config['skin_minify_code']==1)?$this->compressCss($value):$value;
			}
		} 
		if($config['skin_css_delivery']==1){
			foreach ($css_arrs as $original) {
				$return .= $original.$this->isBreak($config);					
			}	
			return $return;		
		}else{
			return $css_arrs;				
		}
	}
	private function handleInlineJs($script,$config) {	
		$return ='';	
		$script_arrs=array();
		//handle inline script	
		if (!empty($script[0])) {
			foreach ($script[0] as $value) {
				if($value){	
					 if(strpos($value,'src="assets/cache/') == true){			
						 $script_arrs[]= $value;
					} elseif(strpos($value,' src="assets/cache/js/') == false&&strpos($value,' src=') == false){					
						preg_match_all("/(<script.*>)(.*)(<\/script>)/ismU",$value,$inline_script2, PREG_SET_ORDER);
						foreach ($inline_script2 as $inline) {
							if($inline[2]&&$config['skin_minify_code']==1){	
								 $script_arrs[]=$this->minInlineJs($inline[2]);
							}else{
								 $script_arrs[]=$inline[0];
							}
						}
					}else if(strpos($value,' src="assets/cache/js/') == false&&strpos($value,' src=') == true) {
					 	preg_match('/<script(.*)src="(.*?)"(.*)>(.*)<\/script>/is',$value,$src);	
						 if(!empty($src[2])){	
							$filename=preg_replace('/^.+[\\\\\\/]/', '',$src[2]);	
							$file_ext =substr(strrchr($filename, '.'), 1);
							if($file_ext=='js'&&$config['skin_minify_code']==1){
								$minify =$this->minScript($src[2]); 
								$script_arrs[]= preg_replace('/src="(.*?)"/', 'src="'.$minify.'"', $value);
							}elseif(!empty($src[0])){
								preg_match_all('/src="(.*?)"/is',$src[0],$script_include);			
								$src[0] = preg_replace('/src="(.*?)"/is', '@protect_src_in_inline_src@', $src[0]);
								preg_match("/(<script.*)>(.*)(<\/script>)/ismU",$src[0],$inlinecontent);
								$script_return = (!empty($inlinecontent[2])&&$config['skin_minify_code']==1)?$this->minInlineJs($inlinecontent[2]):$src[0];
								if (!empty($script_include[0])) {
										foreach ($script_include[0] as $original) {
										$script_return = preg_replace('!@protect_src_in_inline_src@!', $original, $script_return,1);
										}
								}
								$script_arrs[]= $script_return;																					 
							}else{
								$script_arrs[]= $src[0]; 	
							}
						}
					}else{
						$script_arrs[]= $value;
					} 
				}
			}
		}
		if($config['skin_put_js_bottom']==1){
			foreach ($script_arrs as $original) {
				$return .= $original.$this->isBreak($config);				
			}
			return $return;		
		}else{
			return $script_arrs;		
		}
		
	}
	private function minInlineJs($output) {		
		$output = preg_replace('/(?:^\\s*<!--\\s*|\\s*(?:\\/\\/)?\\s*-->\\s*$)/', ' ',$output);//remove inline javascript comment		
		$output = '<script type="text/javascript">'.JSMin::minify($output).'</script>';//minify*/		
		return $output;
	}
	
	private function isBreak($config){
		$return ='';		
			if ($config['skin_compression_html']!='1') {	
			$return ="\n";
			}
		return $return;	
	}
	private function minHtml($output,$config) {
			if ($config['skin_remove_comment']=='1'&&$config['skin_compression_html']!='1') {	
					$output = $this->removeHtmlComment($output,$config);			
			}
			if ($config['skin_compression_html']=='1') {		
				$preg_replace = array(
				""=>"#/\*[^*]*\*+([^/][^*]*\*+)*/#",
				""=>"/<!--([^\[\]]*)-->/Uis",
				" "=>"/[\r\n]+/",
				"><"=>"/>\s+</",
				" "=>"/\s+/",	
				);			
				foreach($preg_replace as $to=>$from){
					$output = preg_replace($from,$to,$output);
				}
			}
		return $output;
	}
	private function removeHtmlComment($output,$config) {		
			$preg_replace = array(
			""=>"#/\*[^*]*\*+([^/][^*]*\*+)*/#",
			""=>"/<!--([^\[\]]*)-->/Uis",
			"\n"=>"/^\s+|\n|\r|\s+$/m",
			"\r\n"=>"/[\n\n]+/",
			);			
			foreach($preg_replace as $to=>$from){
				$output = preg_replace($from,$to,$output);
			}
		return $output;
	}
	/********************************************************/
	/*      			. createOutput					 	*/
	/********************************************************/	
	private function createOutput($data) {		
		$return='';	
		$key='';	
		$output='';	
		if(isset($data['output'])&&isset($data['ext'])){	
		
			header ("Content-type: text/".$data['ext']."; charset: UTF-8");
			$offset = 2592000;
			$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset)." GMT";
			header ($expire);

			$glob_key = $data['key'].'_'.(int)$data['skin_id'];
			$ext=$data['ext'];	
			$minify=$data['minify'];
			$output=$data['output'];	
			$key = substr(md5(json_encode($data)),0,9);	
			$file = DIR_STORE . 'assets/cache/'.$ext.'/'.$glob_key.'_'.$key.'.'.$ext;
			$return .=$file;
			if(!file_exists($file)) {
				if($ext=='css'&&$minify){
					$output=$this->compressCss($output);
				}
				if($ext=='js'&&$minify){
					$output=JSMin::minify($output);	
				}
				$this->writeOutput($file,$output);
				$cache_files = glob(DIR_STORE . 'assets/cache/'.$ext.'/'.$glob_key.'_*');
				foreach($cache_files as $cache_file){
					if($cache_file!==$file){
						@unlink($cache_file);
					}
				}
			}
		}	
		return str_replace(DIR_STORE,'',$return);
	}	
	private function minScript($script) {
		$return = $script;	
		$output='';	
			$filename=preg_replace('/^.+[\\\\\\/]/', '',$script);
			$file_ext =substr(strrchr($script, '.'), 1);	
			$arrays = array(".min", ".js", ".css", "-", "_", "?",":", ".", "+", "-", "=", ",", "&");
			$script_name = str_replace($arrays, "", $filename);
			$key = substr(md5($script),0,9).'_'.$script_name;				
			$file=DIR_STORE . 'assets/cache/js/'.$key.'.js';
			
		if (file_exists($file)&&$this->val()==true) {
			$return = str_replace(DIR_STORE,'',$file);
		}
		if(!file_exists($file)&&file_exists(DIR_STORE.$script)&&$file_ext=='js'&&$this->val()==true) {
			$output .=JSMin::minify(file_get_contents(DIR_STORE.$script)).'; ';
			$this->writeOutput($file,$output);
		}
		return $return;
	}		
	private function minScripts($scripts) {
		$return ='';
			$fileheader='/*!';	
			$output='';	
			$local ='';	
			$key = substr(md5(json_encode($scripts)),0,9).'_combined';;
			$file= DIR_STORE . 'assets/cache/js/'.$key.'.js';	
			
			if (!file_exists($file)){
				foreach ($scripts as $script) {		
					$fileheader .= '+'.$script;
					$filename=preg_replace('/^.+[\\\\\\/]/', '',$script);
					$file_ext =substr(strrchr($script, '.'), 1);	
					if(file_exists(DIR_STORE.$script)&&$file_ext=='js') {
						if($this->val()==true){
							$output .= JSMin::minify(file_get_contents(DIR_STORE.$script)).'; ';
						}else{
							$output .= file_get_contents(DIR_STORE.$script).'; ';
						}
					}				
				}	
					$fileheader .= '*/ ';
				if(!empty($output)){
					$this->writeOutput($file,/* $fileheader.*/$output);
				}
			}
			if (file_exists($file)){			
				if (filesize($file) > 0) {
					$local .= str_replace(DIR_STORE,'',$file);
				}
			}	
				$return .=$local;	
			
			foreach ($scripts as $script) {
				if(strpos($script,'https://')== true||strpos($script,'http://')== true){				
					$return .=$script;					
				}
			}
		return $return;	
	}	
/********************************************************/
/*      			. minStyle				 	   */
/********************************************************/		
	private function minStyle($style) {
		$return	=	$style['href'];		
			$filename=preg_replace('/^.+[\\\\\\/]/', '',$style['href']);
			$file_ext =substr(strrchr($filename, '.'), 1);		
			$arrays = array(".min", ".js", ".css", "-", "_", "?",":", ".", "+", "-", "=", ",", "&");
			$css_name = str_replace($arrays, "", $filename);
			$key = substr(md5($style['href']),0,9).'_'.$css_name;			
			$file=DIR_STORE . 'assets/cache/css/'.$key.'.css';
				
			if (file_exists($file)&&$this->val()==true){		
				$return = str_replace(DIR_STORE,'',$file);	
			}
			if(!file_exists($file)&&file_exists(DIR_STORE.$style['href'])&&$file_ext=='css'&&$this->val()==true) {	
					$output='';
					$output .=$this->internalCss($style['href']);
					$this->writeOutput($file,$output);
			}
		return $return;
	}
	private function minStyles($styles) {		
		$return ='';
				$key = substr(md5(json_encode($styles)),0,9).'_combined';
				$file=DIR_STORE . 'assets/cache/css/'.$key.'.css';		
				$fileheader='/*!';		
				$output='';			
				$local='';
				
				if (!file_exists($file)){		
					foreach ($styles as $style) {	
						$fileheader .= '+'.$style['href'];			
						$filename=preg_replace('/^.+[\\\\\\/]/', '',$style['href']);
						$file_ext =substr(strrchr($filename, '.'), 1);		
						if(file_exists(DIR_STORE.$style['href'])&&$file_ext=='css') {
							$output .=(!empty($style['media'])&&$style['media']!='all'&&$style['media']!='screen')?'@media '.$style['media'].'{':'';
							$output .=$this->internalCss($style['href']);
							$output .=(!empty($style['media'])&&$style['media']!='all'&&$style['media']!='screen')?'}':'';
						}
					} 			
					$fileheader .= '*/ ';		
					if(!empty($output)){
						$this->writeOutput($file,$fileheader.$output);	
					}
		
				}
				if (file_exists($file)){			
					if (filesize($file) > 0) {
						$local .= str_replace(DIR_STORE,'',$file);
						$return .=$local;				
					}
				}
		return $return;
	}	
	private function internalCss($file) {	
		$output = '';		
		$filename=preg_replace('/^.+[\\\\\\/]/', '',$file);	
		$file_ext =substr(strrchr($filename, '.'), 1);	
		$style_url=str_replace($filename,'',$this->store_url.$file);		
		if(file_exists(DIR_STORE.$file)&&$file_ext=='css') {	
			if(strpos($file,'assets/cache/css/') !== false){				
				$output=file_get_contents($file);
			}else{
				$relative_style_url = str_replace($this->store_url,'../../../',$style_url);
				$content=preg_replace('/url\(\s*[\'"]?\/?(.+?)[\'"]?\s*\)/i', 'url('.$relative_style_url.'$1)', file_get_contents($file));
				$output =$content;
				$data_image = 'url('.$relative_style_url.'data:';
				$output =str_replace($data_image,'url(data:',$content);
				$output=$this->compressCss($output);
			}
		}
		return $output;
	}
	private function compressCss($output) {
		if($this->val()==true){	
			$output = preg_replace("/<!--([^\[\]]*)-->/Uis", '', $output);
			$output = preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', '', $output);
			$output = preg_replace("(// .+)", "", $output);	
			for($i=1;$i<=4;$i++){
				$output = preg_replace('|/\w+/\.\./|', '/', $output);
			}
			$output = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "   ", "    ")," ", $output);
			$replace = array(
			" "=>"  |   ",
			">"=>" > |> | >",
			","=>" , |, | ,",
			"{"=>" { |{ | {",
			"}"=>" } |} | }",
			" ("=>" ( |( ",
			"!imp"=>" !imp",
			":"=>": ",
			";"=>"; ",
			"} @"=>"}@",
			"px"=>"pxpx"
			);
			foreach($replace as $to=>$from){ 
				$array = explode("|",$from);
				$output = str_replace($array,$to,$output);
			}
		}
		return $output;
	}
	public function writeOutput($file,$output) {
			$directories = dirname(str_replace('../', '', $file));					
			if (!is_dir($directories)){
				@mkdir($directories,  0777, true);
			}
			$handle = fopen($file, 'w');
			fwrite($handle,$output);		
			fclose($handle); 
			touch($file,time());
	}
}
?>