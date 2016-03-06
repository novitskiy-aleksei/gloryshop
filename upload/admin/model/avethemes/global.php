<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesGlobal extends Model {
	
	public function importXML($file) {
		/*Import XML*/ 
		$this->load->language('extension/installer');
		$error = array();
		

		$this->load->model('extension/modification');
		
		// If xml file just put it straight into the DB
			$xml = file_get_contents($file);

			if ($xml) {
				try {
					$dom = new DOMDocument('1.0', 'UTF-8');
					$dom->loadXml($xml);
					
					$name = $dom->getElementsByTagName('name')->item(0);

					if ($name) {
						$name = $name->nodeValue;
					} else {
						$name = '';
					}
					
					$code = $dom->getElementsByTagName('code')->item(0);

					if ($code) {
						$code = $code->nodeValue;
						
						// Check to see if the modification is already installed or not.
						$modification_info = $this->model_extension_modification->getModificationByCode($code);
						
						if ($modification_info) {							
							$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%".$code."%'");
						}
					} else {
						$error['error'] = $this->language->get('error_code');
					}

					$author = $dom->getElementsByTagName('author')->item(0);

					if ($author) {
						$author = $author->nodeValue;
					} else {
						$author = '';
					}

					$version = $dom->getElementsByTagName('version')->item(0);

					if ($version) {
						$version = $version->nodeValue;
					} else {
						$version = '';
					}

					$link = $dom->getElementsByTagName('link')->item(0);

					if ($link) {
						$link = $link->nodeValue;
					} else {
						$link = '';
					}

					$modification_data = array(
						'name'    => $name,
						'code'    => $code,
						'author'  => $author,
						'version' => $version,
						'link'    => $link,
						'xml'     => $xml,
						'status'  => 1
					);
					
					if (!$error) {
						$this->model_extension_modification->addModification($modification_data);
					}
				} catch(Exception $exception) {
					$error['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
		}
		return $error;
	}
	public function updateCatalogIcon($icon,$category_id) {	
		$table ='category';
		$field = 'icon';
		$type = 'VARCHAR( 32 ) NOT NULL';
		$update_sql ="UPDATE " . DB_PREFIX . "category SET icon = '" . $this->db->escape($icon) . "' WHERE category_id = '" . (int)$category_id . "'";
		$exists = false;
		$query=$this->db->query("SHOW columns FROM `".DB_PREFIX.$table."`");	
		foreach($query->rows as $column){
			if($column['Field'] == $field){
			 $exists=true;
				$this->db->query($update_sql);
			}
		}
		if($exists==false){
				$this->db->query("ALTER TABLE ".DB_PREFIX.$table." ADD `".$this->db->escape($field)."` ".$this->db->escape($type));
				$this->db->query($update_sql);
		}
	}
	public function getProductCategoryGroup($group) {	
		$categories = array();
		if (!is_array($group)) {
			$group=array();
		}		
		$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description, cd.meta_description as meta_description, cd.meta_keyword AS meta_keyword FROM ".DB_PREFIX."category c LEFT JOIN ".DB_PREFIX."category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
		$all_categories = $query->rows;
		if(!empty($group)){				
			foreach ($group as $category_id) {
				foreach ($all_categories as $category) {
					if ($category['category_id'] == $category_id) {
						$categories[$category_id] = $category;
					}
				}
			}
		}
		$all_categories = NULL;
		return $categories;		
	}
	public function insertLanguage($language_id){	
			//Content Category
			$categories = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
			foreach ($categories->rows as $category) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_description SET 
				content_id = '" . (int)$category['content_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($category['name']) . "', 
				meta_description = '" . $this->db->escape($category['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($category['meta_keyword']) . "', 
				description = '" . $this->db->escape($category['description']) . "'");
			}
			
			$faqs = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_content_faq WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
			foreach ($faqs->rows as $faq) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_content_faq SET 
				content_id = '" . (int)$faq['content_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				sort_order = '" . (int)$faq['sort_order'] . "',
				question = '" . $this->db->escape($faq['question']) . "', 
				answer = '" . $this->db->escape($faq['answer']) . "'");
			}
	
			$this->cache->delete('content');
			
			//Service Group
			$services = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
			foreach ($services->rows as $service) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_description SET 
				service_id = '" . (int)$service['service_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($service['name']) . "'");
			}
			$this->cache->delete('service_group');
			//Content Article
			$articles = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
			foreach ($articles->rows as $article) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_description SET 
				article_id = '" . (int)$article['article_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($article['name']) . "', 
				meta_description = '" . $this->db->escape($article['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($article['meta_keyword']) . "', 
				description = '" . $this->db->escape($article['description']) . "', 
				tag = '" . $this->db->escape($article['tag']) . "'				
				");
			}	
			//Content Article Images
			$article_images = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_image WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
			foreach ($article_images->rows as $image) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_image SET 
				article_id = '" . (int)$image['article_id'] . "', 
				image = '" . $this->db->escape($image['image']) . "', 
				sort_order = '" . (int)$image['sort_order'] . "', 
				language_id = '" . (int)$language_id . "', 
				image_title = '" . $this->db->escape($image['image_title']) . "', 
				image_description = '" . $this->db->escape($image['image_description']) . "'");
			}	
			$this->cache->delete('article');
			//Content Free Download
			$downloads = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_download_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");	
			foreach ($downloads->rows as $download) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_download_description SET 
				download_id = '" . (int)$download['download_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($download['name']) . "',
				description = '" . $this->db->escape($download['description']) . "'");
			}	
			//Community Polls
			$polls = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_poll_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");	
			foreach ($polls->rows as $poll) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_poll_description SET 
				poll_id = '" . (int)$poll['poll_id'] . "', 
				language_id = '" . (int)$language_id . "', 
				question = '" . $this->db->escape($poll['question']) . "',
				answer_1 = '" . $this->db->escape($poll['answer_1']) . "',
				answer_2 = '" . $this->db->escape($poll['answer_2']) . "',
				answer_3 = '" . $this->db->escape($poll['answer_3']) . "',
				answer_4 = '" . $this->db->escape($poll['answer_4']) . "',
				answer_5 = '" . $this->db->escape($poll['answer_5']) . "',
				answer_6 = '" . $this->db->escape($poll['answer_6']) . "',
				answer_7 = '" . $this->db->escape($poll['answer_7']) . "',
				answer_8 = '" . $this->db->escape($poll['answer_8']) . "',
				answer_9 = '" . $this->db->escape($poll['answer_9']) . "',
				answer_10 = '" . $this->db->escape($poll['answer_10']) . "',
				answer_11 = '" . $this->db->escape($poll['answer_11']) . "',
				answer_12 = '" . $this->db->escape($poll['answer_12']) . "',
				answer_13 = '" . $this->db->escape($poll['answer_13']) . "',
				answer_14 = '" . $this->db->escape($poll['answer_14']) . "',
				answer_15 = '" . $this->db->escape($poll['answer_15']) . "'");
			}	
	}
	public function deleteLanguage($language_id){
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_description WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_content_faq WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_description WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_description WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_image WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_download_description WHERE language_id = '" . (int)$language_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_poll_description WHERE language_id = '" . (int)$language_id . "'");
		$this->cache->delete('content');
		$this->cache->delete('article');
		
	}
	public function getInformations($store_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$store_id . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}
	
	public function getManufacturers($store_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$store_id . "' ORDER BY m.sort_order, LCASE(m.name) ASC");
		
		return $query->rows;
	}
	/********************************************************/
	/*      		.getFreeDownload		 			*/
	/********************************************************/	
	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_download d LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND  dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");		
		return $query->row;
	}
	/********************************************************/
	/*      		.getProductWithStoreID		 			*/
	/********************************************************/	
	public function getProduct($product_id,$store_id=0) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND p2s.store_id = '" . (int)$store_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	/********************************************************/
	/*      		.getProductsWithStoreID		 			*/
	/********************************************************/	
	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
		
		if (!empty($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";			
		}
				
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_store'])) {
			$sql .= " AND p2s.store_id = '" . (int)$data['filter_store'] . "'";
		}
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY p.product_id";
					
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY pd.name";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function handleIntegrated($actions,$remove) {		
		foreach($actions as $action){	
				foreach($action['files'] as $filename){	
					foreach($action['handles'] as $handle=>$task){	
							foreach($task as $value){				
								if($remove==1){
									$this->handleWrite($filename,$task['original'],$task['replace'],$task['keyword'],$remove);
								}else{
									$this->handleWrite($filename,$task['replace'],$task['original'],$task['keyword'],$remove);
								}
						
							}//task
					}//handles		
				}//handles		
		}//actions	
	}
	public function handleWrite($filename, $original, $replace, $keyword, $remove) {		
		$this->load->language('avethemes/handle_write');	
		$text_success=($remove==1)?$this->language->get('text_success'):$this->language->get('text_unsuccess');
		
		$real_filename = realpath($filename);			
		if (!file_exists($real_filename)) {
			$this->log_write(sprintf($this->language->get('text_file_not_found'),$filename));		
		}else{	
			$content = $original_content = file_get_contents($real_filename);
			if($content === FALSE) {
				$this->log_write(sprintf($this->language->get('text_not_open'),$filename));
				return;
			}		
			if($remove){
				$content = str_replace($keyword, '', $content);//replace		
				if($content !== $original_content){
					return;
				}
			}
				
			$content = str_replace($original, $replace, $content);//replace
					
			if($content === NULL) {
				$this->log_write(sprintf($this->language->get('text_regex'),$original));
				return;
			}
					
			if($content !== $original_content) {					
				if(!is_writeable($real_filename)) {
					$this->log_write(sprintf($this->language->get('text_not_write'),$filename));
					return;
				}else{					
					$result = file_put_contents($real_filename, $content);
					if($result) {
						$this->log_write(sprintf($text_success,$keyword,$filename));				
						return;
					} else {
						$this->log_write(sprintf($this->language->get('text_write_fail'),$filename));
						return;
					}
				}
			}
		}//!file_exists
		
	}
	protected function log_write($log) {	
        if (($fp = @fopen(DIR_LOGS.'ave_log.txt', 'a'))) {
            fwrite($fp, $log."\n\n");
            fclose($fp);
        }
    }
	public function getTwitterLang(){	
		 $twitter_langs = array(	
          'en'=>'English',
		  'ja'=>'Japanese - 日本語',
          'pt'=>'Portuguese - Português',
          'da'=>'Danish - Dansk',
          'sv'=>'Swedish - Svenska',
          'uk'=>'Ukrainian - Українська мова',
          'it'=>'Italian - Italiano',
          'msa'=>'Malay - Bahasa Melayu',
          'zh-tw'=>'Traditional Chinese - 繁體中文',
          'es'=>'Spanish - Español',
          'fr'=>'French - français',
          'tr'=>'Turkish - Türkçe',
          'hi'=>'Hindi - हिन्दी',
          'he'=>'Hebrew - עִבְרִית',
          'id'=>'Indonesian - Bahasa Indonesia',
          'th'=>'Thai - ภาษาไทย',
          'ar'=>'Arabic - العربية',
          'zh-cn'=>'Simplified Chinese - 简体中文',
          'de'=>'German - Deutsch',
          'pl'=>'Polish - Polski',
          'ca'=>'Catalan - català',
          'ko'=>'Korean - 한국어',
          'no'=>'Norwegian - Norsk',
          'nl'=>'Dutch - Nederlands',
          'hu'=>'Hungarian - Magyar',
          'fa'=>'Farsi - فارسی',
          'ur'=>'Urdu - اردو',
          'ru'=>'Russian - Русский',
          'fil'=>'Filipino - Filipino',
          'fi'=>'Finnish - Suomi',
		 );
		 return $twitter_langs;
	}
	public function getFacebookLang(){
		 /* regular and Google fonts array*/
		 $skin_facebook_langs = array(		 
            'af_ZA'               => 'Afrikaans',
            'sq_AL'               => 'Albanian',
            'ar_AR'               => 'Arabic',
            'az_AZ'               => 'Azeri',
            'hy_AM'               => 'Armenian',
            'be_BY'               => 'Belarusian',
            'bg_BG'               => 'Bulgarian',
            'eu_ES'               => 'Basque',
            'bn_IN'               => 'Bengali',
            'bs_BA'               => 'Bosnian',
            'ca_ES'               => 'Catalan',
            'cs_CZ'               => 'Czech',
            'hr_HR'               => 'Croatian',
            'da_DK'               => 'Danish',
            'nl_NL'               => 'Dutch',
            'en_US'               => 'English',
            'eo_EO'               => 'Esperanto',
            'et_EE'               => 'Estonian',
            'fi_FI'               => 'Finnish',
            'fo_FO'               => 'Faroese',
            'tl_PH'               => 'Filipino',
            'fr_FR'               => 'French',
            'fy_NL'               => 'Frisian',
            'de_DE'               => 'German',
            'el_GR'               => 'Greek',
            'gl_ES'               => 'Galician',
            'ka_GE'               => 'Georgian',
            'he_IL'               => 'Hebrew',
            'hi_IN'               => 'Hindi',
            'hu_HU'               => 'Hungarian',
            'ga_IE'               => 'Irish',
            'id_ID'               => 'Indonesian',
            'is_IS'               => 'Icelandic',
            'it_IT'               => 'Italian',
            'ja_JP'               => 'Japanese',
            'km_KH'               => 'Khmer',
            'ko_KR'               => 'Korean',
            'ku_TR'               => 'Kurdish',
            'lt_LT'               => 'Lithuanian',
            'lv_LV'               => 'Latvian',
            'ml_IN'               => 'Malayalam',
            'ms_MY'               => 'Malay',
            'ne_NP'               => 'Nepali',
            'nn_NO'               => 'Norwegian',
            'pa_IN'               => 'Punjabi',
            'pl_PL'               => 'Polish',
            'fa_IR'               => 'Persian',
            'pt_BR'               => 'Portuguese (Brazil)',
            'pt_PT'               => 'Portuguese (Portugal)',
            'ro_RO'               => 'Romanian',
            'ru_RU'               => 'Russian',
            'sk_SK'               => 'Slovak',
            'es_ES'               => 'Spanish',
            'sl_SI'               => 'Slovenian',
            'sr_RS'               => 'Serbian',
            'sv_SE'               => 'Swedish',
            'sw_KE'               => 'Swahili',
            'zh_CN'               => 'Simplified Chinese (China)',
            'ta_IN'               => 'Tamil',
            'te_IN'               => 'Telugu',
            'th_TH'               => 'Thai',
            'zh_HK'               => 'Traditional Chinese (Hong Kong)',
            'zh_TW'               => 'Traditional Chinese (Taiwan)',
            'tr_TR'               => 'Turkish',
            'uk_UA'               => 'Ukrainian',
            'vi_VN'               => 'Vietnamese',
            'cy_GB'               => 'Welsh',
		);
		
		 return $skin_facebook_langs;
	}	
	
