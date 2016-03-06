<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesSkin extends Model {	
/************************************************************/ 
	public function getSkins($data = array()) {
		$return = array();
		$sql = "SELECT skin_id,skin_name,color FROM ".DB_PREFIX."ave_theme ORDER BY skin_id ASC";
		$query = $this->db->query($sql);
		if($query->num_rows) {
			 foreach($query->rows as $skin){
				 $return[] = array(
				 'skin_id' => $skin['skin_id'],
				 'skin_name' => $skin['skin_name'],
				 'color' => $skin['color'],
				 'href' => $this->url->link('common/home','skin_id='.$skin['skin_id'])
				 );
			 }
		}
		return $return;
	}
	
	public function getTotalSkins() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_theme");		
		return $query->row['total'];
	}
	public function getSkin($skin_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		if ($query->num_rows) {
			$skin = array(
				'skin_id'       => $query->row['skin_id'],
				'skin_name'       => $query->row['skin_name'],
				'color'       => $query->row['color'],
				'status'       => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'       => $query->row['date_modified'],
				'theme_setting' => json_decode($query->row['theme_setting'],true)
			);
			return $skin;
		}else{
			return false;		
		}
	}
	/*addSkin*/ 
	public function addSkin($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_theme SET 
		`skin_name` = '" . $this->db->escape($data['skin_name']) . "', 
		`color` = '" . $this->db->escape($data['color']) . "', 
		`status` = '" . (int)$data['status'] . "', 
		`theme_setting` = '" . (isset($data['theme_setting']) ? $this->db->escape(json_encode($data['theme_setting'])) : '') . "' , 
		`date_added` = NOW()");
		return $this->db->getLastId();
	}
	/*updateSkin*/ 
	public function updateSkin($skin_id, $data) {
		$skin_info = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		if ($skin_info->num_rows) {
			$theme_setting = json_decode($skin_info->row['theme_setting'],true);	
			$update_data = $data['theme_setting'];
			foreach ($update_data as $key=>$value){
				$theme_setting[$key] = $value; 
			}
			$update_sql ="UPDATE ".DB_PREFIX."ave_theme SET ";
			if(isset($theme_setting)){$update_sql .="`theme_setting` = '" .$this->db->escape(json_encode($theme_setting)). "',";}
			if(isset($data['skin_name'])){$update_sql .="`skin_name` = '" .$this->db->escape($data['skin_name']). "',";}
			if(isset($data['color'])){$update_sql .="`color` = '" .$this->db->escape($theme_setting['skin_color']). "',";}
			$update_sql .="`date_modified` = NOW() WHERE `skin_id` = '" . (int)$skin_id . "'";
			$this->db->query($update_sql);
		}//num row
	}
	/*activeSkin*/ 
	public function activeSkin($skin_id,$store_id = 0) {
		$skin_info = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		if ($skin_info->num_rows) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = 'skin_active_id'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = 'skin', `key` = 'skin_active_id', `value` = '" . (int)$skin_id . "'");
		}
	}
	/*deleteSkin*/ 
	public function deleteSkin($skin_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."setting WHERE `key`='skin_active_id' AND `value` = '" . (int)$skin_id . "'");
	}
	/*editSetting*/ 
	public function editSetting($group, $data, $store_id = 0) {
		foreach ($data as $key => $value) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
			// Make sure only keys belonging to this group are used
			if (substr($key, 0, strlen($group)) == $group) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($this->ave->encodeSetting($value)) . "', serialized = '1'");
				}
			}
		}
	}
	/*editSetting*/ 
}
?>