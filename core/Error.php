<?php 

function custom_error_handler($errno, $errstr, $errfile, $errline)
{
	$msg = "<div>
			<strong>{$errstr}</strong><br>
			<em>{$errfile}</em>, <em>line {$errline}</em>
			</div>";

	Log::append($msg);
	echo $msg; exit();
}

set_error_handler('custom_error_handler');