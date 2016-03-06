<?php
class ModelAvethemesVerticalCategory extends Model {

	public function CreateDB() {
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `opencart_category_link` (
			  `category_id` int(11) NOT NULL AUTO_INCREMENT,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `url` varchar(255) NOT NULL,
			  PRIMARY KEY (`category_id`)
			) 
		");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `opencart_category_link_description` (
			  `category_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  PRIMARY KEY (`category_id`,`language_id`),
			  KEY `name` (`name`)
			)
		");
		
	}

	public function updateLink($data) {

		$this->db->query("DELETE FROM opencart_category_link");
		$this->db->query("DELETE FROM opencart_category_link_description");

		if (isset($data['link'])) {
			
			foreach ($data['link'] as $link) {

				$this->db->query("INSERT INTO opencart_category_link SET sort_order = '" . (int)$link['sort_order'] . "', url = '" . $this->db->escape($link['url']) . "'");

				$category_id = $this->db->getLastId();

				foreach ($link['description'] as $language_id => $link_description) {				
					$this->db->query("INSERT INTO opencart_category_link_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" .  $this->db->escape($link_description['name']) . "'");
				}

			}
		}

	} 

	public function getLink($category_id) {
		$query = $this->db->query("SELECT * FROM opencart_category_link l LEFT JOIN opencart_category_link_description ld ON (l.category_id = ld.category_id) WHERE l.category_id = '" . (int)$category_id . "' AND ld.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getLinks() {
		$link_data = array();

		$link_query = $this->db->query("SELECT * FROM opencart_category_link GROUP BY category_id ORDER BY sort_order");

		foreach ($link_query->rows as $link) {
			$link_description_data = array();

			$link_description_query = $this->db->query("SELECT * FROM opencart_category_link l LEFT JOIN opencart_category_link_description ld ON (l.category_id = ld.category_id)  WHERE l.category_id = '" . (int)$link['category_id'] . "'");

			foreach ($link_description_query->rows as $link_description) {
				$link_description_data[$link_description['language_id']] = array('name' => $link_description['name']);
			}

			$link_data[] = array(
				'category_id'      => $link['category_id'],
				'url'              => $link['url'],
				'sort_order'       => $link['sort_order'],
				'link_description' => $link_description_data
			);
		}

		return $link_data;
	}

}
?>