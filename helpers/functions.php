<?php 


function app_path($path)
{
	$full_path = '/';
	if ( defined('ROUTE_PREFIX') && ROUTE_PREFIX != '' ) {
		$full_path .= trim(ROUTE_PREFIX,'/') . '/';		
	}
	$full_path .= trim($path,'/');
	return $full_path;
}



function app_uri($path)
{
	return app_path($path);
}


function model($model_name,$params = array())
{
	$model_path = APP_PATH.'/models/'.$model_name.'.php';
	if ( is_readable($model_path) ) {
		require_once($model_path);
		if ( class_exists($model_name) ) {
			return call_user_func_array(
		       array(new ReflectionClass($model_name), 'newInstance'),
		       $params
		    );
		}
	}
	return NULL;
}


function statement_placeholders($item)
{
	return '?';
}


function statement_key_value($key)
{
	return $key .'=?';
}


function redirect($url)
{
	header('Location: ' . app_uri($url));
}