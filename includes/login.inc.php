<?php
	//If the login button was pressed
	if(isset($_POST['login-submit'])){
		//Execute Login Script
		require "db-conn.inc.php";
		session_start();

		$user = $_POST['username'];
		$pwd = $_POST['pwd'];

		if(empty($user) || empty($pwd)){
			//Missing one or Both Fields
			header("Location: ../index.php?error=1");
			exit();
		}

		$query = "SELECT * FROM users WHERE username='" . $user . "'";
		$run_query = mysqli_query($conn, $query);

		if(mysqli_num_rows($run_query) < 1){
			header("Location: ../index.php?error=3");
			exit();
		}

		$result = mysqli_fetch_assoc($run_query);
		$hash = $result['password'];
		$role = $result['role'];
		$userid = $result['userid'];

		if(password_verify($pwd, $hash)){
			//Login is Confirmed, Assign session variables
			$_SESSION['userid'] = $userid;
			$_SESSION['role'] = $role;
			//Redirect based on role
			//SYSTEM ADMINISTRATOR
			if($role == 0){
				header("Location: ../syst-admin/index.php");
				exit();
			}
			//SUPERUSER
		    else if($role == 1){
		      header("Location: ../superuser/index.php");
		      exit();
		    }
		    //SERVICE EMPLOYEE
		    else if($role == 2){
		      header("Location: ../sales/index.php");
		      exit();
		    }
		    //SALES EMPLOYEE
		    else if($role == 3){
		      header("Location: ../service/index.php");
		      exit();
		    }
		    //CUSTOMER
		    else if($role == 4){
		      header("Location: ../customer/index.php");
		      exit();
		    }
		}
		else {
			header("Location: ../index.php?error=2");
			exit();
		}
	}
	//Else redirect to home page
	else{
		header("Location: ../index.php");
	}
?>