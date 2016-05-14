<?php 

$route->get('/','PageController@index');
$route->get('admin','AdminController@index');
$route->get('admin/edit','AdminController@edit');
$route->get('admin/add','AdminController@add');