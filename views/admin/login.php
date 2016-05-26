<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?= app_path('vendor/Materialize/dist/css/materialize.min.css') ?>">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="<?= app_path('vendor/font-awesome/css/font-awesome.min.css') ?>">

	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= app_path('css/admin/main.css') ?>">

</head>
<body>
	
	<div class="valign-wrapper auth-wrap">
	  <form class="valign auth-block" method="post" action="<?= app_path('/api/login') ?>">
	  	<div class="row">
	  		<div class="card">
  				<div class="card-content">
  					
					<h5 class="grey-text">
						Login
					</h5>

					<br>

					<div class="row">
						<div class="input-field col s12">
				          <input name="username" id="first_name" type="text" class="validate">
				          <label for="first_name">Username</label>
				        </div>
					</div>

					<div class="row">
						<div class="input-field col s12">
				          <input name="password" id="first_name" type="password" class="validate">
				          <label for="first_name">Password</label>
				        </div>
					</div>

					<div class="row">
						<div class="col s12">
							&nbsp;
							<?php if ( Session::get('error') ): ?>
								<span class="red-text"><?= Session::get('error') ?></span>
							<?php endif ?>
						</div>
					</div>

  				</div>
  				<div class="card-action">
  					<button type="submit" class="btn">Login</button>
	            </div>
  			</div>
	  	</div>
	  </form>
	</div>

	<!-- VENDOR JS -->
	<script src="<?= app_path('vendor/jquery/dist/jquery.min.js')?>"></script>
	<script src="<?= app_path('vendor/Materialize/dist/js/materialize.min.js')?>"></script>

</body>
</html>