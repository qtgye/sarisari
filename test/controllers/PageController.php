<?php 

/**
* Page Controller
*/
class PageController extends Controller
{

	
	function __construct()
	{

	}

	public function index()
	{
		View::render('public/index');
	}
}