/********************************************************/
/*      . Create Blog Category Database                 */
/********************************************************/
	public function checkContentCategory() {
		$queries =array();	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_category` (
			  `content_id` int(11) NOT NULL AUTO_INCREMENT,
			  `type` varchar(64) COLLATE utf8_general_ci DEFAULT 'category',
			  `display` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT 'mega',
			  `item_display` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT 'blog',
			  `content_size` varchar(64) COLLATE utf8_general_ci DEFAULT 'col-3',
			  `link` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `target` varchar(32) COLLATE utf8_general_ci DEFAULT '_self',
			  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `icon` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `top` tinyint(1) NOT NULL,
			  `column` int(3) NOT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '999',
			  `grid_limit` int(1) NOT NULL DEFAULT '4',
			  `status` tinyint(1) NOT NULL,
			  `nav_thumb` tinyint(1) NOT NULL DEFAULT '1',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`content_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";
			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_content_faq` (
			  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
			  `content_id` int(11) NOT NULL,
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT 'grey-cararra',
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `language_id` int(11) NOT NULL,
			  `question` varchar(255) COLLATE utf8_general_ci,
			  `answer` text COLLATE utf8_general_ci,
			  PRIMARY KEY (`faq_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";
			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_category_description` (
			  `content_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `description` longtext COLLATE utf8_general_ci NOT NULL,
			  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  PRIMARY KEY (`content_id`,`language_id`),
			  KEY `name` (`name`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";		
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_category_to_layout` (
			  `content_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,PRIMARY KEY (`content_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_category_to_store` (
			  `content_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`content_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	
			foreach ($queries as $query) {
				$this->db->query($query);
			}
	}

/********************************************************/
/*      . Create Service Tab		                    */
/********************************************************/
public function checkServiceGroup() {
		$queries =array();	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_service` (
			  `service_id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `link_id` int(11) NOT NULL DEFAULT '0',
			  `icon` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
			  `section` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`service_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";
			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_service_description` (
			  `service_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `description` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  PRIMARY KEY (`service_id`,`language_id`),
			  KEY `name` (`name`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";		
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_service_to_store` (
			  `service_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`service_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_service_quote` (
			  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` int(11) NOT NULL,
			  `customer_name` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `avatar` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `customer_telephone` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `customer_email` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `service_selection` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `customer_company` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `competence` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `budget`  varchar(32) COLLATE utf8_general_ci NOT NULL,
			  `message`  varchar(3000) COLLATE utf8_general_ci NOT NULL,
			  `reply_message`  text COLLATE utf8_general_ci NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `read` int(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`quote_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=10 ;";	
			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_testimonial` (
			  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` int(11) NOT NULL,
			  `avatar` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `customer_name` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `customer_telephone` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `customer_email` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `customer_company` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `competence` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `service_selection` varchar(128) COLLATE utf8_general_ci NOT NULL,
			  `message`  varchar(3000) COLLATE utf8_general_ci NOT NULL,
			  `rating` int(1) NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `read` int(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`testimonial_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=10 ;";	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_testimonial_service` (
		  `testimonial_id` int(11) NOT NULL,
		  `service_id` int(11) NOT NULL,
		  PRIMARY KEY (`testimonial_id`,`service_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";				
		foreach ($queries as $query) {
			$this->db->query($query);
		}
	}
/********************************************************/
/*      . Create Blog Article Database                  */
/********************************************************/
	public function checkContentArticle() {		
		$queries =array();	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article` (
			  `article_id` int(11) NOT NULL AUTO_INCREMENT,			 
			  `article_service` varchar(255) COLLATE utf8_general_ci NOT NULL,	
			  `article_download` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `related_article_display` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT 'post-carousel-grid',
			  `grid_limit` int(1) NOT NULL DEFAULT '4',
			  `carousel_limit` int(1) NOT NULL DEFAULT '3',
			  `related_product_display` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT 'owl-carousel',
			  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `author_id` int(11) NOT NULL,
			  `poll_id` int(11) NOT NULL,
			  `icon` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT 'blue-sky',
			  `item_display` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT 'blog',
			  `sort_order` int(11) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `viewed` int(5) NOT NULL DEFAULT '0',PRIMARY KEY (`article_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";		
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article_description` (
			  `article_id` int(11) NOT NULL AUTO_INCREMENT,
			  `language_id` int(11) NOT NULL,`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `description` longtext COLLATE utf8_general_ci NOT NULL,
			  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `related_title` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `related_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `tag` text COLLATE utf8_general_ci NOT NULL,
			  PRIMARY KEY (`article_id`,`language_id`),
			  KEY `name` (`name`),
			  FULLTEXT KEY `description` (`description`),
			  FULLTEXT KEY `tag` (`tag`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";					
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article_image` (
			  `article_image_id` int(11) NOT NULL AUTO_INCREMENT,
			  `article_id` int(11) NOT NULL,
			  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `language_id` int(11) NOT NULL,
			  `image_title` varchar(255) COLLATE utf8_general_ci,
			  `image_description` varchar(512) COLLATE utf8_general_ci,
			  PRIMARY KEY (`article_image_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_related_article` (
			  `article_id` int(11) NOT NULL,`article_related_id` int(11) NOT NULL,PRIMARY KEY (`article_id`,`article_related_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_related_product` (
			  `article_id` int(11) NOT NULL,`product_related_id` int(11) NOT NULL,PRIMARY KEY (`article_id`,`product_related_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article_to_category` (
			  `article_id` int(11) NOT NULL,`content_id` int(11) NOT NULL,PRIMARY KEY (`article_id`,`content_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article_to_layout` (
			  `article_id` int(11) NOT NULL,`store_id` int(11) NOT NULL,`layout_id` int(11) NOT NULL,PRIMARY KEY (`article_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_article_to_store` (
		  `article_id` int(11) NOT NULL,`store_id` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`article_id`,`store_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";					
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_author` (
			  `author_id` int(11) NOT NULL AUTO_INCREMENT,
			  `author` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT 'blue-sky',
			  `competence` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `socials` text COLLATE utf8_general_ci DEFAULT NULL,
			  `author_description` longtext COLLATE utf8_general_ci NOT NULL,
			  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
			  `sort_order` int(3) NOT NULL,PRIMARY KEY (`author_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";	
			
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_comment` (
			  `comment_id` int(11) NOT NULL AUTO_INCREMENT,`article_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `text` text COLLATE utf8_general_ci NOT NULL,
			  `rating` int(1) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`comment_id`),KEY `article_id` (`article_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;";		
			foreach ($queries as $query) {
				$this->db->query($query);
			}
		}	

/********************************************************/
/*      . Create Free Download Database                 */
/********************************************************/
	public function checkDownload(){		
		$queries =array();	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_download` (
			  `download_id` int(11) NOT NULL AUTO_INCREMENT,
			  `filename` varchar(128) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `mask` varchar(128) COLLATE utf8_general_ci NOT NULL DEFAULT '',
			  `color` varchar(64) COLLATE utf8_general_ci DEFAULT 'blue-sky',
			  `auth_key` varchar(64) COLLATE utf8_general_ci NOT NULL,
			  `downloaded` int(11) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',PRIMARY KEY (`download_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;";	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_download_description` (
				  `download_id` int(11) NOT NULL,
				  `language_id` int(11) NOT NULL,
				  `name` varchar(64) COLLATE utf8_general_ci NOT NULL,
				  `description` varchar(255) COLLATE utf8_general_ci NOT NULL,
				  PRIMARY KEY (`download_id`,`language_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";	
			
		foreach ($queries as $query) {
			$this->db->query($query);
		}
	}

/********************************************************/
/*      . Create Community Poll Database                */
/********************************************************/
	public function checkPoll(){	
		$queries =array();	
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_poll` (
		`poll_id` int(11) NOT NULL auto_increment, 
		`color` varchar(64) COLLATE utf8_general_ci DEFAULT 'blue-sky',
		`date_added` datetime NOT NULL default '0000-00-00 00:00:00', 
		PRIMARY KEY  (`poll_id`)) 
		ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_poll_description` (
		`poll_id` int(11) NOT NULL, 
		`language_id` int(11) NOT NULL, 
		`question` varchar(255) collate utf8_general_ci NOT NULL, 
		`answer_1` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_2` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_3` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_4` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_5` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_6` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_7` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_8` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_9` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_10` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_11` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_12` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_13` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_14` varchar(255) collate utf8_general_ci NOT NULL,
		`answer_15` varchar(255) collate utf8_general_ci NOT NULL,
		PRIMARY KEY  (`poll_id`,`language_id`), 
		KEY `question` (`question`)) 
		ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_poll_reactions` 
		(`poll_reaction_id` int(11) NOT NULL auto_increment, 
		`poll_id` int(11) NOT NULL, 
		`answer` int(11) NOT NULL, 
		PRIMARY KEY  (`poll_reaction_id`)) 
		ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_poll_to_store` (
		`poll_id` int(11) NOT NULL, 
		`store_id` int(11) NOT NULL, 
		PRIMARY KEY  (`poll_id`, `store_id`)) 
		ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		
		foreach ($queries as $query) {
			$this->db->query($query);
		}
	}

/********************************************************/
/*      . Create Banner Plus Database                  */
/********************************************************/
	public function checkSmushItDb(){
		$create_lossless_image_compression = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_lossless_image_compression` (
		`image_id` int(11) NOT NULL auto_increment,		
  		`image` varchar(255) COLLATE utf8_general_ci NOT NULL,	
  		`thumb` varchar(255) COLLATE utf8_general_ci NOT NULL,	
  		`message` varchar(255) COLLATE utf8_general_ci NOT NULL,	
		`old_size` int(11) NOT NULL, 
		`compress_size` int(11) NOT NULL, 
		`saving` varchar(64) COLLATE utf8_general_ci NOT NULL,
		`status` tinyint(1) NOT NULL DEFAULT '0', 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		PRIMARY KEY  (`image_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_lossless_image_compression);		
	}
/********************************************************/
/*      . Create Subscribe Database              		*/
/********************************************************/
	public function checkSubscribe(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_newsletter` (
			  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `email` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `firstname` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `lastname` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `subscribed` int(1) NOT NULL,
			  `code` varchar(255) COLLATE utf8_general_ci NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`email_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
	}	

	/********************************************************/
	/*      . Create Theme Skin              				*/
	/********************************************************/
	public function checkThemeSkin(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_theme` (
		  `skin_id` int(11) NOT NULL AUTO_INCREMENT,
		  `skin_name` varchar(64) COLLATE utf8_general_ci NOT NULL,
		  `color` varchar(64) COLLATE utf8_general_ci NOT NULL,
		  `theme_setting` longtext COLLATE utf8_general_ci NOT NULL,
		  `status` tinyint(1) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`skin_id`),
		  FULLTEXT KEY `theme_setting` (`theme_setting`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
		
		if (defined('DIR_STORE')&&!$this->config->get('skin_imported')) {
			$this->load->model('avethemes/skin');
			$skins = glob(DIR_STORE.'assets/skin/*.json');
			if ($skins) {
				foreach ($skins as $skin) {
					$skin = json_decode(file_get_contents($skin));					
					$content =array();
					foreach($skin as $key => $value){
						$content[$key] =$value;
					}
					if(!empty($content['authentication'])&&!empty($content['skin_name'])&&!empty($content['color'])&&!empty($content['theme_setting'])){						
						$skin_name		=	$content['skin_name'];		
						$skin_color		=	$content['color'];					
						$theme_setting	=	$content['theme_setting'];			
						$setting_len	=	strlen($theme_setting);			
						$key	= 	md5(json_encode(array_merge(array($skin_name,$skin_color),array($theme_setting,$setting_len))));
						if($key==$content['authentication']){
							$importdata = array(
							'skin_name'=> base64_decode($skin_name),
							'color'=>base64_decode($skin_color),
							'theme_setting'=>base64_decode($theme_setting),
							'status'=>1);
							$import_info = $this->model_avethemes_skin->importSkinData($importdata);	
						}
						
					}
				}
			}	
			$this->db->query("INSERT INTO `" . DB_PREFIX. "setting` SET `value` = '1',`key` = 'skin_imported'");	
		}	
	}
}
?>