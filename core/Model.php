<?php

require_once('Database.php');

/**
* Base Model Class
*/
class Model
{
	protected $db;
	
	function __construct()
	{
		$this->db = Database::get_instance();
	}
}