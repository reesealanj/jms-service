<?php
	$server = "localhost";
	$database = "jms-service";
	$username = "root";
	$password = "";

	$conn = mysqli_connect($server, $username, $password, $database);

	if(!$conn){
		die("Database Connection Error: " . mysqli_connect_error());
	}