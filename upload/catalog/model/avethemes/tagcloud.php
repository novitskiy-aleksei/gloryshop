<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesTagcloud extends Model {
	public function getRandomTags($limit = 5) {
		$sql = "SELECT tag FROM " . DB_PREFIX . "ave_article_description ad 
		LEFT JOIN " . DB_PREFIX . "ave_article a ON a.article_id = ad.article_id WHERE a.status = '1' AND ad.tag != '' AND ad.language_id = '" . $this->config->get('config_language_id') . "' GROUP BY tag ORDER BY RAND() LIMIT " . $limit;
		$query = $this->db->query($sql);
		$return = false;
		if ($query->num_rows) {
			$return = $query->rows;
		}
		return $return;
	}
}
?>