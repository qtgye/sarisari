<?php 

//create alias for Router
use \core\router,
    \helpers\url;

//define routes
// Router::any('', '\controllers\welcome@index');
// Router::any('/subpage', '\controllers\welcome@subpage');

// //if no route found
// Router::error('\core\error@index');

// //turn on old style routing
// Router::$fallback = false;

Router::any('', '\controllers\Page@index');



// //execute matched routes
Router::dispatch();

