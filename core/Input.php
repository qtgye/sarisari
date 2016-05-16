<?php 

/**
* Input Class
*
* Handles POST and GET parameters
*/
class Input
{
	
	function __construct()
	{
		
	}


	public static function post()
	{
		return $_POST;
	}


	public static function get($key = NULL)
	{
		if ( !empty($key) ) {
			return !empty($_GET[$key]) ? $_GET[$key] : NULL ;
		}

		return $_GET;		
	}

}