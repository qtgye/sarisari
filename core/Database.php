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

	private $connection;

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
}