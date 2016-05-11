<?php namespace controllers;
use core\view;

/*
 * Location controller
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 2.1
 * @date June 27, 2014
 */
class Location extends \core\controller{

	/**
	 * Call the parent construct
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Define Index page title and load template files
	 */
	public function edit() {
		// $data['title'] = $this->language->get('welcome_text');
		// $data['welcome_message'] = $this->language->get('welcome_message');	
		
		View::render('admin/form');
		
	}


}
