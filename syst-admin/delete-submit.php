<?php
	session_start();
	require "../includes/db-conn.inc.php";


	if(isset($_GET['user'])){
		$user = $_GET['user'];
		$queries = "";
		$queries .= "DELETE FROM boats WHERE customer=" . $user . ";";
		$queries .= "DELETE FROM motors WHERE customer=" . $user . ";";
		$queries .= "DELETE FROM trailers WHERE customer=" . $user . ";"; 
		$queries .= "DELETE FROM services WHERE customer=" . $user . ";";
		$queries .= "DELETE FROM users WHERE userid=" . $user . ";";


		mysqli_multi_query($conn, $queries);
	}

	header("Location: users.php?delete=success");
?>