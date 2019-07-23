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
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-dark navbar-expand-sm">
		<a href="../index.php" class="navbar-brand">JMS Service</a>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col my-5 mx-5">
				<div class="card">
					<div class="card-header">
						<h3 class="text-center">Claim Your Account</h3>
					</div>
					<div class="card-body">
						<form action="" method="post">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="fname">First Name</label>
									<input type="text" class="form-control" name="fname" placeholder="First Name">
								</div>
								<div class="form-group col-md-6">
									<label for="lname">Last Name</label>
									<input type="text" class="form-control" name="lname" placeholder="Last Name">
								</div>
								<div class="form-group col-md-6">
									<label for="username">Email/Phone Number</label>
									<input type="text" class="form-control" name="contact" placeholder="Email/Phone">
								</div>
							</div>
							<div class="form-row">
								<p class="card-text text-muted text-center">
									The contact information can be either the email or the phone number you gave at the shop. Set your own personal username and password below. 
								</p>
							</div>
							<div class="form-row mt-4">
								<div class="form-group col-md-6">
									<label for="username">Set Username</label>
									<input type="text" class="form-control" name="username" placeholder="Username">
								</div>
							</div>
							<div class="form-row mt-4">
								<div class="form-group col-md-6">
									<label for="password">Set Password</label>
									<input type="password" class="form-control" name="password" placeholder="Password">
								</div>
								<div class="form-group col-md-6">
									<label for="reppassword">Repeat Password</label>
									<input type="password" class="form-control" name="reppassword" placeholder="Repeat Password">
								</div>
								<div class="form-row">
								<p class="card-text text-muted text-center">
									Set your own personal username and password which you will use to log into the system in the future.
								</p>
							</div>
							</div>
							<div class="form-row mt-4">
								<div class="form-group col align-self-center my-2">
									<button type="submit" class="btn btn-success btn-block" name="claim-submit">Claim Account</button>
								</div>
							</div>
						</form>
					</div>
					<?php
						if(isset($_POST['claim-submit'])){
							$username = $_POST['username'];
							$contact = $_POST['contact'];
							$pwd = $_POST['password'];
							$rep_pwd = $_POST['reppassword'];
							$fname = $_POST['fname'];
							$lname = $_POST['lname'];
							//check verification info was inputted
							if( empty($fname)||empty($lname) || empty($contact)){
								echo "<div class='col col-auto alert alert-danger text-center mx-1 my-1' role='alert'>You must fill in verification information!</div>";
								exit();
							}
							//check passwords match
							if($pwd != $rep_pwd){
								echo "<div class='col col-auto alert alert-danger text-center mx-1 my-1' role='alert'>Try Again! Provided Passwords Don't Match!</div>";
								exit();
							}
							//verify username is not taken
							$query = "SELECT * FROM users WHERE username='" . $username . "'";
							$run = mysqli_query($conn, $query);
							if(mysqli_num_rows($run) > 0){
								echo "<div class='col col-auto alert alert-danger text-center mx-1 my-1' role='alert'>That username is already taken! Try again!</div>";
								exit();
							}
							//Check that account is in system
							$query = "SELECT * FROM users WHERE fname='" . $fname . "' AND lname='".$lname."' AND (email='" . $contact . "' OR phone='" . $contact . "')";
							$run = mysqli_query($conn, $query);
							if(mysqli_num_rows($run) == 0){
								echo "<div class='col col-auto alert alert-danger text-center mx-1 my-1' role='alert'>The Verification information doesn't match anything in the system!</div>";
								exit();
							}

							//verify account has not been claimed
							if(mysqli_num_rows($run) == 1){
								$result = mysqli_fetch_assoc($run);
								if($result['password'] != NULL){
									echo "<div class='col col-auto alert alert-danger text-center mx-1 my-1' role='alert'>An Account with that information has already been claimed! <a href='../index.php' class='alert-link'>Click here to log in!</a></div>";
									exit();
								}

								$hash = password_hash($pwd, PASSWORD_DEFAULT);

								$update = "UPDATE users SET password='" . $hash ."' WHERE userid=" . $result['userid'];
								$update2 = "UPDATE users SET username='" . $username ."' WHERE userid=" . $result['userid'];
								$run2 = mysqli_query($conn, $update2);
								$run = mysqli_query($conn, $update);
								echo "<div class='col col-auto alert alert-success text-center mx-1 my-1' role='alert'>Success! Your account has been claimed. <a href='../index.php' class='alert-link'>Click here to log in!</a></div>";
									exit();
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</body>