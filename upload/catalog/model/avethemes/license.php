<?php
class ModelAceLicense extends Model {
	
	public function getTheme($theme_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "lg_theme WHERE layout_id = '" . (int)$theme_id . "'");
		return $query->row;
	}
	public function getThemes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "lg_theme";

		$sort_data = array('value');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY value";
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
	public function addRequest($data) {
      	$this->db->query("INSERT INTO ".DB_PREFIX."lg_theme_purchase SET 
		firstname = '" . $this->db->escape($data['firstname']) . "', 
		lastname = '" . $this->db->escape($data['lastname']) . "', 
		email = '" . $this->db->escape($data['email']) . "', 
		telephone = '" . $this->db->escape($data['telephone']) . "', 
		purchase_key = '" . $this->db->escape($data['purchase_key']) . "', 
		purchase_theme = '" . $this->db->escape($data['purchase_theme']) . "', 
		primary_domain = '" . $this->db->escape($data['primary_domain']) . "', 
		status = '0',
		date_added = NOW()");
			
		$this->language->load('ace/license');	
		$subject = $this->language->get('text_subject');		
		$message = $this->language->get('text_dear'). "\n\n";		
		$message .= sprintf($this->language->get('text_opening'), $this->db->escape($data['firstname'].' '.$data['lastname'])) . "\n\n";	
		$message .= $this->language->get('text_details'). "\n\n";		
		
		$message .= sprintf($this->language->get('text_sender'), $this->db->escape($data['firstname'].' '.$data['lastname'])) . "\n\n";	
		if($data['telephone']){$message .= sprintf($this->language->get('text_sender_phone'), $this->db->escape($data['telephone'])) . "\n\n";}	
		$message .= sprintf($this->language->get('text_sender_email'), $this->db->escape($data['email'])) . "\n\n";
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
}
?>