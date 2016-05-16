<?php

require_once('Database.php');

/**
* Base Model Class
*/
class Model
{
	protected $db;

	public $table_name = '';

	public $attributes = array();

	public $types = '';
	
	function __construct()
	{
		$this->db = Database::get_instance();
	}


	public function save ()
	{
		$method = isset($this->attributes['id']) ? 'update' : 'insert';
		$result = call_user_func_array(
					array($this->db,$method),
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

}