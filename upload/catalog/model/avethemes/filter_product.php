<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesFilterProduct extends Model {
	private $ave_product_filter_setting;

	public function __construct($registry) {
		parent::__construct($registry);

		$this->ave_product_filter_setting = $this->config->get('ave_product_filter_setting');
		
	}
	public function getAttributesByCategoryId($category_id) {
		$sql = "SELECT DISTINCT pa.text, a.`attribute_id`, ad.`name`, ag.attribute_group_id, agd.name as attribute_group_name FROM `" . DB_PREFIX . "product_attribute` pa" .
			   " LEFT JOIN " . DB_PREFIX . "attribute a ON(pa.attribute_id=a.`attribute_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "attribute_description ad ON(a.attribute_id=ad.`attribute_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "attribute_group ag ON(ag.attribute_group_id=a.`attribute_group_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON(agd.attribute_group_id=ag.`attribute_group_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "product p ON(p.product_id=pa.`product_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id=p2c.product_id) " .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id=p2s.product_id) " .
			   " WHERE p2c.category_id = '" . (int)$category_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id =" . (int)$this->config->get('config_store_id') .
			   " AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "'" .
			   " AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'" .
			   " AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "'" .
			   " ORDER BY ag.sort_order, agd.name, a.sort_order, ad.name, pa.text";

		$query = $this->db->query($sql);

		$attributes = array();
		foreach($query->rows as $row) {
			if(!isset($attributes[$row['attribute_group_id']])) {
				$attributes[$row['attribute_group_id']] = array(
					'name' => $row['attribute_group_name'],
					'attribute_values' => array()
				);
			}

			if(!isset($attributes[$row['attribute_group_id']]['attribute_values'][$row['attribute_id']])) {
				$attributes[$row['attribute_group_id']]['attribute_values'][$row['attribute_id']] = array('name' => $row['name'], 'values' => array());
			}
			$attributes[$row['attribute_group_id']]['attribute_values'][$row['attribute_id']]['values'][] = $row['text'];
		}

		return $attributes;
	}

	public function getManufacturersByCategoryId($category_id) {
		$sql = "SELECT DISTINCT m.`manufacturer_id`, m.`name` FROM `" . DB_PREFIX . "manufacturer` m" .
			   " LEFT JOIN " . DB_PREFIX . "product p ON(p.manufacturer_id=m.`manufacturer_id`) " .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id=p2c.product_id) " .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id=p2s.product_id) " .
			   " WHERE p2c.category_id = '" . (int)$category_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id =" . (int)$this->config->get('config_store_id') .
			   " ORDER BY m.sort_order, m.name";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getOptionsByCategoryId($category_id) {
		$sql = "SELECT DISTINCT ovd.option_value_id, ovd.*, od.name as 'option_name' FROM `" . DB_PREFIX . "option_value_description` ovd
    LEFT JOIN " . DB_PREFIX . "option_value ov ON(ovd.option_value_id=ov.option_value_id)
    LEFT JOIN " . DB_PREFIX . "option_description od ON(ov.option_id=od.option_id)
    LEFT JOIN " . DB_PREFIX . "product_option_value pov ON(ovd.`option_value_id`=pov.`option_value_id`)
    LEFT JOIN " . DB_PREFIX . "product p ON(pov.product_id = p.product_id)
    LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id)
	LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id=p2s.product_id)
	WHERE category_id = '" . (int)$category_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id =" . (int)$this->config->get('config_store_id') .
			   " ORDER BY ovd.option_id, ov.sort_order";
		$query = $this->db->query($sql);
		$options = array();
		foreach($query->rows as $row) {
			if(!isset($options[$row['option_id']])) {
				$options[$row['option_id']] = array('option_id' => $row['option_id'],
													'name' => $row['option_name'],
													'option_values' => array());
			}

			$options[$row['option_id']]['option_values'][] = array('option_value_id' => $row['option_value_id'], 'name' => $row['name']);
		}
		return $options;
	}

	public function getPriceLimits($data) {

		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT max(coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   "p.price) ) AS pmax, min(coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   "p.price) ) AS pmin FROM " . DB_PREFIX . "product p" .
			   " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";

		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];
		$sql .= " AND p.status = '1' AND p.date_available <= NOW( ) AND p2s.store_id = " . (int)$this->config->get('config_store_id');
		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getTotalProducts($data) {

		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT count(*) as total FROM " .
			   "(SELECT DISTINCT p.product_id, coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   " p.price) as realprice " .
			   " FROM " . DB_PREFIX . "product p" .
			   " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
		if($data['attribute_value']) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute p2a ON (p2a.product_id=p.product_id)";
		}

		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];

		$option_filters = array();
		if($data['option_value']) {
			foreach($data['option_value'] as $option_value) {
				$option_filters[] = "option_value_id IN(" . implode(",", $option_value) . ")";
			}
		}

		if($option_filters) {
			if($this->ave_product_filter_setting['option_mode'] == 'and') {
				foreach($option_filters as $i => $option_filter) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_option_value pov" . $i . " WHERE pov" . $i . ".product_id=pov.product_id AND pov" . $i . "." . $option_filter . ") ";
				}
			} else {
				$sql .= " AND (" . implode(" OR ", $option_filters) . ")";
			}
		}

		if($data['manufacturer']) {
			$sql .= " AND p.manufacturer_id IN(" . implode(", ", $data['manufacturer']) . ")";
		}

		if($data['attribute_value']) {
			if($this->ave_product_filter_setting['attribute_mode'] == 'and') {
				$i = 0;
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_attribute p2a" . $i . " WHERE p2a" . $i . ".product_id=p2a.product_id AND p2a" . $i . ".attribute_id = " . (int)$attribute_id . " AND p2a" . $i . ".text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')) ";
					$i++;
				}
			} else {
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$attribute_filters[] = "p2a.attribute_id = " . (int)$attribute_id . " AND p2a.text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')";
				}
				$sql .= " AND (" . implode(" OR ", $attribute_filters) . ")";
			}
		}

		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price >=" . (int)$pmin;
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price <=" . (int)round($pmax);
		}

		$sql .= " AND p.status = '1' AND p.date_available <= NOW( ) AND p2s.store_id = " . (int)$this->config->get('config_store_id');
		$sql .= ") as innertable WHERE 1 ";
		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice >=" . (int)$pmin;
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice <=" . (int)round($pmax);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	private function getCustomerGroup() {
		if($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
			return $customer_group_id;
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
			return $customer_group_id;
		}
	}

	public function getTotalManufacturers($data) {

		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT count(*) as total, manufacturer_id FROM " .
			   "(SELECT DISTINCT p.product_id, m.manufacturer_id, coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   "p.price) as realprice " .
			   " FROM " . DB_PREFIX . "product p" .
			   " LEFT JOIN " . DB_PREFIX . "manufacturer m ON(m.manufacturer_id=p.manufacturer_id) " .
			   " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute p2a ON (p2a.product_id=p.product_id)";
		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];

		$option_filters = array();
		if($data['option_value']) {
			foreach($data['option_value'] as $option_value) {
				$option_filters[] = "option_value_id IN(" . implode(",", $option_value) . ")";
			}
		}

		if($option_filters) {
			if($this->ave_product_filter_setting['option_mode'] == 'and') {
				foreach($option_filters as $i => $option_filter) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_option_value pov" . $i . " WHERE pov" . $i . ".product_id=pov.product_id AND pov" . $i . "." . $option_filter . ") ";
				}
			} else {
				$sql .= " AND (" . implode(" OR ", $option_filters) . ")";
			}
		}


		if($data['attribute_value']) {
			if($this->ave_product_filter_setting['attribute_mode'] == 'and') {
				$i = 0;
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_attribute p2a" . $i . " WHERE p2a" . $i . ".product_id=p2a.product_id AND p2a" . $i . ".attribute_id = " . (int)$attribute_id . " AND p2a" . $i . ".text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')) ";
					$i++;
				}
			} else {
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$attribute_filters[] = "p2a.attribute_id = " . (int)$attribute_id . " AND p2a.text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')";
				}
				$sql .= " AND (" . implode(" OR ", $attribute_filters) . ")";
			}
		}

		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price >=" . (int)$pmin;
		}

		$sql .= " AND p.status = '1' AND p.date_available <= NOW( ) AND p2s.store_id = " . (int)$this->config->get('config_store_id');
		$sql .= ") as innertable WHERE 1 ";
		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice >=" . (int)$pmin;
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice <=" . (int)round($pmax);
		}

		$sql .= " GROUP BY " . "manufacturer_id";
		$query = $this->db->query($sql);

		$result = array();
		foreach($query->rows as $row) {
			$result[] = array('id' => $row['manufacturer_id'], 't' => $row['total']);
		}
		return $result;
	}

	public function getTotalAttributes($data) {

		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT count(*) as total, attribute_id, text  FROM " .
			   "(SELECT DISTINCT p.product_id, p2a.attribute_id, p2a.text, coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   "p.price) as realprice " .
			   " FROM " . DB_PREFIX . "product p" .
			   " LEFT JOIN " . DB_PREFIX . "manufacturer m ON(m.manufacturer_id=p.manufacturer_id) " .
			   " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute p2a ON (p2a.product_id=p.product_id)";
		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];

		if($data['manufacturer']) {
			$sql .= " AND p.manufacturer_id IN(" . implode(", ", $data['manufacturer']) . ")";
		}

		$option_filters = array();
		if($data['option_value']) {
			foreach($data['option_value'] as $option_value) {
				$option_filters[] = "option_value_id IN(" . implode(",", $option_value) . ")";
			}
		}

		if($option_filters) {
			if($this->ave_product_filter_setting['option_mode'] == 'and') {
				foreach($option_filters as $i => $option_filter) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_option_value pov" . $i . " WHERE pov" . $i . ".product_id=pov.product_id AND pov" . $i . "." . $option_filter . ") ";
				}
			} else {
				$sql .= " AND (" . implode(" OR ", $option_filters) . ")";
			}
		}


		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price >=" . (int)$pmin;
		}

		$sql .= " AND p.status = '1' AND p.date_available <= NOW( ) AND p2a.language_id='" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = " . (int)$this->config->get('config_store_id');
		$sql .= ") as innertable WHERE 1 ";
		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice >=" . (int)$pmin;
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice <=" . (int)round($pmax);
		}

		$sql .= " GROUP BY " . "attribute_id, text";
		$query = $this->db->query($sql);

		$result = array();
		foreach($query->rows as $row) {
			$result[] = array('id' => $row['attribute_id'], 'text'=>$row['text'], 't' => $row['total']);
		}
		return $result;
	}

	public function getTotalOptions($data) {

		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT count(*) as total, option_value_id FROM " .
			   "(SELECT DISTINCT p.product_id, pov.option_value_id, coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
			   "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
			   "p.price) as realprice " .
			   " FROM " . DB_PREFIX . "product p" .
			   " LEFT JOIN " . DB_PREFIX . "manufacturer m ON(m.manufacturer_id=p.manufacturer_id) " .
			   " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
			   " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute p2a ON (p2a.product_id=p.product_id)";
		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];


		if($data['manufacturer']) {
			$sql .= " AND p.manufacturer_id IN(" . implode(", ", $data['manufacturer']) . ")";
		}


		if($data['attribute_value']) {
			if($this->ave_product_filter_setting['attribute_mode'] == 'and') {
				$i = 0;
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_attribute p2a" . $i . " WHERE p2a" . $i . ".product_id=p2a.product_id AND p2a" . $i . ".attribute_id = " . (int)$attribute_id . " AND p2a" . $i . ".text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')) ";
					$i++;
				}
			} else {
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$attribute_filters[] = "p2a.attribute_id = " . (int)$attribute_id . " AND p2a.text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')";
				}
				$sql .= " AND (" . implode(" OR ", $attribute_filters) . ")";
			}
		}

		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price >=" . (int)$pmin;
		}

		$sql .= " AND p.status = '1' AND p.date_available <= NOW( ) AND p2s.store_id = " . (int)$this->config->get('config_store_id');
		$sql .= ") as innertable WHERE 1 ";
		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice >=" . (int)$pmin;
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice <=" . (int)round($pmax);
		}

		$sql .= " GROUP BY " . "option_value_id";
		$query = $this->db->query($sql);

		$result = array();
		foreach($query->rows as $row) {
			$result[] = array('id' => $row['option_value_id'], 't' => $row['total']);
		}

		return $result;
	}

	public function getProducts($data) {
		$customer_group_id = $this->getCustomerGroup();

		$sql = "SELECT product_id FROM(";
		$sql .= "SELECT DISTINCT p.product_id, pd.name, p.model, p.quantity, p.price, p.sort_order, p.date_added ";
		$sql .= ", coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1), " .
				"(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), " .
				"p.price) as realprice ";
		$sql .= "FROM " . DB_PREFIX . "product p" .
				" LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)" .
				" LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id=p.product_id)" .
				" LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p2s.product_id=p.product_id)" .
				" LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
		if($data['attribute_value']) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute p2a ON (p2a.product_id=p.product_id)";
		}

		$sql .= " WHERE p2c.category_id = " . (int)$data['category_id'];

		$option_filters = array();
		if($data['option_value']) {
			foreach($data['option_value'] as $option_value) {
				$option_filters[] = "option_value_id IN(" . implode(",", $option_value) . ")";
			}
		}

		if($option_filters) {
			if($this->ave_product_filter_setting['option_mode'] == 'and') {
				foreach($option_filters as $i => $option_filter) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_option_value pov" . $i . " WHERE pov" . $i . ".product_id=pov.product_id AND pov" . $i . "." . $option_filter . ") ";
				}
			} else {
				$sql .= " AND (" . implode(" OR ", $option_filters) . ")";
			}
		}

		if($data['manufacturer']) {
			$sql .= " AND p.manufacturer_id IN(" . implode(", ", $data['manufacturer']) . ")";
		}

		if($data['attribute_value']) {
			if($this->ave_product_filter_setting['attribute_mode'] == 'and') {
				$i = 0;
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$sql .= " AND EXISTS (select 1 FROM " . DB_PREFIX . "product_attribute p2a" . $i . " WHERE p2a" . $i . ".product_id=p2a.product_id AND p2a" . $i . ".attribute_id = " . (int)$attribute_id . " AND p2a" . $i . ".text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')) ";
					$i++;
				}
			} else {
				foreach($data['attribute_value'] as $attribute_id => $values) {
					$attribute_filters[] = "p2a.attribute_id = " . (int)$attribute_id . " AND p2a.text IN('" . implode("', '", array_map(array($this->db, 'escape'), $values)) . "')";
				}
				$sql .= " AND (" . implode(" OR ", $attribute_filters) . ")";
			}
		}

		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND p.price >=" . (int)($pmin);
		}

		$sql .= " AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW( ) AND p2s.store_id = " . (int)$this->config->get('config_store_id');

		$sort_data = array(
			'pd.name' => 'name',
			'p.model' => 'model',
			'p.quantity' => 'quantity',
			'p.price' => 'realprice',
			'p.sort_order' => 'sort_order',
			'p.date_added' => 'date_added'
		);

		$sql .= ") as innertable WHERE 1 ";
		if($data['pmin'] >= 0) {
			$pmin = $this->currency->convert((int)$data['pmin'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= "AND realprice >=" . (int)($pmin);
		}
		if($data['pmax'] > 0) {
			$pmax = $this->currency->convert($data['pmax'], $this->currency->getCode(), $this->config->get('config_currency'));
			$sql .= " AND realprice <=" . (int)round($pmax);
		}

		if(isset($data['sort']) && array_key_exists($data['sort'], $sort_data)) {
			$data['sort'] = $sort_data[$data['sort']];
			if($data['sort'] == 'name' || $data['sort'] == 'model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(name) DESC";
		} else {
			$sql .= " ASC, LCASE(name) ASC";
		}
		if(isset($data['start']) || isset($data['limit'])) {
			if($data['start'] < 0) {
				$data['start'] = 0;
			}

			if($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		$product_data = array();
		$id_group = array();
		if($query->rows) {
			foreach($query->rows as $result) {
				$id_group[$result['product_id']] = $result['product_id'];
			}
			$this->load->model('avethemes/global');
			$product_data = $this->model_avethemes_global->getProductsGroup(array('id_group'=>$id_group));			
		}
		return $product_data;
		
	}
}
