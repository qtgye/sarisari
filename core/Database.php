<?php 

/**
* Database Class
*/
class Database
{
	private $host = DB_HOST;

	private $user = DB_USER;

	private $password = DB_PASSWORD;

	private $name = DB_NAME;

	public $connection;

	private static $instance;
	
	function __construct()
	{
		$this->timestamp = time();
	}


	/**
	 * Gets the static instance as singleton
	 * @return Database - The Database static instance
	 */
	public static function get_instance()
	{
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->connect();
		}

		return self::$instance;
	}

	/**
	 * Connects the database
	 * @return void
	*/	 
	private function connect()
	{
		$this->connection = new mysqli(
			$this->host,
			$this->user,
			$this->password,
			$this->name);
		if ($this->connection->connect_errno) {
		    echo "Failed to connect to Database. Please check errorlog.";
		    Log::append( 'Failed to connect to Database:' .
		    	'<br>'.$this->connection->connect_errno . 
		    	'<br>'.$this->connection->connect_error
		    );
		    exit();
		}
	}


	public function insert ($table = NULL, $args = NULL, $types = '')
	{
		$result = FALSE;

		if ( NULL == $table || !is_array($args) ) {
			return FALSE;
		}

		// prepared statement
		$keys = array_keys($args);
		$values = array_values($args);
		$placeholders = array_map('statement_placeholders', $values);		
		$query = "INSERT INTO {$table} (". implode(',', $keys) .') VALUES ('. implode(',',$placeholders) .')';
		echo '<pre style="display: table; font-size: 10px">';
			var_dump($query);
		echo '</pre>';
		echo '<pre style="display: table; font-size: 10px">';
			var_dump($types);
		echo '</pre>';
		echo '<pre style="display: table; font-size: 10px">';
			var_dump($args);
		echo '</pre>';
		$statement = $this->connection->prepare($query);

		if ( !$statement ) {
			Log::append($this->connection->error);
			return FALSE;
		}

		// bind and execute
		$merged = array_merge( array($types) , $values );
		$params = array();

		foreach ($merged as $key => $value) {
			$params[$key] = &$merged[$key];
		}

		call_user_func_array(array($statement, 'bind_param'), $params);
		$result = $statement->execute();

		if ( !$result ) {
			Log::append($statement->error);
			return FALSE;
		}

		return $this->connection->insert_id;
	}


	public function update ($table = NULL, $args = NULL, $types = '')
	{
		$result = FALSE;

		if ( NULL == $table || !is_array($args) ) {
			return FALSE;
		}

		// unset id
		if ( isset($args['id']) ) {
			$id = $args['id'];
			unset($args['id']);
		}

		// prepared statement
		$keys = array_keys($args);
		$values = array_values($args);
		$key_values = array_map('statement_key_value', $keys);	
		$key_values = implode(',', $key_values);
		$query = "UPDATE {$table} SET {$key_values} WHERE id={$id} ";
		$statement = $this->connection->prepare($query);

		if ( !$statement ) {
			Log::append($this->connection->error);
			return FALSE;
		}

		// bind and execute
		$merged = array_merge( array($types) , $values );
		$params = array();

		foreach ($merged as $key => $value) {
			$params[$key] = &$merged[$key];
		}

		call_user_func_array(array($statement, 'bind_param'), $params);
		$result = $statement->execute();

		if ( !$result ) {
			Log::append($statement->error);
			return FALSE;
		}

		return TRUE;
	}
}