<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesArticle extends Model {
	public function addArticle($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_article SET 
			author_id = '" . (int)$data['author_id'] . "', 		
			item_display = '" . $this->db->escape($data['item_display']) . "', 
			poll_id = '" . (int)$data['poll_id'] . "', 
			status = '" . (int)$data['status'] . "', 
			`icon` = '".$this->db->escape($data['icon'])."', 
			`color` = '".$this->db->escape($data['color'])."', 
			sort_order = '" . (int)$data['sort_order'] . "', 
			date_added = NOW()");
			
		$article_id = $this->db->getLastId();
		if (isset($data['article_download'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET article_download = '" . $this->db->escape(implode(',',$data['article_download'])) . "' WHERE article_id = '" . (int)$article_id . "'");
			
		}
		if (isset($data['article_service'])&&($data['item_display']=='project'||$data['item_display']=='gallery')) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET article_service = '" . $this->db->escape(implode(',',$data['article_service'])) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['related_article_display'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET related_article_display = '" . $this->db->escape($data['related_article_display']) . "',
			grid_limit = '" . (int)$data['grid_limit'] . "', 
			carousel_limit = '" . (int)$data['carousel_limit'] . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['related_product_display'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET related_product_display = '" . $this->db->escape($data['related_product_display']) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		
		if (isset($data['copy'])) {
			$copy =$data['copy'];
		}else{
			$copy ='';
		}
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_description SET 
			article_id = '" . (int)$article_id . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']).$copy. "', 
			meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', 
			meta_description = '" . $this->db->escape($value['meta_description']) . "', 
			description = '" . $this->db->escape($value['description']) . "', 
			tag = '" . $this->db->escape($value['tag']) . "'");
		}
		
		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		//image
		if(isset($data['article_image'])){
			foreach($data['article_image'] as $article_image){
				if($article_image['image']){
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_image WHERE article_id='".(int)$article_id."' AND image='".$this->db->escape($article_image['image'])."'");
		foreach($article_image['description'] as $language_id =>$article_image_description){				
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_image SET 
				article_id='".(int)$article_id."', 
				image='".$this->db->escape($article_image['image'])."', 
				sort_order='".$this->db->escape($article_image['sort_order'])."', 
				language_id='".(int)$language_id."',
				image_title='".$this->db->escape($article_image_description['image_title'])."',
				image_description='".$this->db->escape($article_image_description['image_description'])."'");
					}
				}
			}
		}
		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $content_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_category SET article_id = '" . (int)$article_id . "', content_id = '" . (int)$content_id . "'");
			}
		}
		
		if (isset($data['related_article'])) {
			foreach ($data['related_article'] as $article_related_id) {
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_id . "' AND article_related_id = '" . (int)$article_related_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_article SET article_id = '" . (int)$article_id . "', article_related_id = '" . (int)$article_related_id . "'");
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_related_id . "' AND article_related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_article SET article_id = '" . (int)$article_related_id . "', article_related_id = '" . (int)$article_id . "'");
			}
		}
		
		if (isset($data['related_product'])) {
			foreach ($data['related_product'] as $product_related_id) {
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_product WHERE article_id = '" . (int)$article_id . "' AND product_related_id = '" . (int)$product_related_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_product SET article_id = '" . (int)$article_id . "', product_related_id = '" . (int)$product_related_id . "'");				
			}
		}

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		if(empty($data['keyword'])){
				$lang_id=$this->config->get('config_language_id');
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['article_description'][$lang_id]['name']);
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		if ($this->config->get('ave_installed')&&isset($data['keyword'])) { 
				$this->load->model('avethemes/keyword');		
				$this->model_avethemes_keyword->updateKeyword('article',$article_id);
		}		
		$this->cache->delete('article');
		
	}
	
	public function editArticle($article_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_article SET 
			author_id = '" . (int)$data['author_id'] . "',  
			item_display = '" . $this->db->escape($data['item_display']) . "',
			poll_id = '" . (int)$data['poll_id'] . "', 
			status = '" . (int)$data['status'] . "', 
			`icon` = '".$this->db->escape($data['icon'])."', 
			`color` = '".$this->db->escape($data['color'])."', 
			sort_order = '" . (int)$data['sort_order'] . "', 
			date_added = '" . $this->db->escape($data['date_added']) . "',
			date_modified = NOW() 
			WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_download'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET article_download = '" . $this->db->escape(implode(',',$data['article_download'])) . "' WHERE article_id = '" . (int)$article_id . "'");
			
		}
		if (isset($data['article_service'])&&($data['item_display']=='project'||$data['item_display']=='gallery')) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET article_service = '" . $this->db->escape(implode(',',$data['article_service'])) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['related_article_display'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET related_article_display = '" . $this->db->escape($data['related_article_display']) . "',
			grid_limit = '" . (int)$data['grid_limit'] . "', 
			carousel_limit = '" . (int)$data['carousel_limit'] . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		if (isset($data['related_product_display'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_article SET related_product_display = '" . $this->db->escape($data['related_product_display']) . "' WHERE article_id = '" . (int)$article_id . "'");
		}
		
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_description WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_description SET article_id = '" . (int)$article_id . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "', 
			meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', 
			meta_description = '" . $this->db->escape($value['meta_description']) . "', 
			description = '" . $this->db->escape($value['description']) . "', 
			tag = '" . $this->db->escape($value['tag']) . "'");
		}

		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_store WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		//image
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_image WHERE article_id='".(int)$article_id."'");
    	if(!empty($data['article_image'])){
			foreach($data['article_image'] as $article_image){
				if($article_image['image']){
					$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_image WHERE article_id='".(int)$article_id."' AND image='".$this->db->escape($article_image['image'])."'");
		foreach($article_image['description'] as $language_id =>$article_image_description){				
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_image SET 
				article_id='".(int)$article_id."', 
				image='".$this->db->escape($article_image['image'])."', 
				sort_order='".$this->db->escape($article_image['sort_order'])."', 
				language_id='".(int)$language_id."', 
				image_title='".$this->db->escape($article_image_description['image_title'])."',
				image_description='".$this->db->escape($article_image_description['image_description'])."'");
					}
				}
			}
		}	
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_category WHERE article_id = '" . (int)$article_id . "'");
		
		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $content_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_category SET article_id = '" . (int)$article_id . "', content_id = '" . (int)$content_id . "'");
			}		
		}
		/*related article*/ 
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_related_id = '" . (int)$article_id . "'");

		if (isset($data['related_article'])) {
			foreach ($data['related_article'] as $article_related_id) {
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_id . "' AND article_related_id = '" . (int)$article_related_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_article SET article_id = '" . (int)$article_id . "', article_related_id = '" . (int)$article_related_id . "'");
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_related_id . "' AND article_related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_article SET article_id = '" . (int)$article_related_id . "', article_related_id = '" . (int)$article_id . "'");
			}
		}		
		/*related article*/ 
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_product WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_product WHERE product_related_id = '" . (int)$article_id . "'");
		if (isset($data['related_product'])) {
			foreach ($data['related_product'] as $product_related_id) {
				$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_product WHERE article_id = '" . (int)$article_id . "' AND product_related_id = '" . (int)$product_related_id . "'");
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_related_product SET article_id = '" . (int)$article_id . "', product_related_id = '" . (int)$product_related_id . "'");				
			}
		}
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO ".DB_PREFIX."ave_article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'article_id=" . (int)$article_id. "'");
		
		if(empty($data['keyword'])){
				$lang_id=$this->config->get('config_language_id');
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['article_description'][$lang_id]['name']);
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		if ($this->config->get('ave_installed')&&isset($data['keyword'])) { 
				$this->load->model('avethemes/keyword');		
				$this->model_avethemes_keyword->updateKeyword('article',$article_id);
		}				
		$this->cache->delete('article');
		
	}
	
	public function copyArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_article p LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '1';
			$data['copy'] = '-Copy';
						
			$data = array_merge($data, array('article_description' => $this->getArticleDescriptions($article_id)));	
			$data = array_merge($data, array('article_image' => $this->getArticleImages($article_id)));		
			$data = array_merge($data, array('related_article' => $this->getArticleRelated($article_id)));
			$data = array_merge($data, array('related_product' => $this->getProductRelated($article_id)));
			$data = array_merge($data, array('article_category' => $this->getArticleCategories($article_id)));
			$data = array_merge($data, array('article_layout' => $this->getArticleLayouts($article_id)));
			$data = array_merge($data, array('article_store' => $this->getArticleStores($article_id)));
			
			$this->addArticle($data);
		}
	}
	
	public function deleteArticle($article_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_description WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_image WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_related_article WHERE article_related_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_category WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_layout WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_article_to_store WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_comment WHERE article_id = '" . (int)$article_id . "'");
		
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'article_id=" . (int)$article_id. "'");
		
		$this->cache->delete('article');
		
	}
	
	public function getArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM ".DB_PREFIX."url_alias WHERE query = 'article_id=" . (int)$article_id . "') AS keyword FROM ".DB_PREFIX."ave_article p LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	
	public function getArticles($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."ave_article p LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id)";
			
		if (!empty($data['filter_content_category'])) {
			$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id)";			
		}	
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
    		if(!empty($data['filter_name'])){
				$sql.=" AND LCASE(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
			}
			//filter_service		
			if (isset($data['filter_service_group']) && !is_null($data['filter_service_group'])) {
					$sql .= " AND p.article_service LIKE '%" . $this->db->escape($data['filter_service_group']) . "%'";
			}
			//filter_author
			if (isset($data['filter_author']) && !is_null($data['filter_author'])) {
				$sql .= " AND p.author_id = '" . $this->db->escape($data['filter_author']) . "'";
			}
				//filter_date
			if (isset($data['filter_date']) && !is_null($data['filter_date'])) {
				$sql .= " AND p.date_added LIKE '" . $this->db->escape($data['filter_date']) . "%'";}
						
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
					
			if (!empty($data['filter_content_category'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "p2c.content_id = '" . (int)$data['filter_content_category'] . "'";
					
					$this->load->model('avethemes/category');
					
					$categories = $this->model_avethemes_category->getCategories($data['filter_content_category']);
					
					foreach ($categories as $category) {
						$implode_data[] = "p2c.content_id = '" . (int)$category['content_id'] . "'";
					}
					
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND p2c.content_id = '" . (int)$data['filter_content_category'] . "'";
				}
			}
			
			$sql .= " GROUP BY p.article_id";
						
			$sort_data = array(
				'pd.name',
				'p.image',
				'p2c.content_id',
				'p.date_added',
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
	
	public function getArticlesByCategoryId($content_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article p 
		LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.content_id = '" . (int)$content_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getArticleDescriptions($article_id) {
		$article_description_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_description WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}
		
		return $article_description_data;
	}
	public function getArticleStores($article_id) {
		$article_store_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_store WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}
		
		return $article_store_data;
	}

	public function getArticleLayouts($article_id) {
		$article_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_layout WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $article_layout_data;
	}
	public function getArticleCategories($article_id) {
		$article_category_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_category WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_category_data[] = $result['content_id'];
		}

		return $article_category_data;
	}

	public function getProductRelated($article_id) {
		$related_product_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_related_product WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$related_product_data[] = $result['product_related_id'];
		}
		
		return $related_product_data;
	}
	public function getArticleRelated($article_id) {
		$related_article_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_related_article WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$related_article_data[] = $result['article_related_id'];
		}
		
		return $related_article_data;
	}
	public function getTotalArticles($data = array()) {
	
		$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM ".DB_PREFIX."ave_article p LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id)";

		if (!empty($data['filter_content_category'])||!empty($data['filter_content_category'])) {
			$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id)";			
		}		 
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		//filter_content_category
			if (isset($data['filter_content_category']) && !is_null($data['filter_content_category'])) {
				$sql .= " AND p2c.content_id = '" . $this->db->escape($data['filter_content_category']) . "'";}
				
		//filter_service
		if (isset($data['filter_service_group']) && !is_null($data['filter_service_group'])) {
			$sql .= " AND p.article_service LIKE '%" . $this->db->escape($data['filter_service_group']) . "%'";
		}
			
		//filter_author
			if (isset($data['filter_author']) && !is_null($data['filter_author'])) {
				$sql .= " AND p.author_id = '" . $this->db->escape($data['filter_author']) . "'";}

		//filter_date
		if (isset($data['filter_date']) && !is_null($data['filter_date'])) {
				$sql .= " AND p.date_added LIKE '" . $this->db->escape($data['filter_date']) . "%'";}
								
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_content_category'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "p2c.content_id = '" . (int)$data['filter_content_category'] . "'";
				
				$this->load->model('avethemes/category');
				
				$categories = $this->model_avethemes_category->getCategories($data['filter_content_category']);
				
				foreach ($categories as $category) {
					$implode_data[] = "p2c.content_id = '" . (int)$category['content_id'] . "'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND p2c.content_id = '" . (int)$data['filter_content_category'] . "'";
			}
		}
		
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getTotalArticlesByAuthorId($author_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_article WHERE author_id = '" . (int)$author_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalArticlesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_article_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	public function getTotalArticle() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_article");
		
		return $query->row['total'];
	}
	public function getTotalKeywordByObjectID($keyword,$object,$id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."url_alias WHERE keyword = '" . $this->db->escape($keyword). "' AND query != '".$object."=" . (int)$id . "'");

		return $query->row['total'];
	}
	public function getTotalKeyword($keyword) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."url_alias WHERE keyword = '" . $this->db->escape($keyword). "'");
		return $query->row['total'];
	}	
	//image
	public function getArticleImages($article_id){		
		$article_image_data=array();
		$article_image_query=$this->db->query("SELECT *	FROM ".DB_PREFIX."ave_article_image WHERE article_id='".(int)$article_id."' GROUP BY image ORDER BY sort_order ASC");
		foreach($article_image_query->rows as $article_image){
			$article_image_description_data=array();
		$article_image_description_query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_image 
		WHERE article_id='".(int)$article_id."' AND image='".$this->db->escape($article_image['image'])."' ORDER BY sort_order ASC");
		
		foreach($article_image_description_query->rows as $article_image_description){
			$article_image_description_data[$article_image_description['language_id']]=array(
										'image_title' =>$article_image_description['image_title'],
										'image_description' =>$article_image_description['image_description']
											);
			}
			$article_image_data[]=array(
				'image'                  =>$article_image['image'],
				'sort_order'             =>$article_image['sort_order'],
				'description' =>$article_image_description_data
			);
		}
		return $article_image_data;
	}	
}
?>