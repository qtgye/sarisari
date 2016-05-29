<?php 
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
		$this->id = is_numeric($args['id']) ? $args['id'] : NULL ;

		// update attributes
		foreach ($args as $key => $value) {
			if ( !array_key_exists($key, $this->attributes) ) continue;

			$value = in_array($key, $this->numbers) ? (int) $value : $value;
			$this->attributes[$key] = $value;
			$this->{$key} = $value;
		}

		// timestamps
		if ( array_key_exists('created_at', $args) ) {			
			$this->attributes['created_at'] = (int) $args['created_at'];
			$this->attributes['updated_at'] = (int) $args['updated_at'];
		} else {
			$this->attributes['created_at'] = time();
			$this->attributes['updated_at'] = $this->attributes['created_at'];
		}
	}


	public function get_images()
	{
		$db = Database::get_instance();
		$result = $db->connection->query("SELECT * FROM images WHERE story_id={$this->id}");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return array();
		}

		$items = array();
		while ($item = $result->fetch_assoc()) {
			$image = Image::create($item);
			array_push($items, $image);
		}

		$this->images = $items;
		return $items;
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
		$story = $result ? self::create($result) : NULL;

		if ( $story ) {
			$story->images = Image::get_story_images($story->id);
		}

		return $story;
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