<?php 

$route->get('/','PageController@index');

// temp. index:
// $route->get('/','PageController@temp');

$route->get('login','AuthController@login');
$route->get('admin','AdminController@index');
$route->get('logout','AuthController@logout');

$route->get('admin/location/add','LocationController@add');
$route->get('admin/location/edit','LocationController@edit');

$route->get('admin/story/add','StoryController@add');
$route->get('admin/story/edit','StoryController@edit');


// POSTS

$route->post('api/login','AuthController@verify');

$route->post('api/location/create','LocationController@create');
$route->post('api/location/update','LocationController@update');
// $route->post('api/delete','LocationController@delete');

$route->post('api/story/create','StoryController@create');
$route->post('api/story/update','StoryController@update');
$route->post('api/story/delete','StoryController@delete');
$route->post('api/story/images','StoryController@images');

// $route->post('api/upload','ImageController@upload');
$route->post('api/upload','ImageController@upload');
$route->post('api/images','ImageController@location_images');
$route->post('api/image_delete','ImageController@image_delete');
$route->post('api/image_get','ImageController@get');
$route->post('api/image_update','ImageController@update');