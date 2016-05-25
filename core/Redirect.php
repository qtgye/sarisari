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
		if ( !isset($_SERVER['HTTP_REFERER']) ) {
			self::error('404');
		}

		$previous = $_SERVER['HTTP_REFERER'];
		$instance = self::get_instance();
		$instance->set_location($previous);		
	}


	public static function to($url = ROUTE_PREFIX)
	{
		$instance = self::get_instance();
		$instance->set_location($url);
	}



	public static function error( $code = 404 )
	{
		echo '<h3>Page Not Found</h3>';
		exit();
	}
}