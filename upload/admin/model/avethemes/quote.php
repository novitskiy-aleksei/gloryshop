<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesQuote extends Model {

	public function addQuote($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_quote SET 
		customer_name = '" . $this->db->escape($data['customer_name']) . "',
		customer_telephone = '" . $this->db->escape($data['customer_telephone']) . "',
		customer_email = '" . $this->db->escape($data['customer_email']) . "',
		customer_company = '" . $this->db->escape($data['customer_company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		`service_selection` = '" . (isset($data['service_selection']) ? $this->db->escape(implode(',',$data['service_selection'])) : '') . "', 
		budget = '" .$this->db->escape($data['budget']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		`read` = '" . (int)$data['read'] . "',
		status = '" . (int)$data['status'] . "',
		date_added = NOW()");	
	}
	
	public function setRead($quote_id) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_service_quote SET `read` = '1' WHERE quote_id = '" . (int)$quote_id . "'");	
	}
	
	public function editQuote($quote_id,$data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_service_quote SET 
		customer_name = '" . $this->db->escape($data['customer_name']) . "',
		customer_telephone = '" . $this->db->escape($data['customer_telephone']) . "',
		customer_email = '" . $this->db->escape($data['customer_email']) . "',
		customer_company = '" . $this->db->escape($data['customer_company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		`service_selection` = '" . (isset($data['service_selection']) ? $this->db->escape(implode(',',$data['service_selection'])) : '') . "', 
		budget = '" .$this->db->escape($data['budget']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		`read` = '" . (int)$data['read'] . "',
		status = '" . (int)$data['status'] . "',
		date_added = NOW() WHERE quote_id = '" . (int)$quote_id . "'");		
	}
	
	public function deleteQuote($quote_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_quote WHERE quote_id = '" . (int)$quote_id . "'");	
	}
	
	public function getQuote($quote_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service_quote r WHERE r.quote_id = '" . (int)$quote_id . "'");
		
		return $query->row;
	}

	public function getQuotes($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."ave_service_quote r WHERE 1=1";																																			  
		
		$sort_data = array(
			'r.customer_name',
			'r.read',
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
	
	public function getTotalQuotes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_service_quote");
		
		return $query->row['total'];
	}
	
	public function getTotalQuotesAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_service_quote WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
?>