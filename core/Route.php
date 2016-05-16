<?php 


/**
* Route class
*/
class Route
{


	/**
	 * The request uri string
	 * @var string
	 */
	private $request_uri;


	/**
	 * Array of registered routes
	 * @var array
	 */
	private $routes = array();


	/**
	 * Type of current request method
	 * @var string
	 */
	private $request_method = array();
	

	/**
	 * The construct
	 */
	function __construct()
	{
		$this->request_uri 	= trim(preg_replace('/[?].*$/', '', $_SERVER['REQUEST_URI']),'/');
		$this->request_method 	= $_SERVER['REQUEST_METHOD'];
	}


	/**
	 * Registers a new route
	 * @param  string $request_method GET | POST | etc...
	 * @param  string $pattern URL pattern to match
	 * @param  string $controller_method Controller@method
	 * @return void 
	 */
	private function register_route($pattern, $controller_method,$request_method = 'get')
	{
		global $__filters;
		$__filters = array();

		// Extract controller and method
		$controller_method = explode('@', $controller_method);
		$controller = $controller_method[0];
		$method = !empty($controller_method[1]) ? $controller_method[1] : 'index';
		$pattern = rtrim(ROUTE_PREFIX,'/') .'/'. ltrim($pattern,'/');
		$pattern = trim($pattern,'/');

		$this->routes[$pattern] = compact('request_method','pattern','controller','method');
	}


	/**
	 * match a get request
	 * @param  string $pattern the uri pattern
	 * @param  string $controller_method Controller@method
	 * @return void 
	 */
	public function get($pattern,$controller_method = '')
	{
		$this->register_route( $pattern, $controller_method, 'get' );
	}

	/**
	 * match a post request
	 * @param  string $pattern the uri pattern
	 * @param  string $controller_method Controller@method
	 * @return void 
	 */
	public function post($pattern,$controller_method = '')
	{
		$this->register_route( $pattern, $controller_method, 'post' );
	}


	/**
	 * Runs the controller method for a specified route
	 * @param  object $registerd_route Registered route
	 * @return void 
	 */
	private function execute_controller($registerd_route)
	{		
		$controller_file = dirname(dirname(__FILE__)) .'/controllers/'. $registerd_route['controller'] . '.php';

		if ( is_readable($controller_file) ) {
			require_once($controller_file);
		} else {
			Log::append('The file <strong>' . $controller_file . '</strong> does not exist.'); exit();
		}

		if ( !class_exists($registerd_route['controller']) ) {
			Log::append('The Controller file for <strong>'.$registerd_route['controller'].'</strong> does not exist.'); exit();
		}

		if ( !method_exists($registerd_route['controller'], $registerd_route['method']) ) {
			Log::append('<strong>'.$registerd_route['method'].'</strong> is not a method of class <strong>'.$registerd_route['controller'].'</strong>'); exit();
		}

		$controller = new $registerd_route['controller'];
		call_user_func_array(array($controller,$registerd_route['method']), array());
	}


	/**
	 * Checks for matched route and executes corresponding Controller method
	 * @return void 
	 */
	public function execute_matched()
	{
		// verify pattern
		if ( array_key_exists($this->request_uri, $this->routes) ) {
			// verify request method
			if ( strtolower($this->request_method) == $this->routes[$this->request_uri]['request_method'] ) {
				$this->execute_controller(&$this->routes[$this->request_uri]);				
			}			
		}
	}
}

$route = new Route;
