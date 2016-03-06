<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_comment SET author = '" . $this->db->escape($data['author']) . "', article_id = '" . $this->db->escape($data['article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	
		$this->cache->delete('article');
	}
	
	public function editComment($comment_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_comment SET author = '" . $this->db->escape($data['author']) . "', article_id = '" . $this->db->escape($data['article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE comment_id = '" . (int)$comment_id . "'");
	
		$this->cache->delete('article');
	}
	
	public function deleteComment($comment_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_comment WHERE comment_id = '" . (int)$comment_id . "'");
		
		$this->cache->delete('article');
	}
	
	public function getComment($comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM ".DB_PREFIX."ave_article_description pd WHERE pd.article_id = r.article_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS article FROM ".DB_PREFIX."ave_comment r WHERE r.comment_id = '" . (int)$comment_id . "'");
		
		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT r.comment_id, pd.name, r.author, r.rating, r.status, r.date_added FROM ".DB_PREFIX."ave_comment r LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (r.article_id = pd.article_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";																																					  
		
		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY r.date_added";	
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
	
	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment");
		
		return $query->row['total'];
	}
	
	public function getTotalCommentsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
?>