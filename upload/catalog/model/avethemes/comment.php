<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesComment extends Model {		
	public function addComment($article_id, $data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_comment SET 
		author = '" . $this->db->escape($data['name']) . "', 
		customer_id = '" . (int)$this->customer->getId() . "', 
		article_id = '" . (int)$article_id . "', 
		text = '" . $this->db->escape($data['text']) . "', 
		status = '" .(int)$this->config->get('ave_cms_comment_approved'). "',
		rating = '" . (int)$data['rating'] . "', date_added = NOW()");
		
		if ($this->config->get('ave_cms_comment_email')==1) {
			
		$this->load->language('avethemes/comment');	
		$title=$this->getArticleTitle($article_id);
		$subject = $this->language->get('text_subject');		
		$message = $this->language->get('text_dear'). "\n\n";		
		$message .= sprintf($this->language->get('text_author'), $this->db->escape($data['name'])) . "\n\n";			
		$message .= sprintf($this->language->get('text_title'), $title, $this->url->link('content/article','article_id='.$article_id)) . "\n\n";		
		$message .= sprintf($this->language->get('text_comment'), $this->db->escape($data['text'])) . "\n\n";	
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
			if ($this->config->get('ave_cms_comment_email_notifications')) {
				$mail->setTo($this->config->get('ave_cms_comment_email_notifications'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
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
	}
	
	public function getCommentsByArticleId($article_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 20;
		}		
		
		$query = $this->db->query("SELECT r.comment_id, r.author, r.rating, r.text, p.article_id, pd.name, p.image, r.date_added FROM ".DB_PREFIX."ave_comment r LEFT JOIN ".DB_PREFIX."ave_article p ON (r.article_id = p.article_id) LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
			
		return $query->rows;
	}
	
	public function getAverageRating($article_id) {
		$query = $this->db->query("SELECT AVG(rating) AS total FROM ".DB_PREFIX."ave_comment WHERE status = '1' AND article_id = '" . (int)$article_id . "' GROUP BY article_id");
		
		if (isset($query->row['total'])) {
			return (int)$query->row['total'];
		} else {
			return 0;
		}
	}	
	
	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment r LEFT JOIN ".DB_PREFIX."ave_article p ON (r.article_id = p.article_id) WHERE p.status = '1' AND r.status = '1'");
		
		return $query->row['total'];
	}

	public function getTotalCommentsByArticleId($article_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_comment r LEFT JOIN ".DB_PREFIX."ave_article p ON (r.article_id = p.article_id) LEFT JOIN ".DB_PREFIX."ave_article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
	private function getArticleTitle($article_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_article_description WHERE article_id = '" . (int)$article_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");			
		return $query->row['name'];		
	}
}
?>