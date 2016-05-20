<?php

require_once('Database.php');

/**
* Base Model Class
*/
class Model
{

	public $table_name = '';

	public $attributes = array();

	public $types = '';

	public static $instance = NULL;
	
	function __construct()
	{
		// $this->db = Database::get_instance();
	}


	public function save ()
	{
		$method = isset($this->attributes['id']) ? 'update' : 'insert';
		$db = Database::get_instance();

		$result = call_user_func_array(
					array($db,$method),
					array($this->table_name, $this->attributes, $this->types)
				);

		if ( is_int($result) ) {
			$this->id = $result;
		}

		foreach ($this->attributes as $key => $value) {
			if ( property_exists($this, $key) ) {
				$this->{$key} = $value;
			}
		}

		// id | FALSE
		return $result;
	}



	public function delete()
	{
		$db 	= Database::get_instance();
		$table 	= $this->table_name;
		$id 	= $this->id;

		$result = $db->connection->query("DELETE FROM {$table} WHERE id={$id}");
		return $result;
	}



}