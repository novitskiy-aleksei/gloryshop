<?php
class ControllerAvethemesContact extends Controller {
	private $error = array();
	public function index() {
	}
	public function popup_contact() {
			$json = array();
		$this->load->language('avethemes/contact');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
				if($this->validate_popup()){
					$this->addContact($this->request->post); 
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->request->post['email']);
					$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
					$mail->setText($this->request->post['enquiry']);
					$mail->send();
					$json['success'] = $this->language->get('text_success');
				}else{
					if (isset($this->error['captcha'])) {
						$json['error'] = $this->error['captcha'];
					}
					if (isset($this->error['enquiry'])) {
						$json['error'] = $this->error['enquiry'];
					}
					if (isset($this->error['email'])) {
						$json['error'] = $this->error['email'];
					}
					if (isset($this->error['name'])) {
						$json['error'] = $this->error['name'];
					} 
			}
			
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	private function addContact($pdata) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_contact SET name = '" . $this->db->escape($pdata['name']) . "', email = '" . $this->db->escape($pdata['email']) . "', enquiry = '" . $this->db->escape(strip_tags($pdata['enquiry'])) . "', status = '0', date_added = NOW()");

	}
	
	protected function validate_popup() {
		if(!$this->config->get('contact_manager_installed')){
			$query = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_contact` (
					`contact_id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(54) NOT NULL,
					`email` varchar(64) NOT NULL,
					`enquiry` text NOT NULL,
					`status` tinyint(1) NOT NULL,
					`date_added` datetime NOT NULL,
					PRIMARY KEY (`contact_id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
			";
			$this->db->query($query);
			$this->db->query("INSERT INTO `" . DB_PREFIX. "setting` SET `key` = 'contact_manager_installed',`value` = '1'");
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {	
			$this->error['captcha'] = $this->language->get('error_captcha');	
		}

		return !$this->error;
	}
	public function captcha() {
		$this->session->data['captcha'] = substr(sha1(mt_rand()), 17, 4);
		$image = imagecreatetruecolor(60, 30);
		$width = imagesx($image);
		$height = imagesy($image);
		$black = imagecolorallocate($image, 0, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);
		$red = imagecolorallocatealpha($image, 255, 0, 0, 75);
		$green = imagecolorallocatealpha($image, 0, 255, 0, 75);
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75);
		imagefilledrectangle($image, 0, 0, $width, $height, $white);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);
		imagefilledrectangle($image, 0, 0, $width, 0, $black);
		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
		imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);
		imagestring($image, 10, intval(($width - (strlen($this->session->data['captcha']) * 9)) / 2), intval(($height - 15) / 2), $this->session->data['captcha'], $black);
		header('Content-type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
}