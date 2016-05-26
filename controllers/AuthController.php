<?php 

require_once( CORE_PATH . '/Database.php' );
require_once( CORE_PATH . '/Controller.php' );
require_once( CORE_PATH . '/Input.php' );

require_once( APP_PATH . '/models/Auth.php' );


/**
* Auth Controller
*/
class AuthController extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function login()
	{
		View::render('admin/login');
		Session::delete('error');
	}


	public function verify()
	{
		$post = Input::post();

		$valid = Auth::check($post);

		if ( $valid ) {
			Session::set('logged_in',TRUE);
			Redirect::to('/admin');			
		} else {
			Session::set('error','Invalid credentials');
			Redirect::to('/login');
		}
	}

}