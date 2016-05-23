<?php 

require_once( APP_PATH . '/core/Model.php' );

/**
* Image Class
*/
class Image extends Model
{	
	public $table_name = 'photos';

	public $types = 'isssissss';

	public static $instance = NULL;

	private $defaults = array(
		'location_id' => NULL,
		'title' => '',
		'file_name' => '',
		'file_type' => '',
		'size' => 0,
		'name' => '',
		'address' => '',
		'profession' => '',
		'story' => ''
	);

	private $numbers = array(
		'location_id'
	);

	public function __construct($data = array())
	{
		parent::__construct();

		foreach ($this->defaults as $key => $value) {

			$value = !empty($data[$key]) ? $data[$key] : $value;
			$value = in_array($key, $this->numbers) ? (integer) $value : $value;

			$this->attributes[$key] = $value;
			$this->{$key} = $value;		

			if ( isset($data['id']) ) {
				$this->id = (integer) $data['id'];
			}
		}
	}


	public static function get_instance ()
	{
		if ( NULL == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function create($data = array())
	{	
		if ( !empty($data) ) {
			$image = new self($data);
		}

		return !empty($image) ? $image : NULL;
	}


	public static function upload ($file)
	{
		$uploads_dir = APP_PATH . '/uploads/';
        $uploaded = FALSE;       
        $original_file_name = $file['name'];
        $size = $file['size'];   
        $unique = md5($original_file_name . time());
        $file_name = $unique . '_' . str_replace(' ', '-', $original_file_name);
        $file_type = self::get_file_type($original_file_name);
        $title = $original_file_name;

        if ( move_uploaded_file($file['tmp_name'], $uploads_dir . $file_name) ) {  
            $uploaded = compact('title','file_name','file_type','size');
            // $image = self::create($data);
            // $uploaded = !empty($image) ? $image->save() : FALSE;
        }

        return $uploaded;
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


	public static function get_file_type ($filename)
    {
        if ( preg_match('/[.](jpg|jpeg|png|gif|bmp|ico)$/i', $filename) ) {
            return 'image';
        }
        else if ( preg_match('/[.](mp4|mpeg|avi|mov|3gp|wmv|mkv)$/i', $filename) ) {
            return 'video';
        }
        else if ( preg_match('/[.](wav|mp3|wma)$/i', $filename) ) {
            return 'audio';
        }
        else if ( preg_match('/[.](doc|docx|txt)$/i', $filename) ) {
            return 'document';
        }
        else if ( preg_match('/[.](pdf)$/i', $filename) ) {
            return 'pdf';
        }
        return 'other';
    }


    public static function get_location_images($id = NULL)
	{
		$location_id = $id;
		$items = array();

		if ( !isset($location_id) ) {
			return $items;
		}

		$instance = self::get_instance();

		$table = $instance->table_name;
		$db = Database::get_instance();
		$images = NULL;

		$result = $db->connection->query("SELECT * FROM photos WHERE location_id={$location_id} ORDER BY id DESC");

		if ( !$result || $db->connection->error ) {
			Log::append($db->connection->error);
			return NULL;
		}

		$items = array();
		while ($item = $result->fetch_assoc()) {
			$image = self::create($item);
			$image->src = app_path('uploads/'.$image->file_name);
			array_push($items, $image );
		}

		return $items;
	}
}