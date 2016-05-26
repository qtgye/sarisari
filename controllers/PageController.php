<?php 

require_once(APP_PATH . '/models/Location.php');

/**
* Page Controller
*/
class PageController extends Controller
{
	public $locations;
	
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
		foreach ($locations as $key => $location) {
			$params = array(
						'id' => $key,
						'name' => $location->name,
						'title' => $location->title,
						'x' => ( 100 * $location->x / 513 ),
						'y' => ( 100 * $location->y / 877 ));
			array_push($this->locations, Location::create($params));
		}

		// $this->locations = Location::all();
		// rsort($this->locations);
	}

	public function index()
	{
		/**
		 * PREPARE FILES TO PRELOAD
		 */

		$assets = scandir(APP_PATH.'/assets');
		$uploads = scandir(APP_PATH.'/uploads');
		$images = array(); 

		// ASSET FILES
		if ( is_array($assets) ) {
		    foreach ($assets as $key => $file) {
		        if ( preg_match('/^[.]+/', $file) ) continue;        
		        $file_path= APP_PATH.'/assets/'.$file;
		        $size = filesize($file_path);
		        $source = app_path('/assets/'.$file);
		        $type = 'IMAGE';
		        array_push($images, compact('source','size','type'));
		    }
		}

		// UPLOADS
		if ( is_array($uploads) ) {
		    foreach ($uploads as $key => $file) {
		        if ( preg_match('/^[.]+/', $file) ) continue;        
		        $file_path= APP_PATH.'/uploads/'.$file;
		        $size = filesize($file_path);
		        $source = app_path('/uploads/'.$file);
		        $type = 'IMAGE';
		        array_push($images, compact('source','size','type'));
		    }
		}

		$this->data['preload'] = array(
		    'files' => $images
		);
		$this->data['preload_json'] = json_encode($this->data['preload']);

		$this->data['locations'] = $this->locations;
		View::render('public/index',$this->data);
	}
}