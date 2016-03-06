<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesArticle extends Model {
	public function updateViewed($article_id) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_article SET viewed = (viewed + 1) WHERE article_id = '".(int)$article_id."'");
	}
	
	public function getArticle($article_id) {				
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, p.color, au.author AS author, (SELECT AVG(rating) AS total FROM ".DB_PREFIX."ave_comment r1 WHERE r1.article_id = p.article_id AND r1.status = '1' GROUP BY r1.article_id) AS rating, (SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment r2 WHERE r2.article_id = p.article_id AND r2.status = '1' GROUP BY r2.article_id) AS comments, p.sort_order FROM ".DB_PREFIX."ave_article p LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id) LEFT JOIN ".DB_PREFIX."ave_author au ON (p.author_id = au.author_id) WHERE p.article_id = '".(int)$article_id."' AND pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'");
		
		if ($query->num_rows) {
			return array(
				'article_id'       => $query->row['article_id'],
				'article_service'  => $query->row['article_service'],
				'article_download' => $query->row['article_download'],
				'item_display' 		=> $query->row['item_display'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'image'              => $query->row['image'],			
				'author_id'  => $query->row['author_id'],	
				'poll_id'  => $query->row['poll_id'],
				'author'     => $query->row['author'],
				'rating'           => round($query->row['rating']),
				'comments'          => $query->row['comments'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],				
				'color'  	 => $query->row['color'],			
				'icon'  	 => $query->row['icon'],
			);
		} else {
			return false;
		}
	}
	
		
	public function getArticleServices($article_id) {
		$article_service_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_service WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_service_data[] = $result['service_id'];
		}

		return $article_service_data;
	}
	public function getArticleCategories($article_id) {
		$article_category_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_category WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_category_data[] = $result['content_id'];
		}

		return $article_category_data;
	}
	public function getArticlesGroup($data) {
		$sql = "SELECT DISTINCT *, pd.name AS name, p.image, p.color, au.author AS author, 
		(SELECT AVG(rating) AS total FROM ".DB_PREFIX."ave_comment r1 WHERE r1.article_id = p.article_id AND r1.status = '1' GROUP BY r1.article_id) AS rating,
		(SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment r2 WHERE r2.article_id = p.article_id AND r2.status = '1' GROUP BY r2.article_id) AS comments, 
		p.sort_order FROM ".DB_PREFIX."ave_article p 
		LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_author au ON (p.author_id = au.author_id)";
		
		$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' 
							AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'"; 
		
			if (isset($data['item_display'])&&!empty($data['item_display'])) {
				$sql .= " AND p.item_display = '".$this->db->escape($data['item_display'])."'";
			}
			if (isset($data['id_group'])) {
				if (!empty($data['id_group'])) {
						$id_group=implode(',',$data['id_group']);					
						$sql .= " AND p.article_id IN (".$id_group.")";
					
				} 
			} 
			$sort_data = array(
				'p.article_id',
				'pd.name',
				'au.author',
				'rating',
				'p.viewed',
				'p.sort_order',
				'p.date_added'
			);	
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'au.author') {
					$sql .= " ORDER BY LCASE(".$data['sort'].")";
				} else {
					$sql .= " ORDER BY ".$data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.date_added";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC, LCASE(pd.name) ASC";
			} else {
				$sql .= " DESC, LCASE(pd.name) DESC";
			}			
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
			}			
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getArticles($data = array()) {	
	
		$cache = md5(http_build_query($data));
		
		$article_data = $this->cache->get('article.query.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache);
		
		if (!$article_data) {
				
			$sql = "SELECT DISTINCT *, pd.name AS name, p.image, au.author AS author, 
		(SELECT AVG(rating) AS total FROM ".DB_PREFIX."ave_comment r1 WHERE r1.article_id = p.article_id AND r1.status = '1' GROUP BY r1.article_id) AS rating,
		(SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment r2 WHERE r2.article_id = p.article_id AND r2.status = '1' GROUP BY r2.article_id) AS comments, 
		p.sort_order FROM ".DB_PREFIX."ave_article p 
		LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_author au ON (p.author_id = au.author_id) "; 
						
			if (!empty($data['filter_content_id'])) {
				$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id)";			
			}
			
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'"; 
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					
					if (!empty($data['filter_description'])) {
						$sql .= "LCASE(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%' OR LCASE(pd.description) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
					} else {
						$sql .= "LCASE(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "pd.tag LIKE '%".$this->db->escape($data['filter_tag'])."%'";
				}
			
				$sql .= ")";
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(au.author) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
				}				
			}
			
			if (!empty($data['filter_content_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_content_id'];
					
					$this->load->model('avethemes/category');
					
					$categories = $this->model_avethemes_category->getCategoriesByParentId($data['filter_content_id']);
										
					foreach ($categories as $content_id) {
						$implode_data[] = (int)$content_id;
					}
								
					$sql .= " AND p2c.content_id IN (".implode(', ', $implode_data).")";			
				} else {
					$sql .= " AND p2c.content_id = '".(int)$data['filter_content_id']."'";
				}
			}			
			if (isset($data['item_display'])&&!empty($data['item_display'])) {
				$sql .= " AND p.item_display = '".$this->db->escape($data['item_display'])."'";
			}	
			if (!empty($data['filter_author_id'])) {
				$sql .= " AND p.author_id = '".(int)$data['filter_author_id']."'";
			}
			
			$sql .= " GROUP BY p.article_id";
			
			$sort_data = array(
				'p.article_id',
				'pd.name',
				'au.author',
				'rating',
				'p.viewed',
				'p.sort_order',
				'p.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'au.author') {
					$sql .= " ORDER BY LCASE(".$data['sort'].")";
				} else {
					$sql .= " ORDER BY ".$data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.date_added";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC, LCASE(pd.name) ASC";
			} else {
				$sql .= " DESC, LCASE(pd.name) DESC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
			}
			
					
			$article_data = array();
			$query = $this->db->query($sql);
			if ($query->num_rows) {
				$article_data = $query->rows; 
			}
			$this->cache->set('article.query.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache, $article_data);
		}
		return $article_data;
	}				
	public function getTotalArticleRelated($article_id) {
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_related_article ra 
		LEFT JOIN ".DB_PREFIX."ave_article a ON (ra.article_related_id = a.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_article_to_store a2s ON (a.article_id = a2s.article_id) 
		WHERE ra.article_id = '".(int)$article_id."' AND a.status = '1' AND a2s.store_id = '".(int)$this->config->get('config_store_id')."'");		
		
		

		return $query->row['total'];
		
		
	}
	
	public function getArticleSame($article_id,$item_display,$limit=6) {
		$article_data = array();
		$article_info = $this->getArticle($article_id);
		if($article_info){
			$author_id = $article_info['author_id'];
			$start = 0;
			$sql = "SELECT * FROM " . DB_PREFIX . "ave_article a
									   LEFT JOIN " . DB_PREFIX . "ave_article_to_store a2s ON (a.article_id = a2s.article_id)
									   WHERE a.author_id = '" . (int)$author_id . "'
									   AND a.article_id != '" . (int)$article_id . "'
									   AND a.status = '1'
									   AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
					if (isset($data['item_display'])&&!empty($data['item_display'])) {
						$sql .= " AND a.item_display = '".$this->db->escape($data['item_display'])."'";
					}
			$sql .= " LIMIT ".$start.",".$limit."";
			$query = $this->db->query($sql);
	
			$id_group = array();
			if($query->rows) {
				foreach ($query->rows as $result) {
					$id_group[$result['article_id']] = $result['article_id'];
				}
				$article_data = $this->getArticlesGroup(array('id_group'=>$id_group,'item_display'=>$item_display));
			}
		}
		return $article_data;
	}
	public function getArticleRelated($article_id,$item_display,$limit) {
			$start = 0;
		$id_group = array();
		$sql = "SELECT * FROM ".DB_PREFIX."ave_related_article ra 
		LEFT JOIN ".DB_PREFIX."ave_article a ON (ra.article_related_id = a.article_id) 
		LEFT JOIN ".DB_PREFIX."ave_article_to_store a2s ON (a.article_id = a2s.article_id) 
		WHERE ra.article_id = '".(int)$article_id."' 
		AND a.status = '1' AND a2s.store_id = '".(int)$this->config->get('config_store_id')."'";	
		
					if (isset($data['item_display'])&&!empty($data['item_display'])) {
						$sql .= " AND a.item_display = '".$this->db->escape($data['item_display'])."'";
					}
			$sql .= " LIMIT ".$start.",".$limit."";
		$query = $this->db->query($sql);
					
						
		foreach ($query->rows as $result) { 
			$id_group[$result['article_related_id']] = $result['article_related_id'];
		}	
		
		$data = array(
		'id_group'=>$id_group,
		'item_display'=>$item_display,
		'order'=>'ASC'
		);		
		$article_data = array();
		if(!empty($data)){
			$article_data = $this->getArticlesGroup($data);
		}
		return $article_data;
	}
	
	public function getTotalProductRelated($article_id) {
		$this->load->model('avethemes/global');
		$data = array();
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_related_product rp 
		LEFT JOIN ".DB_PREFIX."product p ON (rp.product_related_id = p.product_id) 
		LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE rp.article_id = '".(int)$article_id."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'");	
		
		return $query->row['total'];
	}	
	public function getProductRelated($article_id) {
		$this->load->model('avethemes/global');
		$data = array();
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_related_product rp 
		LEFT JOIN ".DB_PREFIX."product p ON (rp.product_related_id = p.product_id) 
		LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE rp.article_id = '".(int)$article_id."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'");	
		
		$id_group = array();
		$product_data = array();
			
		if($query->rows) {
			foreach ($query->rows as $result) { 
				$id_group[$result['product_related_id']] = $result['product_related_id'];
			}		
			$product_data = $this->model_avethemes_global->getProductsGroup(array('id_group'=>$id_group));			
		}
		return $product_data;
	}	
	
	public function getArticleLayoutId($article_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_layout WHERE article_id = '".(int)$article_id."' AND store_id = '".(int)$this->config->get('config_store_id')."'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  0;
		}
	}
	
	public function getCategories($article_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_category WHERE article_id = '".(int)$article_id."'");		
		return $query->rows;
	}	
		
	public function getTotalArticles($data = array()) {
		$cache = md5(http_build_query($data));
		
		$article_data = $this->cache->get('article.total.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache);
		
		if (!$article_data) {
			$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM ".DB_PREFIX."ave_article p 
			LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
			LEFT JOIN ".DB_PREFIX."ave_author au ON (au.author_id = p.author_id) 			
			LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id)";
	
			if (!empty($data['filter_content_id'])) {
				$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_category p2c ON (p.article_id = p2c.article_id)";			
			}
						
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					
					if (!empty($data['filter_description'])) {
						$sql .= "LCASE(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%' OR LCASE(pd.description) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
					} else {
						$sql .= "LCASE(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "MATCH(pd.tag) AGAINST('".$this->db->escape(utf8_strtolower($data['filter_tag']))."')";
				}
			
				$sql .= ")";
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(au.author) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_name']))."%'";
				}		
			}
						
			if (!empty($data['filter_content_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_content_id'];
					
					$this->load->model('avethemes/category');
					
					$categories = $this->model_avethemes_category->getCategoriesByParentId($data['filter_content_id']);
										
					foreach ($categories as $content_id) {
						$implode_data[] = (int)$content_id;
					}
								
					$sql .= " AND p2c.content_id IN (".implode(', ', $implode_data).")";			
				} else {
					$sql .= " AND p2c.content_id = '".(int)$data['filter_content_id']."'";
				}
			}		
			
			if (!empty($data['filter_author_id'])) {
				$sql .= " AND p.author_id = '".(int)$data['filter_author_id']."'";
			}
			
			$query = $this->db->query($sql);
			
			$article_data = $query->row['total']; 
			
			$this->cache->set('article.total.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache, $article_data);
		}
		
		return $article_data;
	}
	public function getTotalArticlesByAuthorId($author_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_article WHERE author_id = '".(int)$author_id."'");

		return $query->row['total'];
	}
	
	public function getServiceGroup($article_service){
		$service_data=array();
		$service_query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service s LEFT JOIN ".DB_PREFIX."ave_service_description sd ON (s.service_id = sd.service_id) 
		WHERE s.service_id IN (".$article_service.") AND s.status='1'AND sd.language_id = '".(int)$this->config->get('config_language_id')."'");
		foreach($service_query->rows as $service){		
			$service_data[]=array(
				'service_id'        =>$service['service_id'],
				'name'   		=>$service['name'],
				'icon'        =>$service['icon'],
				'color'  	 =>$service['color'],
				'section'  	 =>$service['section'],
				'description'   =>$service['description']
			);
		}
		return $service_data;
	}
	 
	public function getDownloadGroup($article_download){
		$download_data=array();
		$download_query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_download d LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id) 
		WHERE d.download_id IN (".$article_download.") AND dd.language_id = '".(int)$this->config->get('config_language_id')."'");
		
		foreach($download_query->rows as $download){		
			$download_data[]=array(
				'download_id'        =>$download['download_id'],
				'mask'        =>$download['mask'],
				'name'   		=>$download['name'],
				'color'  	 =>$download['color'],
				'description'   =>$download['description'],
				'auth_key'   =>$download['auth_key'],
				'filename'   =>$download['filename'],
			);
		}
		return $download_data;
	}
	/*
	public function getDownloads($article_id) {
		$download_data=array();
		$download_query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_to_download nad 
		LEFT JOIN ".DB_PREFIX."ave_download nd ON (nad.download_id = nd.download_id) 
		LEFT JOIN ".DB_PREFIX."ave_download_description ndd ON (nd.download_id = ndd.download_id)		
		WHERE ndd.language_id = '".(int)$this->config->get('config_language_id')."' AND nad.article_id='".(int)$article_id."' ORDER BY nad.download_id DESC");
		foreach($download_query->rows as $download){		
			$download_data[]=array(
				'download_id'        =>$download['download_id'],
				'mask'        =>$download['mask'],
				'name'   		=>$download['name'],
				'color'  	 =>$download['color'],
				'description'   =>$download['description'],
				'auth_key'   =>$download['auth_key'],
				'filename'   =>$download['filename'],
			);
		}
		return $download_data;
	}*/ 
	public function getArticleImages($article_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_image WHERE article_id = '".(int)$article_id."' AND language_id='".(int)$this->config->get('config_language_id')."' ORDER BY sort_order ASC");

		return $query->rows;
	}
	/*free download*/	
	public function getFreeDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_download d 
		LEFT JOIN ".DB_PREFIX."ave_download_description dd ON (d.download_id = dd.download_id)  
		WHERE d.download_id = '".(int)$download_id."' AND  dd.language_id = '".(int)$this->config->get('config_language_id')."'");		
		return $query->row;
	} 
	public function getDownloadFile($auth_key){		

		$query=$this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_download nd 
		LEFT JOIN ".DB_PREFIX."ave_download_description ndd ON (nd.download_id = ndd.download_id)				
		WHERE nd.auth_key='". $this->db->escape($auth_key)."' AND  ndd.language_id = '".(int)$this->config->get('config_language_id')."'");
		$return = array();
		if ($query->num_rows) {
			$return = $query->row;		
			$this->db->query("UPDATE ".DB_PREFIX."ave_download SET downloaded = (downloaded + 1) WHERE download_id = '".(int)$query->row['download_id']."'");
		}
		return $return;		
	}
	
	public function getArticlePollId($article_id) {
		$query = $this->db->query("SELECT poll_id FROM ".DB_PREFIX."ave_article WHERE article_id = '".(int)$article_id."'");
		
		if ($query->row['poll_id']) {
				$poll_id = $query->row['poll_id'];
		} else {
				$poll_id = 0;
		}
		return $poll_id;
	}
}
?>