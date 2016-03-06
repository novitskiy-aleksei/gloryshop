<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesTagsCloud extends Controller {
	public function index($setting=array()) {
		if(defined('ave_check')){
			if($setting['type']=='blog'){
				$tagQuery = $this->getRandomContentTags((int)$setting['limit']);	
				$link = 'content/search';
				$query = 'filter_tag=';
			}else{
				$tagQuery = $this->getRandomProductTags((int)$setting['limit']);	
				$link = 'product/search';	
				$query = 'tag=';
			}		
				$names		= array();
				$tags		= array();
				$tagcloud = array();
				
				if(!empty($tagQuery)){
					 foreach ($tagQuery as $row){
						$groups=explode(',',$row['tag']);
						foreach ($groups as $tag){
							$names[]=trim($tag);
						}
					}
				}
				foreach ($names as $value) {
					$tagcloud[] =  array(
					  'name'	=>	$value,
					  'href'	=>	$this->url->link($link, $query.str_replace(' ','%20',$value)),
					);
				}
			$data['tags_cloud'] = array_slice($tagcloud, 0, (int)$setting['limit']);
				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/tags_cloud_data.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/tags_cloud_data.tpl';
			} else {
				$this_template = 'default/avethemes/template/shortcodes/tags_cloud_data.tpl';
			}
			
			return $this->load->view($this_template, $data);
		}
	}
	private function getRandomContentTags($limit = 5) {
		$sql = "SELECT tag FROM " . DB_PREFIX . "ave_article_description ad 
		LEFT JOIN " . DB_PREFIX . "ave_article a ON a.article_id = ad.article_id WHERE a.status = '1' AND ad.tag != '' AND ad.language_id = '" . $this->config->get('config_language_id') . "' GROUP BY tag ORDER BY RAND() LIMIT " . $limit;
		$query = $this->db->query($sql);
		$return = false;
		if ($query->num_rows) {
			$return = $query->rows;
		}
		return $return;
	}
	private function getRandomProductTags($limit = 5) {
		$sql = "SELECT tag FROM " . DB_PREFIX . "product_description pd 
		LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE p.status = '1' AND pd.tag != '' AND pd.language_id = '" . $this->config->get('config_language_id') . "' GROUP BY tag ORDER BY RAND() LIMIT " . $limit;
		$query = $this->db->query($sql);
		$return = false;
		if ($query->num_rows) {
			$return = $query->rows;
		}
		return $return;
	}
}

?>