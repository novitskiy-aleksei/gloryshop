<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesAuthor extends Model {
	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_author WHERE author_id = '" . (int)$author_id . "'");
	
		return $query->row;	
	}
	
	public function getAuthors($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM ".DB_PREFIX."ave_author ";
			
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
		} else {
			$author_data = $this->cache->get('author.' . (int)$this->config->get('config_store_id'));
		
			if (!$author_data) {
				$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_author ORDER BY author");
	
				$author_data = $query->rows;
			
				$this->cache->set('author.' . (int)$this->config->get('config_store_id'), $author_data);
			}
		 
			return $author_data;
		}	
	} 
}
?>