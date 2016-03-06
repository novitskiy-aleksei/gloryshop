<?php			
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesNewsletter extends Model {
	public function getSubscribers() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ave_newsletter WHERE subscribed='1'");
		return $query->rows;
	}
	public function getList($data = array()) {
		
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name, (SELECT name FROM ".DB_PREFIX."store WHERE ".DB_PREFIX."store.store_id = ".DB_PREFIX."ave_newsletter.store_id) AS store_name FROM ".DB_PREFIX."ave_newsletter";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(firstname, ' ', lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_subscribed']) && !is_null($data['filter_subscribed'])) {
			$implode[] = "subscribed = '" . (int)$data['filter_subscribed'] . "'";
		}

		if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
			$implode[] = "store_id = '" . (int)$data['filter_store'] . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} else {
			$sql .= " WHERE 1";
		}

		$sort_data = array(
			'name',
			'email',
			'subscribed',
			'store_id'
		);	
			
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
	public function getTotal($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM ".DB_PREFIX."ave_newsletter";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(firstname, ' ', lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_subscribed']) && !is_null($data['filter_subscribed'])) {
			$implode[] = "subscribed = '" . (int)$data['filter_subscribed'] . "'";
		}

		if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
			$implode[] = "store_id = '" . (int)$data['filter_store'] . "'";
		}

		if (isset($data['filter_list']) && is_array($data['filter_list']) && $data['filter_list']) {
			$implode_or = array();
			foreach ($data['filter_list'] as $id) {
				if ($id) {
					$list_data = explode('_', $id);
					if (isset($list_data[0]) && isset($list_data[1])) {
						$implode_or[] = "(marketing_list_id = '" . (int)$list_data[1] . "' AND store_id = '" . (int)$list_data[0] . "')";
					}
				}
			}
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} else {
			$sql .= " WHERE 1";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];	
	}
	public function addEmail($data) {		
	if (isset($data['store_id'])) {
		$store_id=$data['store_id'];
		}else{$store_id=0;}   
		$chk_email = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_newsletter 
		WHERE store_id='".(int)$store_id."' 
		AND email='".$this->db->escape($data['email'])."'");
		
		if(!$chk_email->num_rows){			
			$this->db->query("INSERT INTO ".DB_PREFIX."ave_newsletter 
			SET email='".$this->db->escape($data['email'])."',
			firstname='".$this->db->escape($data['firstname'])."'");				
			$email_id = $this->db->getLastId();		
			if (isset($data['store_id'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET store_id = '" . $this->db->escape($data['store_id']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['lastname'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET lastname = '" . $this->db->escape($data['lastname']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['subscribed'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET subscribed = '" . $this->db->escape($data['subscribed']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['code'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET code = '" . $this->db->escape($data['code']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			return true;
		}else{ 
			return false;
		}
	}
	
	public function editEmail($email_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
		SET email='".$this->db->escape($data['email'])."',
		firstname='".$this->db->escape($data['firstname'])."' 
		WHERE email_id = '" . (int)$email_id . "'");
			if (isset($data['store_id'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET store_id = '" . $this->db->escape($data['store_id']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['lastname'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET lastname = '" . $this->db->escape($data['lastname']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['subscribed'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET subscribed = '" . $this->db->escape($data['subscribed']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
			if (isset($data['code'])) {
				$this->db->query("UPDATE ".DB_PREFIX."ave_newsletter 
				SET code = '" . $this->db->escape($data['code']) . "' 
				WHERE email_id = '" . (int)$email_id . "'");
			}	
	}
	
	public function deleteEmail($email_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_newsletter WHERE email_id = '" . (int)$email_id . "'");
	}
	
	public function getEmail($email_id) {
		$query = $this->db->query("SELECT  * FROM ".DB_PREFIX."ave_newsletter WHERE email_id = '" . (int)$email_id . "'");
		return $query->row;
	}
	
	public function getEmails($data,$start,$limit) {		
		$condition = array();		
		if(isset($data['store_id']) and $data['store_id']!=""){ 
		  $condition[] = "store_id='".$data['store_id']."'";
		}		
		$condition = implode(" AND ",$condition);		
		if($condition!=""){ 
			$condition = " WHERE ".$condition;
		}		
		$sql = "SELECT SU.*,ST.name store_name FROM ".DB_PREFIX."ave_newsletter SU".$condition." LEFT JOIN(".DB_PREFIX."store ST) ON(ST.store_id=SU.store_id) LIMIT $start,$limit";			
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	public function getTotalEmails($data) {		
		$this->load->model('avethemes/global');
		$this->model_avethemes_global->checkSubscribe();
		$sql = "SELECT * FROM ".DB_PREFIX."ave_newsletter";			
		$query = $this->db->query($sql);
		
		return $query->num_rows;
	}
	public function checkmail($data,$store_id=0,$email_id=FALSE) {
	  
	   if($email_id)
		$sql = "SELECT * FROM ".DB_PREFIX."ave_newsletter WHERE email='".$data."' AND email_id!='".$email_id."' AND store_id='".$store_id."'";
	   else	
		$sql = "SELECT * FROM ".DB_PREFIX."ave_newsletter WHERE email='".$data."' AND store_id='".$store_id."'";
		
		$query = $this->db->query($sql);
		
		return $query->num_rows;
	}
	
	public function getAllEmails() {	
		$sql = "SELECT * FROM ".DB_PREFIX."ave_newsletter";			
		$query = $this->db->query($sql);		
		return $query->rows;
	}	
	public function getNewsletterSubscribers() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ave_newsletter WHERE subscribed='1'");
		return $query->rows;
	}
	
	public function export($fields) {
		
		$emails = $this->getAllEmails();
		
		//headings
		$output = implode(",", $fields) . "\n";
		
		foreach ($emails as $email) {
			$email_output = array();
			
			//loop over desired fields and print each one
			$email_data = array();
			foreach ($fields as $field) {
				if (isset($email[$field])) {
					$email_output[] = '"' . $email[$field] . '"';
				} else {
					$email_output[] = '';
				}
			}
			$output .= implode(",", $email_output) . "\n";
			
		}
		$output .= "\n";
		

		return $output;	
	}
	public function getSubcriberByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT email_id	FROM ".DB_PREFIX."ave_newsletter WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		return (isset($query->row['email_id'])) ? $query->row['email_id'] : 0;
	}

	public function subscribe($id = 0) {
		$id = (int)$id;
		if ($id > 0) {
			$sql = "UPDATE ".DB_PREFIX."ave_newsletter SET subscribed = 1 WHERE email_id = " . $id;
			$this->db->query($sql);
		}
	}

	public function unsubscribe($id = 0) {
		$id = (int)$id;
		if ($id > 0) {
			$sql = "UPDATE ".DB_PREFIX."ave_newsletter SET subscribed = 0 WHERE email_id = " . $id;
			$this->db->query($sql);
		}
	}

	public function add($data, $salt = '') {

		$emails = $data['emails'];
		$list = isset($data['list']) ? $data['list'] : array();

		$i = 0;
		if ($emails) {
			$emails = preg_replace("/\n|\r/", ',', $emails);
			$emails = explode(',', $emails);

			$emails = array_filter($emails, array($this, 'filter_email'));

			foreach ($emails as $key => $item) {
				$temp = explode('|', $item);
				if (count($temp) == 1) {
					$email = $temp[0];
					$name = '';
					$lastname = '';
				} elseif (count($temp) == 2) {
					$name = $temp[0];
					$email = $temp[1];
					$lastname = '';
				} elseif (count($temp) == 3) {
					$name = $temp[0];
					$lastname = $temp[1];
					$email = $temp[2];
				}

				$email = trim(preg_replace("/\s+/", ' ', $email));

				if ($name) {
					$name = trim(preg_replace("/\s+/", ' ', $name));
				}

				if ($lastname) {
					$lastname = trim(preg_replace("/\s+/", ' ', $lastname));
				}

				$this->db->query("INSERT IGNORE INTO ".DB_PREFIX."ave_newsletter SET email = '" . $this->db->escape($email) . "', firstname = '" . $this->db->escape($name) . "', lastname = '" . $this->db->escape($lastname) . "', code = '" . $this->db->escape(md5($salt . $email)) . "', subscribed = 1, store_id = '" . (int)$data['store_id'] . "'");
				if ($this->db->countAffected() > 0) {
					$i++;

					if (isset($list[$data['store_id']]) && $list[$data['store_id']]) {
						$query = $this->db->query("SELECT * FROM ".DB_PREFIX."ave_newsletter WHERE email = '" . $this->db->escape($email) . "' AND store_id = '" . (int)$data['store_id'] . "'");
						$row = $query->row;
						
					}
				}
			}

			if ($this->config->get('delete_unloginned_subscribe') == '1') {
				$this->clean();
			}
			$i = $i - $this->db->countAffected();
		}
		return $i;
	}

	public function delete($id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."ave_newsletter WHERE email_id = '" . (int)$id . "'");
	}

	private function filter_email($email) {
		$temp = explode('|', $email);
		if (count($temp)) {
			return $temp[count($temp) - 1] && filter_var(htmlspecialchars(trim($temp[count($temp) - 1])), FILTER_VALIDATE_EMAIL);
		} else {
			return false;
		}
	}

	private function clean() {
		$this->db->query("DELETE m.* FROM ".DB_PREFIX."ave_newsletter AS m INNER JOIN ".DB_PREFIX."customer AS c ON (LCASE(m.email) = LCASE(c.email) AND m.store_id = c.store_id)");
	}

}
?>
