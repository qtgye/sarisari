<?php 

/**
* Log class
*
* logs errors
*/
class Log
{
	
	function __construct()
	{
		
	}

	public static function append($error_string)
	{
		$error_file = dirname(dirname(__FILE__)).'/errorlog.html';
		$content = '';

		if ( file_exists($error_file) ) {
			$content  = file_get_contents($error_file);
		}

		$content = $error_string . '<br>' . $content;
		file_put_contents( $error_file, $content );
	}
}