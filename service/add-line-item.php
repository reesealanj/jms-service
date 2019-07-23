<?php
	require "../includes/db-conn.inc.php";

	$service = $_GET['s'];
	$part = $_GET['p'];
	$type = $_GET['t'];

	$query = "INSERT INTO ticketlines (ticketid, itemtype, partnumber) VALUES (" . $service . "," . $type . "," . $part . ")";
	$run = mysqli_query($conn, $query);

	header("Location: add-service.php?id=" . $service);
	?>