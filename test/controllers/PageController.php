<?php 

/**
* Page Controller
*/
class PageController
{

	
	function __construct()
	{

	}

	public function index()
	{
		View::render('index');
	}
}