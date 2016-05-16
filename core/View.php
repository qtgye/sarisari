<?php 

/**
* View Class
*
* Handles the view
*/
class View
{	
	public function __construct ()
	{
		
	}

	public static function render( $view_path, $data = array() )
	{
		if ( is_array($data) ) {
			extract($data);
		}

		$view_path = APP_PATH . '/views/' . trim($view_path,'/') . '.php';

		if ( is_readable($view_path) ) {
			include $view_path;
		} else {
			Log::append('The view path <strong>'.$view_path.'</strong> does not exist.'); exit();
		}
	}
}