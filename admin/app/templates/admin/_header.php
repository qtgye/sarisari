<?php 

define('VENDOR_PATH', '/admin/app/templates/admin/vendor/');
define('ASSET_PATH', '/admin/app/templates/admin/assets/');


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Panel</title>

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo VENDOR_PATH . 'Materialize/dist/css/materialize.min.css' ?>">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>

	<div class="container">

		<div class="row">
			<nav class="red">
			    <div class="nav-wrapper">
			      <a href="/admin" class="brand-logo left">Admin Panel</a>
			      <ul class="right">
			        <li><a href="#"><i class="material-icons">add</i></a></li>
			      </ul>
			    </div>
			  </nav>
		</div>
		

	
	
