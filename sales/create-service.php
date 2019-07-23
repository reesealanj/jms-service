<?php
session_start();
	require "../includes/db-conn.inc.php";

	$query = "INSERT INTO services (employee, recieved, status) VALUES (". $_SESSION['userid']. ", CURDATE(), 0)";
	$run = mysqli_query($conn, $query);

	$select = "SELECT * FROM services WHERE employee=" . $_SESSION['userid'] . " AND recieved=CURDATE() AND status=0";
	$run = mysqli_query($conn, $select);
	$row = mysqli_fetch_assoc($run);

	header("Location: view-service.php?id=" . $row['serviceid']);
