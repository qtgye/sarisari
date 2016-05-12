<?php 

$files = array(

	// CORE FILES
	'core/Config',
	'core/Log',
	'core/Route',
	'core/Input',
	'core/View',

	// OTHER FILES
	'routes',

);

foreach ($files as $file) {
	require_once($file . '.php');
}

// INIT
$route->execute_matched();