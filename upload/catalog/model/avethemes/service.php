<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesService extends Model {
	public static $all_services = array();
	
	public function getAllServices() {
		if (!empty(self::$all_services)) {
			return self::$all_services;
		}
		
		if ($this->config->get('ave_confirm_installed')) {	
			$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description FROM ".DB_PREFIX."ave_service c LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) LEFT JOIN ".DB_PREFIX."ave_service_to_store c2s ON (c.service_id = c2s.service_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
			if ($query->num_rows) {
				return self::$all_services = $query->rows;
			}
		}
	}
		
	public function getServices($parent_id = 0) {
		$all_services = $this->getAllServices();
		$services = array();
		foreach ($all_services as $service) {
			if ($service['parent_id'] == $parent_id) {
				$services[] = $service;
			}
		}
		return $services;
	}
	
	public function getServiceGroup($service_id_group) {
		$return = array();
		$all_services = $this->getAllServices();
		foreach ($service_id_group as $service_id) {
			foreach ($all_services as $service) {
				if ($service['service_id'] == $service_id) {
					$return[] = $service;
				}
			}
		}
		return $return;
	}
	
	public function getService($service_id) {
		$return = array();
		$all_services = $this->getAllServices();
		foreach ($all_services as $service) {
			if ($service['service_id'] == $service_id) {
				$return = $service;
			}
		}
		return $return;
	}
		
	public function getServicesByParentId($service_id) {
		$service_data = array();

		$service_query = $this->db->query("SELECT service_id FROM ".DB_PREFIX."ave_service WHERE parent_id = '" . (int)$service_id . "'");

		foreach ($service_query->rows as $service) {
			$service_data[] = $service['service_id'];

			$children = $this->getServicesByParentId($service['service_id']);

			if ($children) {
				$service_data = array_merge($children, $service_data);
			}			
		}

		return $service_data;
	}
					
	public function getTotalServicesByServiceId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_service c 
		LEFT JOIN ".DB_PREFIX."ave_service_to_store c2s ON (c.service_id = c2s.service_id) 
		WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}
	public function getTotalArticlesByServices($services=array()) {
		$cache = md5(http_build_query($services));
		
		$service_total = $this->cache->get('article.service_total.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache);
		
		if (!$service_total) {		
			$service_total = array();			
			foreach ($services as $service) {
				$service_id = $service['service_id'];
				$total = $this->getTotalArticlesByService(array('filter_service_id'  => $service_id,'filter_sub_service' => true));
				$service_total[$service_id] = array(
					'name'        => $service['name'],
					'total'  	  =>$total,					
				);
			}	
			
			$this->cache->set('article.service_total.'.(int)$this->config->get('config_language_id').'.'.(int)$this->config->get('config_store_id').'.'.$cache, $service_total);
		}
		
		return $service_total;
		
	}
	public function getTotalArticlesByService($data = array()) {
			$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM ".DB_PREFIX."ave_article p 
			LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) 
			LEFT JOIN ".DB_PREFIX."ave_article_to_store p2s ON (p.article_id = p2s.article_id)";
	
			if (!empty($data['filter_service_id'])) {
				$sql .= " LEFT JOIN ".DB_PREFIX."ave_article_to_service p2c ON (p.article_id = p2c.article_id)";			
			}
						
			$sql .= " WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
						
			if (!empty($data['filter_service_id'])) {
				if (!empty($data['filter_sub_service'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_service_id'];
					
					$services = $this->getServicesByParentId($data['filter_service_id']);
										
					foreach ($services as $service_id) {
						$implode_data[] = (int)$service_id;
					}
								
					$sql .= " AND p2c.service_id IN (".implode(', ', $implode_data).")";			
				} else {
					$sql .= " AND p2c.service_id = '".(int)$data['filter_service_id']."'";
				}
			}		
			$query = $this->db->query($sql);
			
		return $query->row['total'];
	}
	
	public function addQuote($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_quote SET 
		customer_name = '" . $this->db->escape($data['name']) . "',
		customer_telephone = '" . $this->db->escape($data['telephone']) . "',
		customer_email = '" . $this->db->escape($data['email']) . "',
		customer_company = '" . $this->db->escape($data['company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		service_selection = '" . $this->db->escape(implode(',',$data['service_selection'])) . "',
		budget = '" .$this->db->escape($data['budget']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		status = '0',
		date_added = NOW()");
			
		$this->load->language('avethemes/quote');	
		$subject = $this->language->get('text_subject');		
		$message = $this->language->get('text_dear'). "\n\n";		
		$message .= sprintf($this->language->get('text_opening'), $this->db->escape($data['name'])) . "\n\n";	
		$message .= $this->language->get('text_details'). "\n\n";		
		
		$message .= sprintf($this->language->get('text_sender'), $this->db->escape($data['name'])) . "\n\n";	
		if($data['telephone']){$message .= sprintf($this->language->get('text_sender_phone'), $this->db->escape($data['telephone'])) . "\n\n";}	
		$message .= sprintf($this->language->get('text_sender_email'), $this->db->escape($data['email'])) . "\n\n";			
		$message .= sprintf($this->language->get('text_sender_enquiry'), $this->db->escape($data['message'])) . "\n\n";	
		$message .= $this->language->get('text_thanks') . "\n";
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');	
				
			// Send to main admin email if new account email is enabled
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(strip_tags(html_entity_decode($message, ENT_QUOTES, 'UTF-8')));
				$mail->send();
				// Send to additional alert emails if new account email is enabled
				$emails = explode(',', $this->config->get('config_alert_emails'));
				
				foreach ($emails as $email) {
					if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
	}
	
	public function addTestimonial($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_testimonial SET 
		customer_name = '" . $this->db->escape($data['name']) . "',
		customer_telephone = '" . $this->db->escape($data['telephone']) . "',
		customer_email = '" . $this->db->escape($data['email']) . "',
		customer_company = '" . $this->db->escape($data['company']) . "',
		service_selection = '" . $this->db->escape(implode(',',$data['service_selection'])) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		rating = '" . (int)$data['rating'] . "',
		date_added = NOW()");	
		
		$testimonial_id = $this->db->getLastId();

		if (isset($data['avatar'])) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_testimonial SET avatar = '" . $this->db->escape(html_entity_decode($data['avatar'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}
		if (isset($data['service_selection'])) {
			foreach ($data['service_selection'] as $service_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_testimonial_service SET testimonial_id = '" . (int)$testimonial_id . "', service_id = '" . (int)$service_id . "'");
			}
		}
		
			
		$this->load->language('avethemes/testimonial');	
		$subject = $this->language->get('text_subject');		
		$message = $this->language->get('text_dear'). "\n\n";		
		$message .= sprintf($this->language->get('text_opening'), $this->db->escape($data['name'])) . "\n\n";	
		$message .= $this->language->get('text_details'). "\n\n";		
		
		$message .= sprintf($this->language->get('text_sender'), $this->db->escape($data['name'])) . "\n\n";	
		if($data['telephone']){$message .= sprintf($this->language->get('text_sender_phone'), $this->db->escape($data['telephone'])) . "\n\n";}	
		$message .= sprintf($this->language->get('text_sender_email'), $this->db->escape($data['email'])) . "\n\n";			
		$message .= sprintf($this->language->get('text_sender_enquiry'), $this->db->escape($data['message'])) . "\n\n";	
		$message .= $this->language->get('text_thanks') . "\n";
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');	
			//$this->log->write(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));		
			// Send to main admin email if new account email is enabled
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(strip_tags(html_entity_decode($message, ENT_QUOTES, 'UTF-8')));
				$mail->send();
				
				// Send to additional alert emails if new account email is enabled
				$emails = explode(',', $this->config->get('config_alert_emails'));
				
				foreach ($emails as $email) {
					if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
	}
	
}
?>