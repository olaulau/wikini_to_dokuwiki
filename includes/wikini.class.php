<?php

require_once("conf.inc.php");
require_once("fonctions.inc.php");

class Wikini {
	
	private $db;
	private $pages;
	
	
	public function get_pages() {
		return $this->pages;
	}
	
	
	public function __construct() {
		global $mysql_host, $mysql_port, $mysql_login, $mysql_password, $base;
		$dsn = "mysql:dbname=$base;host=$mysql_host;port=$mysql_port";
		try {
			$this->db = new PDO($dsn, $mysql_login, $mysql_password);
		} catch (PDOException $e) {
			die('Connection failed: ' . $e->getMessage());
		}
	}
	
	
	public function load() {
		global $wikini_table_prefix, $wikini_pages_table_name;
		global $wikini_user_filter, $wikini_page_filter, $wikini_log_pages;
		
		// request
		$sql = "
			SELECT		*
			FROM		" . $wikini_table_prefix . $wikini_pages_table_name . "
			WHERE		user NOT IN ( " . string_list_to_sql_list($wikini_user_filter) . " )
				AND		tag NOT IN ( " . string_list_to_sql_list($wikini_page_filter) . " )
				AND		tag NOT LIKE '$wikini_log_pages%'
			ORDER BY	tag ASC, time DESC
		";
// 		var_dump($sql); die;
		$result = $this->db->query($sql) or die($this->db->error);
		$res = [];
		while( $row = $result->fetch(PDO::FETCH_ASSOC) )
		{
			if( !isset($last_tag)  ||  $last_tag != $row['tag']) {
				$res[$row['tag']] = array();
			}
			$last_tag = $row['tag'];
			$res[$row['tag']][$row['time']] = $row;
		}
// 		var_dump($res);
		$this->pages = $res;
	}
	
}
