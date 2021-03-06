<?php 


// CONSTANTS
define('APP_PATH', dirname(dirname(__FILE__)));
define('CORE_PATH', dirname(__FILE__));

 date_default_timezone_set('Asia/Manila');



/**
 * ===============================================================
 * ENVIRONMENT DEFINED CONSTANTS
 *
 * Change these constants according to the environment.
 * ===============================================================
 */


// ERROR REPORTING
error_reporting(E_ALL);


/**
 * ROUTE_PREFIX
 * 
 * This will be automatically added to the defined routes in cases when
 * the root folder is whithin (a) subfolder thus shown in the URL
 * ending slash is irrelevant, Route ensures it is added
 * 
 * e.g., www.domain.com/base/folder/
 * define('ROUTE_PREFIX', 'base/folder/');
 */

// greenlemon
// define('ROUTE_PREFIX', 'projects/sari-sari/');

// local
define('ROUTE_PREFIX', '');


/**
 * DATABASE CONFIG
 */

// local
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_NAME','sarisari');


