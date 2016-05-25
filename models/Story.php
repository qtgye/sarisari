<?php 

require_once(CORE_PATH . '/Model.php');
require_once(APP_PATH . '/models/Image.php');

/**
* Location Class
*/
class Story extends Model
{
	private $defaults = array(
		'location_id' => NULL,
		'thumbnail' => '',
		'name' => '',
		'address' => '',
		'profession' => '',
		'story' => '',
	);

	public $attributes = array(
		'location_id' => NULL,
		'thumbnail' => '',
		'name' => '',
		'address' => '',
		'profession' => '',
		'story' => '',		
	); 

	private $numbers = array(
		'location_id'
	);

	public $table_name = 'stories';

	public $types = 'dsssssdd';

	public $images = array();
	
	public function __construct($args = array())
	{
		parent::__construct();

		if ( empty($args) ) return;

		$args = array_merge($this->defaults,$args);
		$this->id = isset($args['id']) ? $args['id'] : NULL ;

		// attributes
		foreach ($args as $key => $value) {
			if ( !array_key_exists($key, $this->attributes) ) continue;

			$value = in_array($key, $this->numbers) ? (int) $value : $value;
			$this->attributes[$key] = $value;
			$this->{$key} = $value;
		}

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

}