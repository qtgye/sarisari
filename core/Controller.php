<?php 

require_once(CORE_PATH . '/Input.php');
require_once(CORE_PATH . '/Session.php');
require_once(CORE_PATH . '/Database.php');

/**
* Base Controller Class
*/
class Controller
{
	protected $data = array();

	public function __construct ()
	{
		$post = Input::post();

		if ( !empty($post) ) {
			Session::set('form',$post);
		}

		$this->data['flash'] = Session::get('flash');
		$this->data['error'] = Session::get('error');
	}

	/**
	 * Default method
	 * @return void
	 */
	public function index()
	{
		
	}
}