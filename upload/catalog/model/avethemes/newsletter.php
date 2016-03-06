<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesNewsletter extends Model {
	  
	public function checkRegisteredUser($data) {  	   
	   $query=$this->db->query("SELECT * FROM ".DB_PREFIX."customer WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
	   return $query->num_rows;
	}
	
	public function UpdateRegisterUsers($data,$status) {
  	   
	   $query=$this->db->query("UPDATE  ".DB_PREFIX."customer SET newsletter ='".$status."' WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");

	}
	public function checkmail_exist($data) {  	   
	  $query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_newsletter 
	  WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
	  return $query->num_rows;
	}
	public function checkmail_subscribe($data) {  	   
	  $query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_newsletter 
	  WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."' AND subscribed=1");
	  return $query->num_rows;
	}
	public function checkmail_unsubscribe($data) {  	   
	  $query=$this->db->query("SELECT * FROM ".DB_PREFIX."ave_newsletter 
	  WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."' AND subscribed=0");
	  return $query->num_rows;
	}
	  
	public function update_unsubscribe($data) {  
	  $this->db->query("UPDATE  ".DB_PREFIX."ave_newsletter SET subscribed=1 WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
	}
	
	
	public function subscribe($data) {
		if (isset($data['subscribe_name'])) {
				$subscribe_name = $data['subscribe_name'];
			} else {
				$subscribe_name = '';
		}
	$this->db->query("INSERT INTO ".DB_PREFIX."ave_newsletter 
				SET store_id='".$this->config->get('config_store_id')."',
				email='".$data['subscribe_email']."',
				subscribed=1,
				firstname='".$subscribe_name."'");
	}
	public function unsubscribe($data) {		
	$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter SET subscribed =0 WHERE email='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
	}
}
?>
