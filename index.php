<?php 

$files = array(

	// HELPERS
	'helpers/functions',

	// CORE FILES	
	'core/Log',
	'core/Error',
	'core/Config',
	'core/Session',
	'core/Redirect',
	'core/Route',
	'core/Input',
	'core/View',
	'core/Controller',
	'core/Model',

	// OTHER FILES
	'routes',

);

foreach ($files as $file) {
	require_once($file . '.php');
}

// INIT
$route->execute_matched();

Session::reset();
