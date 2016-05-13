<?php 

/**
* Admin Controller
*/
class AdminController extends Controller
{
	private $data  =array();
	
	function __construct()
	{
		$this->data['page'] = 'index';
	}


	public function index()
	{
		View::render('admin/page',$this->data);
	}
}