<?php 

$route->get('/','PageController@index');
$route->get('admin','AdminController@index');
$route->get('admin/add','AdminController@add');
$route->get('admin/edit','AdminController@edit');

$route->post('api/create','LocationController@create');
$route->post('api/update','LocationController@update');
// $route->post('api/delete','LocationController@delete');

// $route->post('api/upload','ImageController@upload');
$route->post('api/upload','ImageController@upload');
$route->post('api/images','ImageController@location_images');
$route->post('api/image_delete','ImageController@image_delete');
$route->post('api/image_get','ImageController@get');
$route->post('api/image_update','ImageController@update');
