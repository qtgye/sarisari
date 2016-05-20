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
