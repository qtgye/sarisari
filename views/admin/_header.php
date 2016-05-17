<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Panel</title>

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?= app_path('vendor/Materialize/dist/css/materialize.min.css') ?>">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= app_path('css/admin/main.css') ?>">

</head>
<body>

	<div class="container">

		<div class="row">
			<nav class="red">
			    <div class="nav-wrapper red">
			      <div class="col"><a href="<?= app_path('/admin') ?>" class="brand-logo">Admin Panel</a></div>
			      <ul class="right">
			        <li><a href="<?= app_path('admin/add') ?>"><i class="material-icons">add</i></a></li>
			      </ul>
			    </div>
			  </nav>
		</div>
		

	
	
