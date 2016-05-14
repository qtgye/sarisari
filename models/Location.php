<?php 

/**
* Location Class
*/
class Location extends Model
{
	private $defaults = array(
		'name' => '',
		'title' => '',
		'x' => 0,
		'y' => 0,
	);

	private $map = array();
	
	function __construct($args = array())
	{
		parent::__construct();

		$this->map = array(
			'width' => 531,
			'height' => 877,
		);

		$args = array_merge($this->defaults,$args);	

		$this->name = $args['name'];
		$this->title = !empty($args['title']) ? $args['title'] : ucfirst($args['name']);

		// absolute coordinates
		$this->x = $args['x'];
		$this->y = $args['y'];

		// relative coordinates
		$this->pX = (100 * $this->x / $this->map['width']) . '%'; // as in percentage X
		$this->pY = (100 * $this->y / $this->map['height']) . '%'; // as in percentage Y
	}


	public static function create ($args = array())
	{
		return new self($args);
	}

}