<?php

require_once("conf.inc.php");
require_once("fonctions.inc.php");

class Wikini {
	
	private $mysql_link;
	
	
	public function __construct() {
		$this->mysql_link = self::connect();
	}
	
	
	public static function connect() {
		global $mysql_host, $mysql_login, $mysql_password, $base;
		
		// connection to MySQL
		$mysql_link = new mysqli();
		$mysql_link->init();
		if (!$mysql_link) {
			die('mysqli init failed');
		}
		if (!$mysql_link->real_connect($mysql_host, $mysql_login, $mysql_password, $base)) {
			die('Connect Error (' . $mysql_link->errno . ') ' . $mysql_link->error);
		}
		$mysql_link->set_charset('utf8');
		return $mysql_link;
	}
	
	
	public function get_pages_tags() {
		global $wikini_table_prefix, $wikini_pages_table_name;
		global $wikini_user_filter, $wikini_page_filter, $wikini_log_pages;
		
		// request
		$sql = "
			SELECT		tag
			FROM		$wikini_table_prefix$wikini_pages_table_name
			WHERE		user NOT IN ( " . string_list_to_sql_list($wikini_user_filter) . " )
				AND		tag NOT IN ( " . string_list_to_sql_list($wikini_page_filter) . " )
				AND		tag NOT LIKE '$wikini_log_pages%'
				AND		latest = 'Y'
			ORDER BY	tag ASC
		";
		$result = $this->mysql_link->query($sql) or die($this->mysql_link->error);
		$array = array();
		while( $data = $result->fetch_array() )
		{
			$array[] = $data['tag'];
		}
		return $array;
	}
	
	
	public function get_last_body($tag) {
		global $wikini_table_prefix, $wikini_pages_table_name;
		
		// request
		$sql = "
			SELECT		body
			FROM		$wikini_table_prefix$wikini_pages_table_name
			WHERE		tag = '$tag'
				AND		latest = 'Y'
		";
		$result = $this->mysql_link->query($sql) or die($this->mysql_link->error);
		$array = array();
		if( $data = $result->fetch_array() )
			return $data['body'];
		else
			return NULL;
	}
	
	
	public function get_all_pages() {
		global $wikini_table_prefix, $wikini_pages_table_name;
		global $wikini_user_filter, $wikini_page_filter, $wikini_log_pages;
	
		// request
		$sql = "
			SELECT		*
			FROM		$wikini_table_prefix$wikini_pages_table_name
			WHERE		user NOT IN ( " . string_list_to_sql_list($wikini_user_filter) . " )
				AND		tag NOT IN ( " . string_list_to_sql_list($wikini_page_filter) . " )
				AND		tag NOT LIKE '$wikini_log_pages%'
			ORDER BY	tag ASC, time DESC
		";
		$result = $this->mysql_link->query($sql) or die($this->mysql_link->error);
		$array = array();
		while( $data = $result->fetch_array() )
		{
			if( !isset($last_tag)  ||  $last_tag != $data['tag']) {
				$array[$data['tag']] = array();
			}
			$last_tag = $data['tag'];
			$array[$data['tag']][] = $data;
		}
		return $array;
	}
	
}
