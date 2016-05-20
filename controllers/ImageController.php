<?php
// require_once(APP_PATH . '/models/Image.php');
require_once(APP_PATH . '/core/Input.php');

/**
* LocationController
*/
class ImageController extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function upload ()
	{
		$post = Input::post();
		echo json_encode($post);
		// echo '<pre style="display: table; font-size: 10px">';
		// 	var_dump(Input::post());
		// echo '</pre>';
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