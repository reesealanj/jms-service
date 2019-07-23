<?php
	require "../includes/db-conn.inc.php";

	$service = $_GET['s'];
	$part = $_GET['p'];
	$type = $_GET['t'];

	$query = "DELETE FROM ticketlines WHERE ticketid=" . $service . " AND partnumber=" . $part . " AND itemtype=" . $type . " LIMIT 1";
	$run = mysqli_query($conn, $query);

	header("Location: add-service.php?id=" . $service);
?>