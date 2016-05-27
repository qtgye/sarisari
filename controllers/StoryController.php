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



	public function edit()
	{
		$story = Input::get('s');

		if ( !$story ) {
			redirect('admin');
		}

		$story = Story::get((int) $story);
		if ( !$story ) {
			Redirect::back();
		}

		$story->attributes['id'] = $story->id;

		// Override with form data
		$form = Session::get('form');
		if ( !empty($form) ) {			
			$story->attributes = array_merge($story->attributes,$form);			
		}

		$this->data['page'] = 'story';
		$this->data['method'] = 'update';
		$this->data['heading'] = 'Edit ' . $story->name;
		$this->data['location_id'] = $story->location_id;
		$this->data['story'] = $story->attributes;
		// $this->data['photos'] = $story->photos;

		View::render('admin/page',$this->data);
	}



	public function create()
	{	
		$post = Input::post();

		if ( !empty($post) ) {

			$story = Story::create($post);
			$file = Input::files('file');

			if ( $file && is_int($file['size']) && $file['size'] > 0 ) {
				$uploaded = Image::upload($file);

				if ( $uploaded ) {
					$story->attributes['thumbnail'] = $uploaded['file_name'];
					$story->thumbnail = $uploaded['file_name'];
				}				
			}

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
			Redirect::to(app_path('admin/story/edit?s=' . $story->id));			
		}
	}

	public function update()
	{	
		$post = Input::post();

		if ( !$post['id'] ) {
			Log::append('Missing id from POST.');
			$error_msg = 'Unable to update item. Please check errorlog for details.';
			Session::set('error',$error_msg);
			Session::set('form',$post);
			Redirect::back();
		}

		if ( !empty($post) ) {

			$story = Story::get($post['id']);
			$file = Input::files('file');

			if ( $file && is_int($file['size']) && $file['size'] > 0 ) {
				$uploaded = Image::upload($file);

				if ( $uploaded ) {
					$post['thumbnail'] = $uploaded['file_name'];
				}				
			}

			if ( array_key_exists('updated_at', $story->attributes) ) {
				$post['updated_at'] = time();
			}

			$story->update(array_merge($story->attributes,$post));
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
			Session::set('flash',"Successfully Updated \"{$title}\"");
			Redirect::to(app_path('admin/story/edit?s=' . $story->id));			
		}
	}


	public function delete ()
	{
		$id = Input::post('id');

		$response = array(
			'success' => FALSE,
			'message' => NULL
			);

		if ( !$id ) {
			$response['message'] = 'Please provide sufficient data.';
		} else {
			$story = Story::get($id);
			if ( !$story ) {
				$response['message'] = 'Item requested does not exist.';
			} else {
				if ( !$story->delete() ) {					
					$response['message'] = 'Unable to delete item. Please see errorlog for details';
				} else {
					$response['success'] = TRUE;
					$response['message'] = 'Successfully deleted item.';
				}
			}
			
		}

		

		

		if ( $story->delete() ) {

		}

		$response['success'] = TRUE;		
		$response['data'] = $story;

		echo json_encode($response);

	}



	public function images ()
	{
		$response = array(
			'success' => FALSE,
			'message' => ''
		);
		$id = Input::post('story_id');

		if ( !$id ) {
			$response['message'] = 'Missing post data.';
			echo json_encode($response); exit();			
		}

		$images = Image::get_story_images($id);

		$response['images'] = $images;

		echo json_encode($response); exit();			
	}
}