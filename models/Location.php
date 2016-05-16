<?php 

/**
* Location Class
*/
class Location extends Model
{
	private $defaults = array(
		'name' => '',
		'title' => '',
		'x' => 0,
		'y' => 0,
	);

	private $map = array();

	public $table_name = 'locations';

	public $types = 'ssdddd';

	private static $instance;
	
	public function __construct($args = array())
	{
		parent::__construct();

		if ( empty($args) ) return;

		$this->map = array(
			'width' => 531,
			'height' => 877,
		);

		$args = array_merge($this->defaults,$args);

		$this->id = isset($args['id']) ? $args['id'] : NULL ;
		$this->name = $args['name'];
		$this->title = !empty($args['title']) ? $args['title'] : ucfirst($args['name']);

		// absolute coordinates
		$this->x = $args['x'];
		$this->y = $args['y'];

		// relative coordinates
		$this->pX = (100 * $this->x / $this->map['width']) . '%'; // as in percentage X
		$this->pY = (100 * $this->y / $this->map['height']) . '%'; // as in percentage Y

		// attributes
		$this->attributes['name'] = $this->name;
		$this->attributes['title'] = $this->title;
		$this->attributes['x'] = $this->x;
		$this->attributes['y'] = $this->y;

		// timestamps
		$this->attributes['created_at'] = time();
		$this->attributes['updated_at'] = $this->attributes['created_at'];
	}


	public static function get_instance ()
	{
		if ( NULL == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	public static function create ($args = array())
	{
		return new self($args);
	}	


	public static function get ($id = NULL)
	{
		if ( NULL == $id ) return NULL;

		$instance = self::get_instance();
		$db = Database::get_instance();
		$table = $instance->table_name;

		$result = $db->connection->query("SELECT * FROM {$table} WHERE id = {$id}");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return NULL;
		}

		$result = $result->num_rows > 0 ? $result->fetch_assoc() : NULL;
		$location = Location::create($result);

		return $location;
	}


	public static function all ()
	{
		$instance = self::get_instance();
		$db = Database::get_instance();
		$table = $instance->table_name;

		$result = $db->connection->query("SELECT * FROM {$table} ORDER BY id DESC");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return NULL;
		}

		$locations = array();
			while ($location = $result->fetch_assoc()) {
			array_push($locations, Location::create($location));
		}

		return $locations;

	}

}