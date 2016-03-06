<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesService extends Model {
	public static $all_services = array();
	public function getAllServices() {
		if (!empty(self::$all_services)) {
			return self::$all_services;
		}
		$query = $this->db->query("SELECT * FROM ( SELECT c.*, cd.name AS name, cd.description AS description FROM ".DB_PREFIX."ave_service c LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) LEFT JOIN ".DB_PREFIX."ave_service_to_store c2s ON (c.service_id = c2s.service_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ) AS R ORDER BY R.sort_order, LCASE(R.name)");
		return self::$all_services = $query->rows;
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
	
	public function addService($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."ave_service SET 
		parent_id = '" . (int)$data['parent_id'] . "', 
		link_id = '" . (int)$data['link_id'] . "', 
		`icon` = '".$this->db->escape($data['icon'])."', 
		`color` = '".$this->db->escape($data['color'])."', 
		sort_order = '" . (int)$data['sort_order'] . "', 
		status = '" . (int)$data['status'] . "', 
		date_modified = NOW(), date_added = NOW()");
	
		$service_id = $this->db->getLastId();
		
		foreach ($data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_description SET service_id = '" . (int)$service_id . "', 
			language_id = '" . (int)$language_id . "',
			 name = '" . $this->db->escape($value['name']) . "',
			 description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$lang_id=$this->config->get('config_language_id');
		
				$this->load->model('avethemes/keyword');
		$section= $this->model_avethemes_keyword->strip_unicode($data['service_description'][$lang_id]['name']);
		if (!empty($section)) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_service SET `section` = '".$this->db->escape($section)."' WHERE service_id = '" . (int)$service_id . "'");
		}
		
		if (isset($data['service_store'])) {
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->cache->delete('service_group');

	}
	
	public function editService($service_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_service SET 
		parent_id = '" . (int)$data['parent_id'] . "', 
		link_id = '" . (int)$data['link_id'] . "', 
		`icon` = '".$this->db->escape($data['icon'])."', 
		`color` = '".$this->db->escape($data['color'])."', 
		sort_order = '" . (int)$data['sort_order'] . "', 
		status = '" . (int)$data['status'] . "', 
		date_modified = NOW() WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_description WHERE service_id = '" . (int)$service_id . "'");

		foreach ($data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_description SET service_id = '" . (int)$service_id . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "',
			description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$lang_id=$this->config->get('config_language_id');
		
		$this->load->model('avethemes/keyword');
		$section= $this->model_avethemes_keyword->strip_unicode($data['service_description'][$lang_id]['name']);
		if (!empty($section)) {
			$this->db->query("UPDATE ".DB_PREFIX."ave_service SET `section` = '".$this->db->escape($section)."' WHERE service_id = '" . (int)$service_id . "'");
		}
		
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_to_store WHERE service_id = '" . (int)$service_id . "'");
		
		if (isset($data['service_store'])) {		
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."ave_service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}			
		$this->cache->delete('service_group');

	}
	
	public function deleteService($service_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_description WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_service_to_store WHERE service_id = '" . (int)$service_id . "'");
		
		$query = $this->db->query("SELECT service_id FROM ".DB_PREFIX."ave_service WHERE parent_id = '" . (int)$service_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteService($result['service_id']);
		}		
		$this->cache->delete('service_group');

	} 

	public function getService($service_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_service c 
		LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) 
		WHERE c.service_id = '" . (int)$service_id . "'");
		
		return $query->row;
	} 
	public function getServiceInfo($service_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_service c 
		LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) 
		WHERE c.service_id = '" . (int)$service_id . "'");		
		return $query->row;
	} 
	public function getServices($parent_id = 0) {
		$this->load->model('avethemes/article');
			$service_data = array();
		
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service c 
			LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) 
			WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$total = $this->model_avethemes_article->getTotalArticles(array('filter_service_group'  => $result['service_id']));
				$service_data[] = array(
					'service_id' => $result['service_id'],
					'total'  	  =>' (' . $total . ')',
					'parent_id' => $result['parent_id'],
					'link_id' => $result['link_id'],
					'icon' => $result['icon'],
					'name'        => $this->getPath($result['service_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
				$service_data = array_merge($service_data, $this->getServices($result['service_id']));
			}	
	
		
		return $service_data;
	}
	
	public function filterServices($data) {
		$this->load->model('avethemes/article');
		
			$sql = "SELECT * FROM ".DB_PREFIX."ave_service c 
			LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) 
			WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (!empty($data['parent_id'])) {
				$sql .= " AND c.parent_id = '" . (int)$data['parent_id'] . "'";
			}
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}
			$sql .= " ORDER BY c.sort_order ASC";
			
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
		
			$service_data = array();
			foreach ($query->rows as $result) {
				$total = $this->model_avethemes_article->getTotalArticles(array('filter_service_group'  => $result['service_id']));
				$service_data[] = array(
					'service_id' => $result['service_id'],
					'total'  	  =>' (' . $total . ')',	
					'parent_id' => $result['parent_id'],
					'icon' => $result['icon'],
					'link_id' => $result['link_id'],
					'name'        => $this->getPath($result['service_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			}	
	
		
		return $service_data;
	}	
	public function getPath($service_id) {
		$query = $this->db->query("SELECT name, parent_id FROM ".DB_PREFIX."ave_service c LEFT JOIN ".DB_PREFIX."ave_service_description cd ON (c.service_id = cd.service_id) WHERE c.service_id = '" . (int)$service_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . ' &raquo; ' . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}
		
	public function getServiceDescriptions($service_id) {
		$service_description_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service_description WHERE service_id = '" . (int)$service_id . "'");
		
		foreach ($query->rows as $result) {
			$service_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description']
			);
		}
		
		return $service_description_data;
	}	
	
	public function getServiceStores($service_id) {
		$service_store_data = array();
		
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_service_to_store WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows as $result) {
			$service_store_data[] = $result['store_id'];
		}
		
		return $service_store_data;
	}
		
	public function getTotalServices() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_service");		
		return $query->row['total'];
	}		
}
?>