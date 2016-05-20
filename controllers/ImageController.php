<?php
require_once(APP_PATH . '/models/Image.php');
require_once(APP_PATH . '/core/Input.php');
require_once(APP_PATH . '/core/Log.php');

/**
* LocationController
*/
class ImageController extends Controller
{
	public static $instance;
	
	public function __construct()
	{
		parent::__construct();
	}


	public function upload ()
	{
		$files = Input::files();
		$post = Input::post();

		$image = null;
		$uploaded = FALSE;
		$response = array(
			'success' => FALSE,
			'message' => ''
		);

		if ( is_array($files) && count($files) > 0 ) {
			$uploaded = Image::upload($files['file'],$post['location_id']);
		}

		if ( $uploaded ) {
        	$response['success'] = true;
        	$response['data'] = Image::get($uploaded);
        	$response['data']->file_name = app_path('/uploads/'.$response['data']->file_name);
        	unset($response['data']->db);
        } else {
        	$response['message'] = 'Unable to save item. Please check errorlog for details.';
        }

		echo json_encode($response);
		exit();
	}


	public function location_images()
	{
		$location_id = Input::post('location_id');
		$response = array(
			'success' => FALSE,
			'items' => array()
		);

		if ( !isset($location_id) ) {
			echo '{}';
			exit();
		}

		$instance = Image::get_instance();
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
			$image = Image::create($item);
			$image->src = app_path('uploads/'.$image->file_name);
			array_push($items, $image );
		}

		$response['success'] = TRUE;
		$response['items'] = $items;

		echo json_encode($response);
		exit();
	}



	public function image_delete()
	{
		$image_id = Input::post('id');
		$response = array(
			'success' => FALSE,
			'message' => array()
		);

		if ( !isset($image_id) ) {
			echo json_encode($response);
			exit();
		}

		$instance = Image::get_instance();
		$table = $instance->table_name;
		$db = Database::get_instance();

		$image = Image::get($image_id);

		if ( $image->delete() ) {
			unlink(app_path(APP_PATH.'/uploads/'.$image->file_name));
			$response = array(
				'success' => TRUE,
				'items' => 'Successfuly deleted image.'
			);
		} else {
			Log::append(error_get_last());
			$response['message'] = 'Unable to delete image. Please check errorlog.';
		}

		echo json_encode($response);
		exit();
	}


	// public function create()
	// {	
	// 	$post = Input::post();

	// 	if ( !empty($post) ) {

	// 		$location = Location::create($post);
	// 		$result = $location->save();

	// 		if ( !$result ) {
	// 			// Show error, redirect back
	// 			$error_msg = 'Unable to save item. Please check errorlog for details.';
	// 			Session::set('error',$error_msg);
	// 			Session::set('form',$post);
	// 			Redirect::back();
	// 		}

	// 		// else, redirect to edit
	// 		$title = $location->title;
	// 		Session::delete('form');
	// 		Session::set('flash',"Successfully added \"{$title}\"");
	// 		Redirect::to(app_path('admin/edit?l=' . $location->id));			
	// 	}
	// }


	// public function update()
	// {
	// 	$post = Input::post();
	// 	Session::set('form',$post);

	// 	if ( !isset($post['id']) ) Redirect::back();

	// 	$location = Location::get($post['id']);
	// 	if ( !$location ) Redirect::back();

	// 	if ( array_key_exists('updated_at', $location) ) {
	// 		$post['updated_at'] = time();
	// 	}

	// 	$location->attributes = array_merge($location->attributes,$post);
	// 	$result = $location->save();

	// 	if ( !$result ) {
	// 		Session::set('error','Unable to update. Please check errorlog for details.');
	// 		Redirect::back();			
	// 	}

	// 	$title = $location->title;
	// 	Session::delete('form');
	// 	Session::set('flash',"Successfully updated \"{$title}\"");
	// 	Redirect::back();
	// }


	// public function delete ()
	// {
	// 	$post = Input::post();
	// 	echo json_encode($post);
	// }
}