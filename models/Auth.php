<?php 

require_once( CORE_PATH . '/Model.php' );

/**
* Auth Model
*/
class Auth extends Model
{
	
	public $password = '57c76182889b7c210a77595f61a92692'; // md5($@ri$@ri)
	public $username = 'cokeadmin';

	public static $instance = NULL;

	function __construct()
	{
		parent::__construct();
	}


	public static function get_instance ()
	{
		if ( NULL == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	public static function logged_in()
	{
		return Session::get('logged_in');
	}


	public static function check($data = array())
	{
		if ( !isset($data['username']) || !isset($data['password']) ) {
			return FALSE;
		}

		$instance = self::get_instance();
		return $data['username'] == $instance->username && md5($data['password']) == $instance->password;
	}
}