<?php 

require_once(CORE_PATH . '/Model.php');
require_once(APP_PATH . '/models/Image.php');

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

	public $images = array();
	
	public function __construct($args = array())
	{
		parent::__construct();

		if ( empty($args) ) return;

		$this->map = array(
			'width' => 531,
			'height' => 877,
		);

		$args = array_merge($this->defaults,$args);

		$this->id = is_numeric($args['id']) ? $args['id'] : NULL ;
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

		// images
		// $this->images = $this->images();
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

		$instance = static::get_instance();
		$db = Database::get_instance();
		$table = $instance->table_name;

		$result = $db->connection->query("SELECT * FROM {$table} WHERE id = {$id}");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return NULL;
		}

		$result = $result->num_rows > 0 ? $result->fetch_assoc() : NULL;
		$item = static::create($result);

		$item->stories = static::get_stories($item->id);

		return $item;
	}


	public static function all ()
	{
		$db = Database::get_instance();
		$instance = static::get_instance();		
		$table = $instance->table_name;

		$result = $db->connection->query("SELECT * FROM {$table} ORDER BY id DESC");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return NULL;
		}

		$items = array();
		while ($item = $result->fetch_assoc()) {
			$location = static::create($item);
			$location->images = Image::get_location_images($location->id);
			array_push($items, $location);
		}

		return $items;
	}

	public static function get_stories($id = NULL)
	{
		if ( !is_integer($id) ) return;

		// query stories here

		// temporary
		return array();
	}


	// public function images()
	// {
	// 	$instance = self::get_instance();
	// 	$table = $instance->table_name;
	// 	$location_id = $this->id;
	// 	$images = NULL;

	// 	$result = $this->db->query("SELECT * FROM photos WHERE location_id={$location_id} ORDER BY id DESC");

	// 	if ( !$result || $db->connection->error ) {
	// 		Log::append($db->connection->error);
	// 		return NULL;
	// 	}

	// 	$items = array();
	// 	while ($item = $result->fetch_assoc()) {
	// 		array_push($items, static::create($item));
	// 	}

	// 	return $items;
	// }

}