<?php namespace controllers;
use core\view;

/*
 * Page controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Page extends \core\controller{

	/**
	 * Call the parent construct
	 */
	public function __construct(){
		parent::__construct();

		// $this->language->load('welcome');
	}

	/**
	 * Define Index page title and load template files
	 */
	public function index() {
		// $data['title'] = $this->language->get('welcome_text');
		// $data['welcome_message'] = $this->language->get('welcome_message');	
		
		View::render('admin/index');
		
	}


}
