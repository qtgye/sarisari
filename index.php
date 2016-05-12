<?php 

$files = array(

	// CORE FILES
	'core/Config',
	'core/Log',
	'core/Route',
	'core/Input',
	'core/View',
	'core/Controller',

	// OTHER FILES
	'routes',
	'helpers/functions',

);

foreach ($files as $file) {
	require_once($file . '.php');
}

// INIT
$route->execute_matched();
