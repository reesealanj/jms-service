<?php
	require "../includes/db-conn.inc.php";

	$service = $_GET['s'];
	$part = $_GET['p'];
	$type = $_GET['t'];

	$hours = $_POST['hours'];

	$query = "UPDATE ticketlines SET hours=" . $hours . " WHERE ticketid=" . $service . " AND itemtype=" . $type . " AND partnumber=" . $part;
	$run = mysqli_query($conn, $query);

	header("Location: add-service.php?id=" . $service);