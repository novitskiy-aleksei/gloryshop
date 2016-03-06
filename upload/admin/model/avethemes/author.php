<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesAuthor extends Model {
	public function addAuthor($data) {
      	$this->db->query("INSERT INTO ".DB_PREFIX."ave_author SET
		author = '" . $this->db->escape($data['author']) . "', 		
		competence = '" . $this->db->escape($data['competence']) . "', 		
		`socials` = '" . (isset($data['socials']) ? $this->db->escape(json_encode($data['socials'])) : '') . "', 
		author_description = '" . $this->db->escape($data['author_description']) . "',
		sort_order = '" . (int)$data['sort_order'] . "'");
		
		$author_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_author SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE author_id = '" . (int)$author_id . "'");
		}
		
		if(empty($data['keyword'])){
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['author']);
		}	
				
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		if ($this->config->get('ave_installed')&&isset($data['keyword'])) { 
				$this->load->model('avethemes/keyword');		
				$this->model_avethemes_keyword->updateKeyword('author',$author_id);
		}
		$this->cache->delete('author');
		$this->cache->delete('article');
	}
	
	public function editAuthor($author_id, $data) {
      	$this->db->query("UPDATE ".DB_PREFIX."ave_author SET 
		author = '" . $this->db->escape($data['author']) . "',
		competence = '" . $this->db->escape($data['competence']) . "', 
		`socials` = '" . (isset($data['socials']) ? $this->db->escape(json_encode($data['socials'])) : '') . "', 	
		author_description = '" . $this->db->escape($data['author_description']) . "',
		sort_order = '" . (int)$data['sort_order'] . "' 
		WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_author SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE author_id = '" . (int)$author_id . "'");
		}
		
			
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'author_id=" . (int)$author_id. "'");
		
		if(empty($data['keyword'])){
				$this->load->model('avethemes/keyword');
				$data['keyword'] = $this->model_avethemes_keyword->strip_unicode($data['author']);
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO ".DB_PREFIX."url_alias SET `query` = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		if ($this->config->get('ave_installed')&&isset($data['keyword'])){
			$this->load->model('avethemes/keyword');		
			$this->model_avethemes_keyword->updateKeyword('author',$author_id);
		}
		$this->cache->delete('author');
		$this->cache->delete('article');
	}
	
	public function deleteAuthor($author_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_author WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."url_alias WHERE query = 'author_id=" . (int)$author_id . "'");
			
		$this->cache->delete('author');
	}	
	
	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM ".DB_PREFIX."url_alias WHERE query = 'author_id=" . (int)$author_id . "') AS keyword FROM ".DB_PREFIX."ave_author WHERE author_id = '" . (int)$author_id . "'");
		
		return $query->row;
	}
	
	public function getAuthors($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."ave_author";
		
		$sort_data = array(
			'author',
			'sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY author";	
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
	
	public function getTotalAuthorsByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_author WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalAuthors() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_author");
		
		return $query->row['total'];
	}	
}
?>