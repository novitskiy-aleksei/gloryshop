<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesCategory extends Model {
	public static $all_categories = array();
	
	public function getAllCategories() {
		if (!empty(self::$all_categories)) {
			return self::$all_categories;
		}
		if ($this->config->get('ave_confirm_installed')) {		
			$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description, cd.meta_description as meta_description, cd.meta_keyword AS meta_keyword FROM ".DB_PREFIX."ave_category c LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) LEFT JOIN ".DB_PREFIX."ave_category_to_store c2s ON (c.content_id = c2s.content_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
			if ($query->num_rows) {
			return self::$all_categories = $query->rows;
			}
		}
	}
		
	public function getCategories($parent_id = 0) {
		$all_categories = $this->getAllCategories();
		$categories = array();
		if(!empty($all_categories)){
			foreach ($all_categories as $category) {
				if ($parent_id == $category['parent_id']) {
					$categories[] = $category;
				}
			}
		}
		return $categories;
	}
	
	public function getCategory($content_id) {
		$return = array();
		$all_categories = $this->getAllCategories();
		foreach ($all_categories as $category) {
			if ($category['content_id'] == $content_id) {
				$return = $category;
			}
		}
		return $return;
	}
	public function getCategoryGroup($group) {	
		$categories = array();
		if (!is_array($group)) {
			$group=array();
		}		
		$all_categories = $this->getAllCategories();
		if(!empty($group)&&!empty($all_categories)){				
			foreach ($group as $content_id) {
				foreach ($all_categories as $category) {
					if ($category['content_id'] == $content_id) {
						$categories[$content_id] = $category;
					}
				}
			}
		}
		return $categories;		
	}
		
	public function getCategoriesByParentId($parent_id) {
		
		$all_categories = $this->getAllCategories();
		
		$category_data = array();

		foreach ($all_categories as $category) {
			if ($parent_id==$category['parent_id']) {
				$category_data[] = $category['content_id'];
	
				$children = $this->getCategoriesByParentId($category['content_id']);
	
				if ($children) {
					$category_data = array_merge($children, $category_data);
				}
			}
		}

		return $category_data;
	}
			
	public function getCategoryLayoutId($content_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_to_layout WHERE content_id = '" . (int)$content_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}
					
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_category c 
		LEFT JOIN ".DB_PREFIX."ave_category_to_store c2s ON (c.content_id = c2s.content_id) 
		WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}
	public function getTotalArticlesByCategories($categories=array()) {
		$cache = md5(http_build_query($categories));
		
		$category_total = $this->cache->get('article.category_total.'.(int)$this->config->get('config_store_id').'.'.$cache);
		
		if (!$category_total) {		
			$category_total = array();		
			foreach ($categories as $category) {
				$content_id = $category['content_id'];
				$total = $this->getTotalArticlesByCategory(array('filter_content_id'  => $content_id,'filter_sub_category' => true));	
				$category_total[$content_id] = array(
					'name'        => $category['name'],
					'total'  	  =>$total,					
				);
			}	
			if(!empty($category_total)){
				$this->cache->set('article.category_total.'.(int)$this->config->get('config_store_id').'.'.$cache, $category_total);
			}
		}
		
		return $category_total;
		
	}
	public function getTotalArticlesByCategory($data = array()) {
			$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM ".DB_PREFIX."ave_article p 
			LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
			LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id)";
	
			if (!empty($data['filter_content_id'])) {
				$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id)";			
			}
						
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
						
			if (!empty($data['filter_content_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_content_id'];
					
					$categories = $this->getCategoriesByParentId($data['filter_content_id']);
										
					foreach ($categories as $content_id) {
						$implode_data[] = (int)$content_id;
					}
								
					$sql .= " AND p2c.content_id IN (".implode(', ', $implode_data).")";			
				} else {
					$sql .= " AND p2c.content_id = '".(int)$data['filter_content_id']."'";
				}
			}		
			$query = $this->db->query($sql);
			
		return $query->row['total'];
	}
	public function getFAQs($content_id) {
		$return = array();
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_content_faq WHERE content_id = '".(int)$content_id."' AND language_id='".(int)$this->config->get('config_language_id')."' ORDER BY sort_order ASC");
		if ($query->num_rows) {
			$return =$query->rows;
		}
		return $return;
	}
}
?>