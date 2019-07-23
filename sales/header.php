<?php
	session_start();
	require "../includes/db-conn.inc.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>JMS Service</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-dark navbar-expand-sm">
		<a href="index.php" class="navbar-brand">JMS Service</a>
		<form method="get" action="../includes/logout.inc.php">	
			<button type="submit" class="btn btn-primary btn-sm">
	          <span class="glyphicon glyphicon-log-out"></span> Log out
	        </button>
	    </form>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarMenu">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
				<li class="nav-item"><a href="users.php" class="nav-link">Users</a></li>
				<li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
			</ul>
		</div>
	</nav>