<?php 
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogblog 
 */
class ModelAvethemesSliderRevolution extends Model { 

	public function checkSlider($primary_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_sliderrevo WHERE  `primary_id` = '" . (int)$primary_id . "'");		
		return $query->row['total'];
	}
	public function addSlider( $data ){
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_sliderrevo SET 
		`title` = '" . $this->db->escape($data['title']) . "', 
		`configs` = '" . $this->db->escape(serialize(isset($data['configs']) ? $data['configs'] :array())) . "'");
		return $this->db->getLastId();	
	}
	public function updateSlider($primary_id, $data ){
		$this->db->query("UPDATE ".DB_PREFIX."ave_sliderrevo SET 
		`title` = '" . $this->db->escape($data['title']) . "', 
		`configs` = '" . $this->db->escape(serialize(isset($data['configs']) ? $data['configs'] :array())) . "' 
		WHERE `primary_id` = '" . (int)$primary_id . "'");		
		 return $primary_id;	
		
	}
	public function cloneLayerGroup($primary_id, $clone_id, $languageID){
		// Get SliderLayer By Group
		$sql = "SELECT * FROM ".DB_PREFIX."ave_sliderrevo_layer WHERE primary_id = "  . $clone_id." AND language_id!=". $languageID;
		$query = $this->db->query( $sql );
		$rows = $query->rows;
		if( !empty($query->rows) ){		
			$this->db->query("DELETE FROM ".DB_PREFIX."ave_sliderrevo_layer WHERE primary_id = "  . $primary_id." AND language_id =". $languageID);
			foreach ($rows as $row) {
				$sql2 = "INSERT INTO ".DB_PREFIX."ave_sliderrevo_layer (title, primary_id, group_setting, layers_data, image, `status`, position, language_id) SELECT title, '" . $primary_id . "', group_setting, layers_data, image, `status`, position, '" . $languageID . "' FROM ".DB_PREFIX."ave_sliderrevo_layer AS sl WHERE sl.layer_group_id=".$row['layer_group_id'];
				$this->db->query( $sql2 );
			}
		}
	}

	public function checkInstall(){
		$queries = array();
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_sliderrevo` (
				`primary_id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`configs` text NOT NULL,
				PRIMARY KEY (`primary_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		";
		$queries[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_sliderrevo_layer` (
				   	  `layer_group_id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `primary_id` int(11) NOT NULL,
					  `group_setting` text NOT NULL,
					  `layers_data` text NOT NULL,
					  `image` varchar(255) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `position` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`layer_group_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		";
		foreach( $queries as $query ){
			$this->db->query($query);
		}
	}
	public function saveLayersData($data){
		
		 if( isset($data['layer_group_id'])&&$data['layer_group_id']!=0){			 
		$query = "UPDATE ".DB_PREFIX."ave_sliderrevo_layer SET 
		`title` = '" . $this->db->escape($data['title']) . "', 
		`primary_id` = '" . (int)$data['primary_id'] . "', 
		`group_setting` = '" . (isset($data['group_setting']) ? $this->db->escape($data['group_setting']) : '') . "',
		`layers_data` = '" . (isset($data['layers_data']) ? $this->db->escape($data['layers_data']) : '') . "',  
		`image` = '" . $this->db->escape($data['image']) . "', 
		`language_id` = '" . (isset($data['language_id']) ? (int)$data['language_id'] : '1') . "', 
		`status` = '" . (int)$data['status']. "' WHERE `layer_group_id`='".$data['layer_group_id']."'";		
			$this->db->query( $query );
			$layer_group_id =   $data['layer_group_id'];
			
		 }else {
			 
		$query = "INSERT INTO ".DB_PREFIX."ave_sliderrevo_layer SET 
		`title` = '" . $this->db->escape($data['title']) . "', 
		`primary_id` = '" . (int)$data['primary_id'] . "', 
		`group_setting` = '" . (isset($data['group_setting']) ? $this->db->escape($data['group_setting']) : '') . "',
		`layers_data` = '" . (isset($data['layers_data']) ? $this->db->escape($data['layers_data']) : '') . "',  
		`image` = '" . $this->db->escape($data['image']) . "', 
		`language_id` = '" . (isset($data['language_id']) ? (int)$data['language_id'] : '1') . "',  
		`status` = '" . (int)$data['status']. "'";	
			$this->db->query( $query );
			$layer_group_id =  $this->db->getLastId();
		 }
		 return $data['layer_group_id'];
	}
	/***/
	public function getTotalSliders() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_sliderrevo");		
		return $query->row['total'];
	}
	public function getSliders($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."ave_sliderrevo";
		
		if (isset($data['sort'])) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY title";	
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
	/***/
	public function getLayerGroup($layer_group_id){
		$query = ' SELECT * FROM '. DB_PREFIX . "ave_sliderrevo_layer   ";
		$query .= ' WHERE layer_group_id='.(int)$layer_group_id;

		$query = $this->db->query( $query );
		$row = $query->row;
 	
	 	return $row;
	}
	/***/
	public function getSlider( $primary_id ){
		
		$return = false;	
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_sliderrevo WHERE primary_id = '" . (int)$primary_id . "'");
		if ($query->num_rows) {
			$slider = array(
				'title'       => $query->row['title'],
				'configs' => unserialize($query->row['configs'])
			);
			$return = $slider;
		}		
		return $return;
	}

	public function deleteLayerGroup( $layer_group_id ){
		$query = ' DELETE FROM '. DB_PREFIX . "ave_sliderrevo_layer  WHERE layer_group_id=".$layer_group_id;
		$this->db->query( $query );
	}
	public function delete( $primary_id ){
		$query = ' DELETE FROM '. DB_PREFIX . "ave_sliderrevo  WHERE primary_id=".$primary_id;
		$this->db->query( $query );
		$query = ' DELETE FROM '. DB_PREFIX . "ave_sliderrevo_layer  WHERE primary_id=".$primary_id;
		$this->db->query( $query );
	}
	public function getAllLayerGroupByPrimaryId($primary_id){
		$query  = ' SELECT * FROM '. DB_PREFIX . "ave_sliderrevo_layer";
		$query .= ' WHERE primary_id='.(int)$primary_id ;

		$query = $this->db->query( $query );
		return $query->rows;
	}
	public function getLayerGroupByPrimaryId($primary_id, $language_id){
		$query  = ' SELECT * FROM '. DB_PREFIX . "ave_sliderrevo_layer";
		$query .= ' WHERE primary_id='.(int)$primary_id .' AND language_id='.(int)$language_id.' ORDER BY position ASC';

		$query = $this->db->query( $query );
		return $query->rows;
	}
	public function resize($filename, $width, $height, $type='') { // die("fds");
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		// $new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;

		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $old_image);
			

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);
			if ($type == 'a') {
			    if ($width/$height > $width_orig/$height_orig) {
			        $image->resize($width, $height, 'w');
			    } elseif ($width/$height < $width_orig/$height_orig) {
			        $image->resize($width, $height, 'h');
			    }
			} else {
			    $image->resize($width, $height, $type);
			}

			$image->save(DIR_IMAGE . $new_image);
		}
	
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_CATALOG . 'image/' . $new_image;
		} else {
			return HTTP_CATALOG . 'image/' . $new_image;
		}	
	}
	public function updatePost($layer_group_id , $position ){
		$sql = 'UPDATE '.DB_PREFIX.'ave_sliderrevo_layer SET `position`='.$position.' WHERE layer_group_id='.($layer_group_id);
		$this->db->query( $sql );
	}
}

?>