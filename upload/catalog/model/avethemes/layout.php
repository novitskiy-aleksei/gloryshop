<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesLayout extends Model {
	public function getInstalled($type) {
		$extension_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

		foreach ($query->rows as $result) {
			$extension_data[] = $result['code'];
		}

		return $extension_data;
	}
	
	public static $all_modules = array();	
	public function getAllModules() {
		if (!empty(self::$all_modules)) {
			return self::$all_modules;
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module ORDER BY `name`");
		return self::$all_modules = $query->rows;
	}
	public function getModule($module_id) {
		$all_modules = $this->getAllModules();
		$return = false;
		foreach ($all_modules as $module) {
			if ($module_id == $module['module_id']) {
				$module_info[$module_id] = $this->ave->decodeSetting($module['setting']);
				$return = $module_info[$module_id];
			}
		}
		return $return;
	}
	public function deleteModule($module_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . (int)$module_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '%." . (int)$module_id . "'");
	}
	
	public function getModulesByCode($code) {
		$all_modules = $this->getAllModules();
		$return = array();
		foreach ($all_modules as $module) {
			if ($code == $module['code']) {
				$return[] = $module;
			}
		}
		return $return;
		/*
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "' ORDER BY `name`");

		return $query->rows;*/ 
	}	
	public function addLayout($data) {
		$this->event->trigger('pre.admin.layout.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = '" . $this->db->escape($data['name']) . "'");

		$layout_id = $this->db->getLastId();

		if (isset($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$layout_route['store_id'] . "', route = '" . $this->db->escape($layout_route['route']) . "'");
			}
		}
		
		if (isset($data['layout_module'])) {
			foreach ($data['layout_module'] as $layout_module) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
			}
		}
		
		$this->event->trigger('post.admin.layout.add', $layout_id);

		return $layout_id;
	}

	public function editLayout($layout_id, $data) {
		$this->event->trigger('pre.admin.layout.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "layout SET name = '" . $this->db->escape($data['name']) . "' WHERE layout_id = '" . (int)$layout_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");

		if (isset($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$layout_route['store_id'] . "', route = '" . $this->db->escape($layout_route['route']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "'");
		
		if (isset($data['layout_module'])) {
			foreach ($data['layout_module'] as $layout_module) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
			}
		}
		
		$this->event->trigger('post.admin.layout.edit', $layout_id);
	}
	public function editLayoutModule($layout_id, $data) {
		$this->event->trigger('pre.admin.layout.edit', $data);
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "'");		
		if (isset($data['layout_module'])) {
			foreach ($data['layout_module'] as $layout_module) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
			}
		}
		
		$this->event->trigger('post.admin.layout.edit', $layout_id);
	}

	public function deleteLayout($layout_id) {
		$this->event->trigger('pre.admin.layout.delete', $layout_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$layout_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		$this->event->trigger('post.admin.layout.delete', $layout_id);
	}

	public function getLayout($layout_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row;
	}
	public function getLayouts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "layout";

		$sort_data = array('name');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getLayoutRoutes($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->rows;
	}
	
	public function getLayoutModules($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	
	public function getTotalLayouts() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "layout");

		return $query->row['total'];
	}
}