<?php 

require_once(APP_PATH . '/models/Location.php');
require_once(APP_PATH . '/models/Auth.php');

require_once(CORE_PATH . '/Session.php');
require_once(CORE_PATH . '/Redirect.php');

/**
* Admin Controller
*/
class AdminController extends Controller
{	
	function __construct()
	{
		parent::__construct();
		$this->data['page'] = 'index';
	}


	public function index()
	{
		if ( !Auth::logged_in() ) {
			Redirect::to(app_path('/login'));
		}

		$this->data['locations'] = Location::all();
		View::render('admin/page',$this->data);
	}


	public function add()
	{
		$this->data['page'] = 'form';
		$this->data['method'] = 'create';
		$this->data['heading'] = 'New Location';

		View::render('admin/page',$this->data);
	}


	public function edit()
	{
		$location = Input::get('l');

		if ( !$location ) {
			redirect('admin');
		}

		$location = Location::get((int) $location);
		$location->attributes['id'] = $location->id;

		// Override with form data
		$form = Session::get('form');
		if ( !empty($form) ) {			
			$location->attributes = array_merge($location->attributes,$form);			
		}

		$this->data['page'] = 'form';
		$this->data['method'] = 'update';
		$this->data['heading'] = 'Edit ' . $location->title;
		$this->data['location'] = $location->attributes;

		View::render('admin/page',$this->data);
	}
}