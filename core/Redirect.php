<?php 

/**
* Redirect clas
*/
class Redirect
{
	public static $instance;
	
	function __construct()
	{
		
	}


	public static function get_instance()
	{
		if ( NULL == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	private function set_location ($url = ROUTE_PREFIX)
	{
		header('Location: '. $url);
		exit();
	}


	public static function back()
	{
		$previous = $_SERVER['HTTP_REFERER'];
		$instance = self::get_instance();
		$instance->set_location($previous);
	}


	public static function to($url = ROUTE_PREFIX)
	{
		$instance = self::get_instance();
		$instance->set_location($url);
	}
}