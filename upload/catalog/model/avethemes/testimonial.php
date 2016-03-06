<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesTestimonial extends Model {
	public function getTestimonialByServiceGroupID($service_group_id) {
		if (is_array($service_group_id)) {
			$service_group_id=implode(',',$service_group_id);
		}
		$return = array();
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_testimonial s 
		LEFT JOIN ".DB_PREFIX."ave_testimonial_service ts ON (s.testimonial_id = ts.testimonial_id) WHERE ts.service_id IN (" . $service_group_id . ") AND s.status = '1'");
		if ($query->num_rows) {
			$return = $query->rows;
		}
		return $return;
	}
	
	public function getRandomTestimonials($limit=5) {	
		$return = array();
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_testimonial s WHERE s.status = '1' ORDER BY RAND() LIMIT " . (int)$limit. "");	
		if ($query->num_rows) {
			$return = $query->rows;
		}	
		return $return;	
	}
	public function getTestimonialsGroup($group,$limit=5) {	
		$return = array();
		if (is_array($group)) {
			$group=implode(',',$group);
		}
		if(!empty($group)){
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_testimonial s WHERE s.testimonial_id IN (".$group.") AND s.status = '1' LIMIT " . (int)$limit. "");	
			$return = $query->rows;		
		}
		
		return $return;	
	}
	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_testimonial r WHERE r.testimonial_id = '" . (int)$testimonial_id . "'");
		
		return $query->row;
	}
}
?>