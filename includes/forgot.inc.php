<?php
	session_start();
	require "db-conn.inc.php";

	if(isset($_SESSION['userid'])){
		header("Location: ../index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>JMS Service</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		

	</body>
</html>