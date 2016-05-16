<?php 

/**
* Session Class
*/
class Session
{
	public static $instance;
	
	function __construct()
	{
		session_start();
	}


	public static function get_instance ()
	{
		if ( NULL == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	public static function get ($key = NULL)
	{
		if ( isset($key) ) {
			return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
		} 

		return $_SESSION;		
	}


	public static function set ($key,$value = NULL)
	{
		$_SESSION[$key] = $value;
		return $_SESSION[$key] == $value;
	}


	public static function delete ($key)
	{
		if ( isset($_SESSION[$key]) ) {
			unset($_SESSION[$key]);
		}
		return !isset($_SESSION[$key]);
	}

	/**
	 * Reset form data, flash messages
	 * @return void 
	 */		
	public static function reset ()
	{
		$keys = array( 'form', 'error', 'flash' );
		foreach ($keys as $key) {
			if ( isset($_SESSION[$key]) ) {
				unset($_SESSION[$key]);
			}
		}
	}

}

// start the session
Session::get_instance();