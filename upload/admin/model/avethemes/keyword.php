<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesKeyword extends Model {
	public function generateKeyword($data) {	
		$return = false;
			$group=$data['group'];
			$autokw_seo_config=$data['config'];
			$return=false;
			$prefix = '';
			$sufix = '';
			$extension = '';
			if($group=='product'){
				$field_title = 'name';
				$group_id = 'product_id';
				$config = $autokw_seo_config['product'];
				$queryrows = $this->db->query("SELECT p.product_id, p.model, m.name AS manufacturer, pd.name AS name, pd.meta_title AS meta_title FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (pd.product_id = p.product_id AND pd.language_id = '" . (int)$config['language_id']. "')");		
			}
			if($group=='category'){
				$field_title = 'name';
				$group_id = 'category_id';
				$config = $autokw_seo_config['category'];
				$queryrows = $this->db->query("SELECT c.category_id, cd.name AS name, cd.meta_title AS meta_title FROM " . DB_PREFIX . "category c LEFT JOIN ".DB_PREFIX."category_description cd ON (cd.category_id = c.category_id AND cd.language_id = '" . (int)$config['language_id']. "')");	
			}
			if($group=='manufacturer'){
				$field_title = 'name';
				$group_id = 'manufacturer_id';
				$config = $autokw_seo_config['manufacturer'];
				$queryrows = $this->db->query("SELECT m.manufacturer_id, m.name FROM " . DB_PREFIX . "manufacturer m");	
			}
			if($group=='information'){
				$field_title = 'name';
				$group_id = 'information_id';
				$config = $autokw_seo_config['information'];
				$queryrows = $this->db->query("SELECT i.information_id, id.title AS name, id.meta_title FROM " . DB_PREFIX . "information i LEFT JOIN ".DB_PREFIX."information_description id ON (id.information_id = i.information_id AND id.language_id = '" . (int)$config['language_id']. "')");	
			}
			if($group=='content'){
				$field_title = 'name';
				$group_id = 'content_id';
				$config = $autokw_seo_config['content'];
				$queryrows = $this->db->query("SELECT c.content_id , cd.name AS name FROM " . DB_PREFIX . "ave_category c LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (cd.content_id = c.content_id AND cd.language_id = '" . (int)$config['language_id']. "') WHERE c.type='category' OR c.type='faq'");	
			}
			if($group=='article'){
				$field_title = 'name';
				$group_id = 'article_id';
				$config = $autokw_seo_config['article'];
				$queryrows = $this->db->query("SELECT p.article_id, a.author AS author, pd.name AS name FROM " . DB_PREFIX . "ave_article p LEFT JOIN " . DB_PREFIX . "ave_author a ON (p.author_id = a.author_id) LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (pd.article_id = p.article_id AND pd.language_id = '" . (int)$config['language_id']. "')");
			}
			if($group=='author'){
				$field_title = 'author';
				$group_id = 'author_id';
				$config = $autokw_seo_config['author'];
				$queryrows = $this->db->query("SELECT a.author_id, a.author FROM " . DB_PREFIX . "ave_author a");
			}	
			$queries = array();
			
			//DELETE OLD KEYWORD
			$queries[] = "DELETE FROM ".DB_PREFIX."url_alias WHERE `query` LIKE '".$group_id."=%'";
				
			foreach ($queryrows->rows as $result) {			
				$result_id = $result[$group_id];	
				$result_name = html_entity_decode($result[$field_title], ENT_QUOTES, 'UTF-8');
				if(isset($config['extension'])){
					$extension = $config['extension'];
				}
				/*Prefix*/ 
				if($config['prefix']==$group_id){
					$prefix = $result[$group_id].'-';
				}
				if($config['prefix']=='model'){
					$prefix = $result['model'].'-';
				}
				if($config['prefix']=='manufacturer'){
					$prefix = $result['manufacturer'].'-';
				}
				if($config['prefix']=='author'){
					$prefix = $result['author'].'-';
				}
				if($config['prefix']=='meta_title'){
					$prefix = $result['meta_title'].'-';
				}
				/*Sufix*/ 
				if($config['sufix']==$group_id){
					$sufix = '-'.$result[$group_id];
				}
				if($config['sufix']=='model'){
					$sufix = '-'.$result['model'];
				}
				if($config['sufix']=='manufacturer'){
					$sufix = '-'.$result['manufacturer'];
				}
				if($config['sufix']=='meta_title'){
					$sufix = '-'.$result['meta_title'];
				}
				if($config['sufix']=='author'){
					$sufix = '-'.$result['author'];
				}
				/*Product*/ 
				$unicode = $prefix.$result_name.$sufix;
				$keyword = $this->strip_unicode($unicode).$extension;
				if(!empty($config['separator'])){
					$keyword = str_replace('-',$config['separator'],$keyword);
				}
				$return .= 'ID: '.$result_id;	
				$return .= ' Name: '.$result_name;	
				$return .= ' => Keyword: '.$keyword."\n";	
				$queries[] = "INSERT INTO " . DB_PREFIX . "url_alias SET query = '".$group_id."=" . $result_id . "', keyword = '" . $keyword . "';";
			}
			$total =0;
			foreach ($queries as $query) {
				$this->db->query($query);
				$total++;
			}	
			$date = 'Date Created: '.date('Y/m/d H:i:s', time())."\nTotal: ".($total-1)." results.\n\n";
			$this->writeOutput(DIR_LOGS.'kw_'.$group.'.txt',$date.$return);
			$return = $date.$return;
		return $return;
	}	
	public function updateKeyword($group,$id) {
		$is_replace = $this->config->get('autokw_status');
		if($is_replace=='1'){
			$language_id = $this->config->get('config_language_id');
			$ruler =array(
				'prefix'=>'',
				'sufix'=>'',
				'separator'=>'',
				'language_id'=>$language_id,
				'extension'=>''
			);
			$autokw_seo_config = array(
							'product' =>$ruler,
							'category' =>$ruler,
							'manufacturer' =>$ruler,
							'information' =>$ruler
						);
			if ($this->config->has('autokw_seo_config')) { 
				$autokw_seo_config = $this->config->get('autokw_seo_config');
			}
				$prefix = '';
				$sufix = '';
				$extension = '';
				$queryrows = $query_row = false;
			if($group=='product'){
					$field_title = 'name';
					$group_id = 'product_id';
					$config = $autokw_seo_config['product'];
				$queryrows = $this->db->query("SELECT p.product_id, p.model, m.name AS manufacturer, pd.name AS name, pd.meta_title AS meta_title FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (pd.product_id = p.product_id AND pd.language_id = '" . (int)$config['language_id']. "') WHERE p.product_id = '" . (int)$id . "'");
					if ($queryrows->num_rows) {$query_row = $queryrows->row;}	
			}
			if($group=='category'){
				$field_title = 'name';
				$group_id = 'category_id';
				$config = $autokw_seo_config['category'];
				$queryrows = $this->db->query("SELECT c.category_id, cd.name AS name, cd.meta_title AS meta_title FROM " . DB_PREFIX . "category c LEFT JOIN ".DB_PREFIX."category_description cd ON (cd.category_id = c.category_id AND cd.language_id = '" . (int)$config['language_id']. "') WHERE c.category_id = '" . (int)$id . "'");	
					if ($queryrows->num_rows) {$query_row = $queryrows->row;}	
			}
			if($group=='manufacturer'){
				$field_title = 'name';
				$group_id = 'manufacturer_id';
				$config = $autokw_seo_config['manufacturer'];
				$queryrows = $this->db->query("SELECT m.manufacturer_id, m.name FROM " . DB_PREFIX . "manufacturer m WHERE m.manufacturer_id = '" . (int)$id . "'");	
					if ($queryrows->num_rows) {$query_row = $queryrows->row;}	
			}
			if($group=='information'){
				$field_title = 'name';
				$group_id = 'information_id';
				$config = $autokw_seo_config['information'];
				
				$queryrows = $this->db->query("SELECT i.information_id, id.title AS name, id.meta_title FROM " . DB_PREFIX . "information i LEFT JOIN ".DB_PREFIX."information_description id ON (id.information_id = i.information_id AND id.language_id = '" . (int)$config['language_id']. "') WHERE i.information_id = '" . (int)$id . "'");	
				
					if ($queryrows->num_rows) {$query_row = $queryrows->row;}	
			}
			if($group=='content'){
				$field_title = 'name';
				$group_id = 'content_id';
				$config = $autokw_seo_config['content'];
				$queryrows = $this->db->query("SELECT c.content_id , cd.name AS name FROM " . DB_PREFIX . "ave_category c LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (cd.content_id = c.content_id AND cd.language_id = '" . (int)$config['language_id']. "') WHERE c.content_id = '" . (int)$id . "' AND  c.type='category' OR c.type='faq'");	
			}
			if($group=='article'){
				$field_title = 'name';
				$group_id = 'article_id';
				$config = $autokw_seo_config['article'];
				$queryrows = $this->db->query("SELECT p.article_id, a.author AS author, pd.name AS name FROM " . DB_PREFIX . "ave_article p LEFT JOIN " . DB_PREFIX . "ave_author a ON (p.author_id = a.author_id) LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (pd.article_id = p.article_id AND pd.language_id = '" . (int)$config['language_id']. "') WHERE p.article_id = '" . (int)$id . "'");
			}
			if($group=='author'){
				$field_title = 'author';
				$group_id = 'author_id';
				$config = $autokw_seo_config['author'];
				$queryrows = $this->db->query("SELECT a.author_id, a.author FROM " . DB_PREFIX . "ave_author a WHERE a.author_id = '" . (int)$id . "'");
			}
			if(!empty($query_row)){
				$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = '".$group_id."=" . (int)$id. "'");
					$result_id = $query_row[$group_id];	
					$result_name = html_entity_decode($query_row[$field_title], ENT_QUOTES, 'UTF-8');
					if(isset($config['extension'])){
						$extension = $config['extension'];
					}
					/*Prefix*/ 
					if($config['prefix']==$group_id){
						$prefix = $query_row[$group_id].'-';
					}
					if($config['prefix']=='model'){
						$prefix = $query_row['model'].'-';
					}
					if($config['prefix']=='manufacturer'){
						$prefix = $query_row['manufacturer'].'-';
					}
					if($config['prefix']=='meta_title'){
						$prefix = $query_row['meta_title'].'-';
					}
					
					/*Sufix*/ 
					if($config['sufix']==$group_id){
						$sufix = '-'.$query_row[$group_id];
					}
					if($config['sufix']=='model'){
						$sufix = '-'.$query_row['model'];
					}
					if($config['sufix']=='manufacturer'){
						$sufix = '-'.$query_row['manufacturer'];
					}
					if($config['sufix']=='meta_title'){
						$sufix = '-'.$query_row['meta_title'];
					}
					if($config['sufix']=='author'){
						$sufix = '-'.$result['author'];
					}
					/*Product*/ 
					$unicode = $prefix.$result_name.$sufix;
					$keyword = $this->strip_unicode($unicode).$extension;
					if(!empty($config['separator'])){
						$keyword = str_replace('-',$config['separator'],$keyword);
					}
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '".$group_id."=" . $result_id . "', keyword = '" . $keyword . "';");	
					
			}
		}
	}
	public function strip_unicode($str){
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
	public function writeOutput($file,$output) {
			$directories = dirname(str_replace('../', '', $file));					
			if (!is_dir($directories)){
				@mkdir($directories,  0777, true);
			}					
			$handle = fopen($file, 'w');
			fwrite($handle,$output);		
			fclose($handle);
	}
}