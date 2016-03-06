<?php
class ModelAvethemesContact extends Model {
	public function checkInstall(){
		$query = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ave_contact` (
				`contact_id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(54) NOT NULL,
				`email` varchar(64) NOT NULL,
				`enquiry` text NOT NULL,
				`status` tinyint(1) NOT NULL,
  				`date_added` datetime NOT NULL,
				PRIMARY KEY (`contact_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		";
			$this->db->query($query);
	}
	public function addContact($data) {
		$this->event->trigger('pre.admin.contact.add', $data);

		$this->db->query("INSERT INTO ".DB_PREFIX."ave_contact SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', enquiry = '" . $this->db->escape(strip_tags($data['enquiry'])) . "', status = '" . (int)$pdata['status'] . "', date_added = NOW()");

		$contact_id = $this->db->getLastId();

		return $contact_id;
	}

	public function editContact($contact_id, $data) {
		$this->event->trigger('pre.admin.contact.edit', $data);

		$this->db->query("UPDATE ".DB_PREFIX."ave_contact SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', enquiry = '" . $this->db->escape(strip_tags($data['enquiry'])) . "', status = '" . (int)$data['status'] . "' WHERE contact_id = '" . (int)$contact_id . "'");

		$this->event->trigger('post.admin.review.edit', $contact_id);
	}

	public function deleteContact($contact_id) {
		$this->event->trigger('pre.admin.contact.delete', $contact_id);

		$this->db->query("DELETE FROM ".DB_PREFIX."ave_contact WHERE contact_id = '" . (int)$contact_id . "'");

		$this->event->trigger('post.admin.review.delete', $contact_id);
	}

	public function getContact($contact_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."ave_contact r WHERE r.contact_id = '" . (int)$contact_id . "'");

		return $query->row;
	}

	public function getContacts($data = array()) {
		$sql = "SELECT r.contact_id, r.name, r.email, r.status, r.date_added FROM ".DB_PREFIX."ave_contact r WHERE 1 = 1";


		if (!empty($data['filter_name'])) {
			$sql .= " AND r.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'r.name',
			'r.email',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalContacts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_contact r WHERE 1 = 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND r.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalContactsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_contact WHERE status = '0'");

		return $query->row['total'];
	}
}