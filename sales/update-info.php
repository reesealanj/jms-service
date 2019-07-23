<?php
	session_start();
	require "../includes/db-conn.inc.php";

	if(isset($_POST['update'])){
		$email = $_POST['inputEmail'];
		$phone = $_POST['inputPhone'];

		$query = " ";

		if(!empty($email)){
			$query .= "UPDATE users SET email='" . $email . "' WHERE userid=" . $_SESSION['userid'] . ";";
		}
		if(!empty($phone)){
			$query .= "UPDATE users SET phone='". $phone ."' WHERE userid=" . $_SESSION['userid'] . ";";
		}

		mysqli_multi_query($conn, $query);
		header("Location: index.php");
		exit();
	}
	else{
		header("Location: index.php");
		exit();
	}