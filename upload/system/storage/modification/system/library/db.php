<?php
class DB {
	private $db;
		public $query_data = array();

	public function __construct($driver, $hostname, $username, $password, $database, $port = NULL) {
		$class = 'DB\\' . $driver;

		if (class_exists($class)) {
			$this->db = new $class($hostname, $username, $password, $database, $port);
		} else {
			exit('Error: Could not load database driver ' . $driver . '!');
		}
	}

	public function query($sql) {
		if (defined('ave_start_time')) {
			$start_time = microtime();
			$start_time = explode(' ', $start_time);
			$start_time = $start_time['1'] + $start_time['0'];
			$result = $this->db->query($sql);
			$endtime = microtime();
			$endtime = explode(' ', $endtime);
			$endtime = $endtime['1'] + $endtime['0'];
			$this->query_data[] = array(
						'query'		=>	$sql,
						'time'		=>	number_format($endtime - $start_time,5)
					);
			unset($start_time);
			unset($endtime);
			return $result;
		}else{
			return $this->db->query($sql);
		}
	}

	public function escape($value) {
		return $this->db->escape($value);
	}

	public function countAffected() {
		return $this->db->countAffected();
	}

	public function getLastId() {
		return $this->db->getLastId();
	}
}
