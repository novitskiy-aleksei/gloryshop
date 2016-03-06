<?php
class ModelAvethemesVerticalCategory extends Model {
	public function getLinks() {

		$query = $this->db->query("SELECT * FROM opencart_category_link l LEFT JOIN opencart_category_link_description ld ON (l.category_id = ld.category_id) WHERE ld.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY l.sort_order, LCASE(ld.name)");

		return $query->rows;
	}
}
?>