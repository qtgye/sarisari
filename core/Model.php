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
		$method = isset($this->id) && !is_null($this->id) ? 'update' : 'insert';
		$db = Database::get_instance();
		$values = $this->attributes;

		if ( $method == 'update' ) {
			$values['id'] = $this->id;
		}

		$result = call_user_func_array(
					array($db,$method),
					array($this->table_name, $values, $this->types)
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



	public function update($data = array())
	{
		foreach ($this->attributes as $key => $value) {
			if ( array_key_exists($key, $data) ) {
				$this->attributes[$key] = $data[$key];
				$this->{$key} = $data[$key];
			}
		}

		foreach ($data as $key => $value) {
			if ( isset($this->attributes[$key]) &&  $this->attributes[$key] != $data[$key] ) {
				return FALSE;
			}
		}

		return TRUE;
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