<?php
require_once(APP_PATH . '/models/Image.php');
require_once(APP_PATH . '/models/Story.php');
require_once(APP_PATH . '/core/Input.php');
require_once(APP_PATH . '/core/Log.php');
require_once(APP_PATH . '/core/Redirect.php');

/**
* LocationController
*/
class StoryController extends Controller
{
	public static $instance;
	
	public function __construct()
	{
		parent::__construct();
	}


	public function add ()
	{
		$data = array();
		$location_id = Input::get('l');

		if ( !$location_id ) {
			Redirect::back();
		}

		$data['location_id'] = $location_id;

		$data['page'] = 'story';
		$data['method'] = 'create';
		$data['heading'] = 'New Story';

		$this->data = array_merge($this->data,$data);
		View::render('admin/page',$this->data);
	}


	public function create()
	{	
		$post = Input::post();

		if ( !empty($post) ) {

			$story = Story::create($post);
			$file = Input::files('file');

			$result = $story->save();

			if ( !$result ) {
				// Show error, redirect back
				$error_msg = 'Unable to save item. Please check errorlog for details.';
				Session::set('error',$error_msg);
				Session::set('form',$post);
				Redirect::back();
			}

			// else, redirect to edit
			$title = $story->name;
			Session::delete('form');
			Session::set('flash',"Successfully added \"{$title}\"");
			Redirect::to(app_path('admin/story/edit?l=' . $story->id));			
		}
	}


	// public function upload ()
	// {
	// 	$files = Input::files();
	// 	$post = Input::post();

	// 	$image = null;
	// 	$uploaded = FALSE;
	// 	$response = array(
	// 		'success' => FALSE,
	// 		'message' => ''
	// 	);

	// 	if ( is_array($files) && count($files) > 0 ) {
	// 		$uploaded = Image::upload($files['file']);
	// 	}

	// 	if ( $uploaded ) {

	// 		$response['success'] = TRUE;
	// 		$response['message'] = 'Upload successful';

	// 		if ( isset($post['location_id']) ) {
	// 			// CREATING NEW DATA
	// 			$data = array_merge($uploaded,array('location_id'=>$post['location_id']));
	// 			$image = Image::create($data);

	// 			if ( $image->save() ) {
	// 				$response['success'] = true;
	// 				$response['message'] = 'Successfully saved data';
	// 	        	$response['data'] = Image::get($image->id);
	// 	        	unset($response['data']->db);
	// 			} else {
	// 				$response['message'] = 'Unable to save item. Please check errorlog for details.';
	// 			}        	
	// 		} else if ( isset($post['id']) ) {
	// 			// REPLACING IMAGE FOR CURRENT DATA
	// 			$data = $uploaded;
	// 			$image = Image::get($post['id']);
	// 			$previous_file = $image->file_name;

	// 			if ( $image->update($data) ) {
	// 				if ( $image->save($data) ) {
	// 					$response['success'] = TRUE;
	// 					$response['message'] = 'Successfully saved data';
	// 					$response['data'] = $image;

	// 					// Delete previous image
	// 					unlink(APP_PATH . "/uploads/{$previous_file}");

	// 				} else {
	// 					$response['success'] = FALSE;
	// 					$response['message'] = 'Unable to save data';						
	// 				}					
	// 			} else {
	// 				$response['success'] = FALSE;
	// 				$response['message'] = 'Unable to update data';
	// 			}
	// 		}
        	
 //        } 

	// 	echo json_encode($response);
	// 	exit();
	// }


	// public function location_images()
	// {
	// 	$location_id = Input::post('location_id');
	// 	$response = array(
	// 		'success' => FALSE,
	// 		'items' => array()
	// 	);

	// 	if ( !isset($location_id) ) {
	// 		echo '{}';
	// 		exit();
	// 	}

	// 	$instance = Image::get_instance();
	// 	$table = $instance->table_name;
	// 	$db = Database::get_instance();
	// 	$images = NULL;

	// 	$result = $db->connection->query("SELECT * FROM photos WHERE location_id={$location_id} ORDER BY id");

	// 	if ( !$result || $db->connection->error ) {
	// 		Log::append($db->connection->error);
	// 		return NULL;
	// 	}

	// 	$items = array();
	// 	while ($item = $result->fetch_assoc()) {
	// 		$image = Image::create($item);
	// 		$image->src = app_path('uploads/'.$image->file_name);
	// 		array_push($items, $image );
	// 	}

	// 	$response['success'] = TRUE;
	// 	$response['items'] = $items;

	// 	echo json_encode($response);
	// 	exit();
	// }



	// public function image_delete()
	// {
	// 	$image_id = Input::post('id');
	// 	$response = array(
	// 		'success' => FALSE,
	// 		'message' => array()
	// 	);

	// 	if ( !isset($image_id) ) {
	// 		echo json_encode($response);
	// 		exit();
	// 	}

	// 	$instance = Image::get_instance();
	// 	$table = $instance->table_name;
	// 	$db = Database::get_instance();

	// 	$image = Image::get($image_id);

	// 	if ( $image->delete() ) {
	// 		unlink(app_path(APP_PATH.'/uploads/'.$image->file_name));
	// 		$response = array(
	// 			'success' => TRUE,
	// 			'items' => 'Successfuly deleted image.'
	// 		);
	// 	} else {
	// 		Log::append(error_get_last());
	// 		$response['message'] = 'Unable to delete image. Please check errorlog.';
	// 	}

	// 	echo json_encode($response);
	// 	exit();
	// }



	// public function update()
	// {
	// 	$image_id = Input::post('id');
	// 	$response = array(
	// 		'success' => FALSE,
	// 		'message' => array()
	// 	);

	// 	if ( !isset($image_id) ) {
	// 		echo json_encode($response);
	// 		exit();
	// 	}

	// 	$image = Image::get($image_id);
	// 	$new_data = Input::post();

	// 	if ( $image->update($new_data) ) {
	// 		if ( $image->save() ) {
	// 			$response['success'] = TRUE;
	// 			$response['message'] = 'Successfully saved data';
	// 		} else {
	// 			$response['message'] = 'Unable to save';
	// 		}
			
	// 	} else {
	// 		$response['message'] = 'Unable to update';
	// 	}	

	// 	echo json_encode($response);
	// 	exit();
	// }




	// public function get ()
	// {
	// 	$image_id = Input::post('id');
	// 	$response = array(
	// 		'success' => FALSE,
	// 		'message' => ''
	// 	);

	// 	if ( !isset($image_id) ) {
	// 		echo json_encode($response);
	// 		exit();
	// 	}

	// 	$image = Image::get($image_id);

	// 	if ( $image != NULL ) {
	// 		$response['success'] = TRUE;
	// 		$response['data'] = $image;
	// 	}

	// 	echo json_encode($response);
	// 	exit();
	// }
}