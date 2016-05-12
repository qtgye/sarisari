<?php 

function app_path($path)
{
	return '/'.ltrim($path,'/');
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