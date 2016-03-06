<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesGlobal extends Model {	
	public function getLanguageByCode($code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}

	public function checkInstall() {	
		$this->db->query("UPDATE `".DB_PREFIX."setting` SET value = 'default' WHERE `key` = 'config_template'");	
	}
	public function updateCatalogCategories($data) {
		foreach ($data as $category_id => $value) {
			$top = isset($value['top'])?$value['top']:0;
			$column = isset($value['column'])?$value['column']:1;
			$this->db->query("UPDATE " . DB_PREFIX . "category SET 
			`top` = '" .(int)$top. "',
			`column` = '" .(int)$column. "',
			`sort_order` = '" . (int)$value['sort_order'] . "',
			`display` = '" . $this->db->escape($value['display']). "' WHERE category_id = '" . (int)$category_id . "'");
		}
	}
	public function updateContentCategories($data) {
		foreach ($data as $content_id => $value) {
			$top = isset($value['top'])?$value['top']:0;
			$column = isset($value['column'])?$value['column']:1;
			$this->db->query("UPDATE " . DB_PREFIX . "ave_category SET 
			`top` = '" .(int)$top. "',
			`column` = '" .(int)$column. "',
			`sort_order` = '" . (int)$value['sort_order'] . "',
			`display` = '" . $this->db->escape($value['display']). "' WHERE content_id = '" . (int)$content_id . "'");
		}
	}
	public function getContentImage($content_id){
		$return = $this->config->get('config_logo');
		$query = $this->db->query("SELECT image FROM ".DB_PREFIX."ave_category WHERE content_id = '" . (int)$content_id . "'");
		if ($query->row&&!empty($query->row['image'])) {
				$return = $query->row['image'];		
		}	
		return $return;
	}
	public function getArticleImage($article_id){
		$return = $this->config->get('config_logo');
		$query = $this->db->query("SELECT image FROM ".DB_PREFIX."ave_article WHERE article_id = '" . (int)$article_id . "'");
		if ($query->row&&!empty($query->row['image'])) {
				$return = $query->row['image'];		
		}	
		return $return;
	}
	public function getCategoryImage($category_id){
		$return = $this->config->get('config_logo');
		$query = $this->db->query("SELECT image FROM ".DB_PREFIX."category WHERE category_id = '" . (int)$category_id . "'");
		if ($query->row&&!empty($query->row['image'])) {
				$return = $query->row['image'];		
		}	
		return $return;
	}
	public function getProductImage($product_id){
		$return = $this->config->get('config_logo');
		$query = $this->db->query("SELECT image FROM ".DB_PREFIX."product WHERE product_id = '" . (int)$product_id . "'");
		if ($query->row&&!empty($query->row['image'])) {
				$return = $query->row['image'];		
		}	
		return $return;
	}
	public static $all_product_categories = array();
	
	public function getAllProductCategories() {
		if ( ! empty(self::$all_product_categories)) {
			return self::$all_product_categories;
		}
		$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description, cd.meta_description as meta_description, cd.meta_keyword AS meta_keyword FROM ".DB_PREFIX."category c LEFT JOIN ".DB_PREFIX."category_description cd ON (c.category_id = cd.category_id) LEFT JOIN ".DB_PREFIX."category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
		return self::$all_product_categories = $query->rows;
	}		
	public function getProductCategories($parent_id = 0) {
		$all_categories = $this->getAllProductCategories();
		$categories = array();
		foreach ($all_categories as $category) {
			if ($category['parent_id'] == $parent_id) {
				$categories[] = $category;
			}
		}
		$all_categories = NULL;
		return $categories;
	}
	public function getProductCategory($category_id) {
		$return = array();
		$all_categories = $this->getAllProductCategories();
		foreach ($all_categories as $category) {
			if ($category['category_id'] == $category_id) {
				$return = $category;
			}
		}
		$all_categories = NULL;
		return $return;
	}
	public function getProductCategoryGroup($group) {	
		$categories = array();
		if (!is_array($group)) {
			$group=array();
		}		
		$all_categories = $this->getAllProductCategories();
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
	public function getTotalProductsByCategories($categories=array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		$cache = md5(http_build_query($categories));
		$category_total = $this->cache->get('product.category_total.'.(int)$this->config->get('config_store_id').'.'.$customer_group_id .'.'.$cache);
		
		if (!$category_total) {		
			$category_total = array();	
			foreach ($categories as $category) {
				$category_id = $category['category_id'];
				$total = $this->getTotalProductsByCategory(array('filter_category_id'  => $category_id,'filter_sub_category' => true));
				$category_total[$category_id] = array(	
					'name'        => $category['name'],
					'total'  	  =>$total,				
				);
			}
			if(!empty($category_total)){
				$this->cache->set('product.category_total.'.(int)$this->config->get('config_store_id').'.'.$customer_group_id .'.'.$cache, $category_total);
			}
		}
		
		return $category_total;
		
	}
	public function getProductToCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	public function getTotalProductsByCategory($data = array()) {
		
			$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM ".DB_PREFIX."product p 
			LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)";
	
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
						
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
						
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_category_id'];
					
					$categories = $this->getProductCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $category_id) {
						$implode_data[] = (int)$category_id;
					}
								
					$sql .= " AND p2c.category_id IN (".implode(', ', $implode_data).")";			
				} else {
					$sql .= " AND p2c.category_id = '".(int)$data['filter_category_id']."'";
				}
			}		
			$query = $this->db->query($sql);
			
		return $query->row['total'];
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
	public function getProductCategoriesByParentId($parent_id) {
		
		$all_product_categories = $this->getAllProductCategories();
		$category_data = array();
		
		foreach ($all_product_categories as $category) {	
				
			if ($parent_id==$category['parent_id']) {
				
				$category_data[] = $category['category_id'];
	
				$children = $this->getProductCategoriesByParentId($category['category_id']);
	
				if ($children) {
					$category_data = array_merge($children, $category_data);
				}	
			}
		}
		return $category_data;
	}	
	public function getProduct($product_id,$store_id=0) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND p2s.store_id = '" . (int)$store_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	public function getProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache = md5(http_build_query($data));
		$product_data = $this->cache->get('product.query.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$customer_group_id .'.'.$cache);
		
		if (!$product_data) {
			
		$sql = "SELECT p.product_id, p.viewed, 
		(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, 
		(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, 
		(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special"; 
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";			
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}
		
			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}
		
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";	
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";			
			}	
		
			if (!empty($data['filter_filter'])) {
				$implode = array();
				
				$filters = explode(',', $data['filter_filter']);
				
				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}
				
				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";				
			}
		}	

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";
			
			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}
				
				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			
			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}
			
			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}	
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}
			
			$sql .= ")";
		}
					
		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}
		
		$sql .= " GROUP BY p.product_id";
		
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.viewed',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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
		
		$product_data = array();
		$id_group = array();
				
		$query = $this->db->query($sql);
	
		if($query->rows) {
			foreach ($query->rows as $result) {
				$id_group[$result['product_id']] = $result['product_id'];
			}
			$product_data = $this->getProductsGroup(array('id_group'=>$id_group));
			
		}
			$this->cache->set('product.query.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$customer_group_id .'.'.$cache, $product_data);
		}
		return $product_data;
	}
	public function getProductSpecials($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}					
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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
		
		$product_data = array();
		$id_group = array();
		if($query->rows) {
			foreach($query->rows as $result) {
				$id_group[$result['product_id']] = $result['product_id'];
			}
			$product_data = $this->getProductsGroup(array('id_group'=>$id_group));			
		}
		return $product_data;
	}
	public function getProductRelated($product_id,$limit=6) {
		$product_data = array();
		$product_info = $this->getProduct($product_id);
		if($product_info){
			$manufacturer_id = $product_info['manufacturer_id'];
			$start = 0;
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p
									   LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
									   WHERE p.manufacturer_id = '" . (int)$manufacturer_id . "'
									   AND p.product_id != '" . (int)$product_id . "'
									   AND p.status = '1'
									   AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
									   LIMIT ".$start.",".$limit."");
	
			$id_group = array();
			if($query->rows) {
				foreach ($query->rows as $result) {
					$id_group[$result['product_id']] = $result['product_id'];
				}
				$product_data = $this->getProductsGroup(array('id_group'=>$id_group));
			}
		}
		return $product_data;
	}
	public function getPopularProducts($limit) {
		
		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
		
		
		$product_data = array();
		$id_group = array();
		if($query->rows) {
			foreach($query->rows as $result) {
				$id_group[$result['product_id']] = $result['product_id'];
			}
			$this->load->model('avethemes/global');
			$product_data = $this->getProductsGroup(array('id_group'=>$id_group));			
		}
		return $product_data;
	}
	public function getBestSellerProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 			
			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
		$product_data = array();
		$id_group = array();
		if($query->rows) {
			foreach($query->rows as $result) {
				$id_group[$result['product_id']] = $result['product_id'];
			}
			$this->load->model('avethemes/global');
			$product_data = $this->getProductsGroup(array('id_group'=>$id_group));
		}
			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}
	public function getProductsGroup($data) {	
		$products_data=array();	
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
			$sql = "SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";
		
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (isset($data['id_group'])) {
				if (!empty($data['id_group'])) {
						$id_group=implode(',',$data['id_group']);					
						$sql .= " AND p.product_id IN (".$id_group.")";
					
				} 
		$query = $this->db->query($sql);
			if ($query->num_rows) {		
				foreach ($query->rows as $result) {
				$queries[$result['product_id']]=array(
					'product_id'       => $result['product_id'],
					'name'             => $result['name'],
					'description'      => $result['description'],
					'meta_description' => $result['meta_description'],
					'meta_keyword'     => $result['meta_keyword'],
					'tag'              => $result['tag'],
					'model'            => $result['model'],
					'sku'              => $result['sku'],
					'upc'              => $result['upc'],
					'ean'              => $result['ean'],
					'jan'              => $result['jan'],
					'isbn'             => $result['isbn'],
					'mpn'              => $result['mpn'],
					'location'         => $result['location'],
					'quantity'         => $result['quantity'],
					'stock_status'     => $result['stock_status'],
					'image'            => $result['image'],
					'manufacturer_id'  => $result['manufacturer_id'],
					'manufacturer'     => $result['manufacturer'],
					'price'            => ($result['discount'] ? $result['discount'] : $result['price']),
					'special'          => $result['special'],
					'reward'           => $result['reward'],
					'points'           => $result['points'],
					'tax_class_id'     => $result['tax_class_id'],
					'date_available'   => $result['date_available'],
					'weight'           => $result['weight'],
					'weight_class_id'  => $result['weight_class_id'],
					'length'           => $result['length'],
					'width'            => $result['width'],
					'height'           => $result['height'],
					'length_class_id'  => $result['length_class_id'],
					'subtract'         => $result['subtract'],
					'rating'           => round($result['rating']),
					'reviews'          => $result['reviews'] ? $result['reviews'] : 0,
					'minimum'          => $result['minimum'],
					'sort_order'       => $result['sort_order'],
					'status'           => $result['status'],
					'date_added'       => $result['date_added'],
					'date_modified'    => $result['date_modified'],
					'viewed'           => $result['viewed']
				);
				}
				foreach ($data['id_group'] as $id) {
					$products_data[$id] = $queries[$id];
				}
			} 
		
		} 
		return $products_data;	
	}
	
	public function getDownloadsGroup($group) {	
		$return = false;
		if (is_array($group)) {
			$group=implode(',',$group);
		}
		if(!empty($group)){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_download d LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id IN (".$group.") AND  dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");	
			if ($query->num_rows) {
				$return = $query->rows;		
			}
		}
		return $return;		
	}
	public function getManufacturers($store_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$store_id . "' ORDER BY m.sort_order, LCASE(m.name) ASC");
		
		return $query->rows;
	}
	public function getInformations($store_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$store_id . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}
	public function getInformationsGroup($group) {	
		$return = false;
		if (is_array($group)) {
			$group=implode(',',$group);
		}
		if(!empty($group)){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id IN (".$group.") AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");	
			if ($query->num_rows) {
				$return = $query->rows;		
			}
		}
		return $return;	
	}
	public function getManufacturersGroup($group) {	
		$return = false;
		if (is_array($group)) {
			$group=implode(',',$group);
		}		
		if(!empty($group)){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id IN (".$group.") AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY name ASC");
			if ($query->num_rows) {
				$return = $query->rows;		
			}
		}
		return $return;		
	}
	public function getDownloads($data = array()) {
		$return = false;
		$sql = "SELECT * FROM ".DB_PREFIX."ave_download d LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
				$return = $query->rows;		
		}	
		return $return;
	}
	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_download d LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND  dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");		
		return $query->row;
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
/*      	. Create Field If Not Exists				*/
/********************************************************/
	public function checkField($table,$field,$type) {	
		$this->db = $this->registry->get('db');
		$exists = false;
		$query=$this->db->query("SHOW columns FROM `".DB_PREFIX.$table."`");	
		foreach($query->rows as $column){
			if($column['Field'] == $field){
			 $exists=true;
			}
		}
		if($exists==false){
		$this->db->query("ALTER TABLE ".DB_PREFIX.$table." ADD `".$this->db->escape($field)."` ".$this->db->escape($type));
		}
	}
}
?>