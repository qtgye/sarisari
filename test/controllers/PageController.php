<?php 

/**
* Page Controller
*/
class PageController extends Controller
{

	
	function __construct()
	{
		/**
		 * Temporarily read data from a json file
		 * Update this once backend is ok
		 */
		$locations = array();
		$locations_file = APP_PATH . '/locations.json';
		if ( is_readable($locations_file) ) {
			try {
				$locations = (string) file_get_contents($locations_file);
				$locations = json_decode($locations);
			} catch( Exception $e ) {
				Log::append('The file <strong>'.$locations_file.'</strong> is not existing or is not readable.');
			}
		}

		$this->locations = array();
		foreach ($locations as $location) {
			$params = array(
						$location->name,
						$location->title,
						$location->x,
						$location->y);
			array_push($this->locations, model('Location',$params));
		}
	}

	public function index()
	{
		$locations = $this->locations;
		View::render('public/index',compact('locations'));
	}
}