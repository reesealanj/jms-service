<?php
	require "../includes/db-conn.inc.php";

	$service = $_GET['s'];
	$part = $_GET['p'];
	$type = $_GET['t'];

	$comments = $_POST['comments'];

	$query = "UPDATE ticketlines SET comments='" . $comments . "' WHERE ticketid=" . $service . " AND itemtype=" . $type . " AND partnumber=" . $part;
	$run = mysqli_query($conn, $query);

	echo $comments;

	header("Location: add-service.php?id=" . $service);
?>