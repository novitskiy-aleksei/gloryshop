<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesSkin extends Model {
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
	public function addSkin($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_theme SET 
		`skin_name` = '" . $this->db->escape($data['skin_name']) . "', 
		`color` = '" . $this->db->escape($data['color']) . "', 
		`status` = '" . (int)$data['status'] . "', 
		`theme_setting` = '" . (isset($data['theme_setting']) ? $this->db->escape(json_encode($data['theme_setting'])) : '') . "' , 
		`date_added` = NOW()");
		return $this->db->getLastId();
	}
	
	public function copySkin($skin_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_theme sk WHERE sk.skin_id = '" . (int)$skin_id . "'");		
		if ($query->num_rows) {
			$data = array();
			$data['skin_name'] = $query->row['skin_name'].'-Duplicate';
			$data['color'] = $query->row['color'];
			$data['status'] = $query->row['status'];
			$data['theme_setting'] = json_decode($query->row['theme_setting']);
			$this->addSkin($data);
		}
	}
	public function updateSkin($skin_id, $data) {
		$skin_info = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		if ($skin_info->num_rows) {
			$theme_setting = json_decode($skin_info->row['theme_setting']);	
			$update_data = $data['theme_setting'];
			foreach ($update_data as $key=>$value){
				$theme_setting[$key] = $value; 
			}
			
			$update_sql ="UPDATE ".DB_PREFIX."ave_theme SET ";
			if(isset($theme_setting)){$update_sql .="`theme_setting` = '" .$this->db->escape(json_encode($theme_setting)). "',";}
			if(isset($data['skin_name'])){$update_sql .="`skin_name` = '" .$this->db->escape($data['skin_name']). "',";}
			if(isset($data['color'])){$update_sql .="`color` = '" .$this->db->escape($data['color']). "',";}
			$update_sql .="`date_modified` = NOW() WHERE `skin_id` = '" . (int)$skin_id . "'";
			$this->db->query($update_sql);
		}//num row
	}
	public function activeSkin($group,$skin_id,$store_id = 0) {
		$skin_info = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
		if ($skin_info->num_rows) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = 'skin_active_id'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($group) . "', `key` = 'skin_active_id', `value` = '" . (int)$skin_id . "'");
		}
	}
	
	public function checkActiveSkin($skin_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."setting WHERE `key` = 'skin_active_id' AND `value` = '" . (int)$skin_id . "'");	
		return $query->row['total'];
	}
	public function deleteSkin($skin_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$skin_id . "'");
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
				'theme_setting' => json_decode($query->row['theme_setting'])
			);
			return $skin;
		}else{
			return false;		
		}
	}
	
	public function getSkins($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."ave_theme";
		
		if (isset($data['sort'])) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY skin_id";	
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
	public function getTotalSkins() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_theme");		
		return $query->row['total'];
	}	
	public function checkSkin($skin_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_theme WHERE  `skin_id` = '" . (int)$skin_id . "'");		
		return $query->row['total'];
	}
	public function exportSkin($data){
		$return = false;
		$skin_info = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_theme WHERE skin_id = '" . (int)$data['skin_id']. "'");
		$output=array();
		if ($skin_info->num_rows) {		
			$output['authentication']	= 	md5(json_encode(array_merge(array($skin_name,$skin_color),array($theme_setting,$setting_len))));			
			$output['skin_name']	=	$skin_name;					
			$output['color']	=	$skin_color;			
			$output['theme_setting']	=	$theme_setting;			
			}
			$return=json_encode($output);
		return $return;
	}
	public function importSkinData($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_theme SET 
		`skin_name` = '" . $this->db->escape($data['skin_name']) . "', 
		`color` = '" . $this->db->escape($data['color']) . "', 
		`status` = '" . (int)$data['status'] . "', 
		`theme_setting` = '" . (isset($data['theme_setting']) ? $this->db->escape($data['theme_setting']) : '') . "' , 
		`date_added` = NOW()");
		return $this->db->getLastId();
	}
}
?>