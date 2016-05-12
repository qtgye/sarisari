<?php 

/**
* Location Class
*/
class Location
{
	
	function __construct($name, $title = '', $x = 0,$y = 0)
	{
		$this->name = $name;
		$this->title = !empty($title) ? $title : ucfirst($name);

		$this->map = array(
			'width' => 531,
			'height' => 877,
		);

		// absolute coordinates
		$this->x = $x;
		$this->y = $y;

		// relative coordinates
		$this->pX = (100 * $this->x / $this->map['width']) . '%'; // as in percentage X
		$this->pY = (100 * $this->y / $this->map['height']) . '%'; // as in percentage Y
	}
}