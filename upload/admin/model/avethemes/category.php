<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesCategory extends Model {
	
    public function getChildren($content_id) {
        $query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "ave_category WHERE parent_id = c.content_id) AS children FROM " . DB_PREFIX . "ave_category c LEFT JOIN " . DB_PREFIX . "ave_category_description cd ON (c.content_id = cd.content_id) WHERE c.parent_id = '" . (int)$content_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
        return $query->rows;
    }
	public function addCategory($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_category SET 
		parent_id = '" . (int)$data['parent_id'] . "', 
		`type` = '".$this->db->escape($data['type'])."', 
		`link` = '".$this->db->escape($data['link'])."', 
		`target` = '".$this->db->escape($data['target'])."', 
		`display` = '".$this->db->escape($data['display'])."', 
		`item_display` = '".$this->db->escape($data['item_display'])."', 
		`content_size` = '".$this->db->escape($data['content_size'])."', 
		`icon` = '".$this->db->escape($data['icon'])."', 
		`color` = '".$this->db->escape($data['color'])."', 
		`top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', 
		`column` = '" . (int)$data['column'] . "', 
		sort_order = '" . (int)$data['sort_order'] . "', 
		nav_thumb = '" . (int)$data['nav_thumb'] . "', 
		status = '" . (int)$data['status'] . "', 
		date_modified = NOW(), date_added = NOW()");
	
		$content_id = $this->db->getLastId();
		
		if($data['type']=='content'){
			$this->db->query("UPDATE ".DB_PREFIX."ave_category SET `top` = '1' WHERE content_id = '" . (int)$content_id . "'");
		}		
		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE content_id = '" . (int)$content_id . "'");
		}
		
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_description SET content_id = '" . (int)$content_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_to_store SET content_id = '" . (int)$content_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_to_layout SET content_id = '" . (int)$content_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
			
		//content_faq
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_content_faq WHERE content_id='".(int)$content_id."'");
		if(isset($data['content_faq'])){
			foreach($data['content_faq'] as $content_faq){
				if($content_faq['sort_order']){
		foreach($content_faq['description'] as $language_id =>$content_faq_description){				
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_content_faq SET 
				content_id='".(int)$content_id."', 
				color='".$this->db->escape($content_faq['color'])."', 
				sort_order='".(int)$content_faq['sort_order']."', 
				language_id='".(int)$language_id."',
				question='".$this->db->escape($content_faq_description['question'])."',
				answer='".$this->db->escape($content_faq_description['answer'])."'");
					}
				}
			}
		}
		
		if(empty($data['keyword'])&&$data['type']=='category'){
				$lang_id=$this->config->get('config_language_id');
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['category_description'][$lang_id]['name']);
		}			
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'content_id=" . (int)$content_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		if ($this->config->get('ave_installed')&&isset($data['keyword'])) { 
				$this->load->model('avethemes/keyword');		
				$this->model_avethemes_keyword->updateKeyword('content',$content_id);	
		}
		$this->cache->delete('content');
		$this->cache->delete('article');

	}
	
	public function editCategory($content_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_category SET 
		parent_id = '" . (int)$data['parent_id'] . "', 
		`type` = '".$this->db->escape($data['type'])."', 
		`link` = '".$this->db->escape($data['link'])."', 
		`target` = '".$this->db->escape($data['target'])."', 
		`display` = '".$this->db->escape($data['display'])."', 
		`item_display` = '".$this->db->escape($data['item_display'])."', 
		`content_size` = '".$this->db->escape($data['content_size'])."', 
		`icon` = '".$this->db->escape($data['icon'])."', 
		`color` = '".$this->db->escape($data['color'])."', 
		`top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', 
		`column` = '" . (int)$data['column'] . "', 
		sort_order = '" . (int)$data['sort_order'] . "', 
		nav_thumb = '" . (int)$data['nav_thumb'] . "', 
		status = '" . (int)$data['status'] . "', 
		date_modified = NOW() WHERE content_id = '" . (int)$content_id . "'");

		if($data['type']=='content'){
			$this->db->query("UPDATE ".DB_PREFIX."ave_category SET `top` = '1' WHERE content_id = '" . (int)$content_id . "'");
		}	
		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE content_id = '" . (int)$content_id . "'");
		}

		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_description WHERE content_id = '" . (int)$content_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_description SET content_id = '" . (int)$content_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_to_store WHERE content_id = '" . (int)$content_id . "'");
		
		if (isset($data['category_store'])) {		
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_to_store SET content_id = '" . (int)$content_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_to_layout WHERE content_id = '" . (int)$content_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_category_to_layout SET content_id = '" . (int)$content_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		
		//content_faq
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_content_faq WHERE content_id='".(int)$content_id."'");
		if(isset($data['content_faq'])){
			foreach($data['content_faq'] as $content_faq){
				if($content_faq['sort_order']){
		foreach($content_faq['description'] as $language_id =>$content_faq_description){				
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_content_faq SET 
				content_id='".(int)$content_id."', 
				color='".$this->db->escape($content_faq['color'])."', 
				sort_order='".(int)$content_faq['sort_order']."', 
				language_id='".(int)$language_id."',
				question='".$this->db->escape($content_faq_description['question'])."',
				answer='".$this->db->escape($content_faq_description['answer'])."'");
					}
				}
			}
		}
						
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'content_id=" . (int)$content_id. "'");
		
		if(empty($data['keyword'])&&$data['type']=='category'){
				$lang_id=$this->config->get('config_language_id');
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['category_description'][$lang_id]['name']);
		}	
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'content_id=" . (int)$content_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		if ($this->config->get('ave_installed')&&isset($data['keyword'])) {
				$this->load->model('avethemes/keyword');		
				$this->model_avethemes_keyword->updateKeyword('content',$content_id);
		}
		$this->cache->delete('content');
		$this->cache->delete('article');

	}
	
	public function deleteCategory($content_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category WHERE content_id = '" . (int)$content_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_description WHERE content_id = '" . (int)$content_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_to_store WHERE content_id = '" . (int)$content_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_category_to_layout WHERE content_id = '" . (int)$content_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_category WHERE content_id = '" . (int)$content_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'content_id=" . (int)$content_id . "'");
		
		$query = $this->db->query("SELECT content_id FROM ".DB_PREFIX."ave_category WHERE parent_id = '" . (int)$content_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['content_id']);
		}		
		$this->cache->delete('content');

	} 

	public function getCategory($content_id) {
		$query = $this->db->query("SELECT DISTINCT *, 
		(SELECT keyword FROM ".DB_PREFIX."url_alias WHERE query = 'content_id=" . (int)$content_id . "') AS keyword FROM ".DB_PREFIX."ave_category c 
		LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) 
		WHERE c.content_id = '" . (int)$content_id . "'");
		
		return $query->row;
	} 
	public function getCategoryInfo($content_id) {
		$query = $this->db->query("SELECT DISTINCT *, 
		(SELECT keyword FROM ".DB_PREFIX."url_alias WHERE query = 'content_id=" . (int)$content_id . "') AS keyword FROM ".DB_PREFIX."ave_category c 
		LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) 
		WHERE c.content_id = '" . (int)$content_id . "'");		
		return $query->row;
	} 
	public function getCategories($parent_id = 0) {
		$this->load->model('avethemes/article');
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category c 
			LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) 
			WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$total = '';
				if($result['type']=='category'){
					$total = ' (' . $this->model_avethemes_article->getTotalArticles(array('filter_content_category'  => $result['content_id'])) . ')';
				}
				$category_data[] = array(
					'content_id' => $result['content_id'],
					'item_display' => $result['item_display'],
					'total'  	  =>$total,	
					'parent_id' => $result['parent_id'],
					'image' => $result['image'],
					'icon' => $result['icon'],
					'top' => $result['top'],
					'type' => $result['type'],
					'name'        => $this->getPath($result['content_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['content_id']));
			}	
	
		
		return $category_data;
	}
		
	public function filterTotalCategories($data=array()) {
      	$sql = "SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_category c 
			LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) 
			WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (isset($data['parent_id'])) {
				$sql .= " AND c.parent_id = '" . (int)$data['parent_id'] . "'";
			}
			$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function filterCategories($data=array()) {		
		$this->load->model('avethemes/article');
				
			$sql = "SELECT * FROM ".DB_PREFIX."ave_category c 
			LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) 
			WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (isset($data['parent_id'])) {
				$sql .= " AND c.parent_id = '" . (int)$data['parent_id'] . "'";
			}
			$sql .= " ORDER BY c.sort_order, cd.name ASC";
		
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
			$category_data = array();
			foreach ($query->rows as $result) {
				$total = '';
				if($result['type']=='category'){
					$total = ' (' . $this->model_avethemes_article->getTotalArticles(array('filter_content_category'  => $result['content_id'])) . ')';
				}
				$category_data[] = array(
					'content_id' => $result['content_id'],
					'item_display' => $result['item_display'],
					'total'  	  =>$total,	
					'parent_id' => $result['parent_id'],
					'image' => $result['image'],
					'icon' => $result['icon'],
					'top' => $result['top'],
					'type' => $result['type'],
					'name'        => $this->getPath($result['content_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
				$category_data = array_merge($category_data, $this->getCategories($result['content_id']));
			}	
		return $category_data;
	}	
	public function getPath($content_id) {
		$query = $this->db->query("SELECT name, parent_id FROM ".DB_PREFIX."ave_category c LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) WHERE c.content_id = '" . (int)$content_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . ' &raquo; ' . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}
		
	public function getCategoryDescriptions($content_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_description WHERE content_id = '" . (int)$content_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}	
	
	public function getCategoryStores($content_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_to_store WHERE content_id = '" . (int)$content_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}

	public function getCategoryLayouts($content_id) {
		$category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_category_to_layout WHERE content_id = '" . (int)$content_id . "'");
		
		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $category_layout_data;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_category");
		
		return $query->row['total'];
	}	

	public function getCategoryGroup($group) {	
		$categories = array();
		if (!is_array($group)) {
			$group=array();
		}		
		$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description, cd.meta_description as meta_description, cd.meta_keyword AS meta_keyword FROM ".DB_PREFIX."ave_category c LEFT JOIN ".DB_PREFIX."ave_category_description cd ON (c.content_id = cd.content_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
		$all_categories = $query->rows;
		if(!empty($group)){				
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
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	//FAQ
	public function getContentFaqs($content_id){
		$faq_data=array();
		$faq_query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_content_faq WHERE content_id='".(int)$content_id."' ORDER BY sort_order ASC");
		
		if ($faq_query->num_rows) {
			foreach($faq_query->rows as $faq){
				$description[$faq['language_id']] = array(
											'question' =>$faq['question'],
											'answer' =>$faq['answer']
												);
												
				$faq_data[$faq['sort_order']]=array(
					'description' =>$description,
					'sort_order' =>$faq['sort_order'],
					'color' =>$faq['color']
				);
			}
		}
		return $faq_data;
	}		
}
?>