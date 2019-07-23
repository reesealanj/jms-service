<?php
	require "header.php";
?>
<div class="row">
	<div class="col col-6">
		<div class="card mx-4 my-4">
			<div class="card-header">
				Current Information
				<br />
				<small class="text-muted">Update this user's information with the form on the right.</small>
			</div>
			<div class="card-body">
				<ul class="list-group list-group-flush">
					<?php
						if(isset($_GET['user'])){
							$userid = $_GET['user'];
							$query = "SELECT * FROM users WHERE userid=" . $userid;
							$run = mysqli_query($conn, $query);
							if(mysqli_num_rows($run) > 0){
								$result = mysqli_fetch_assoc($run);
								$fname = $result['fname'];
								$lname = $result['lname'];
								$username = $result['username'];
								$email = $result['email'];
								$phone = $result['phone'];

								echo "<li class='list-group-item'><b>First Name: </b> {$fname}</li>\n";
								echo "<li class='list-group-item'><b>Last Name: </b> {$lname}</li>\n";
								echo "<li class='list-group-item'><b>Username: </b> {$username}</li>\n";
								echo "<li class='list-group-item'><b>Email: </b> {$email}</li>\n";
								echo "<li class='list-group-item'><b>Phone Number: </b> {$phone}</li>\n";
							}
							else{
								echo "<li class='list-group-item>No User information Retrievable</li>";
							}
						}
					?>
				</ul>
			</div>
		</div>
		<div class="col-2 align-self-center mt-3">
			<a href="users.php" class="btn btn-info" role="button">Back</a>
		</div>

	</div>
	<div class="col col-6">
		<div class="card mx-4 my-4">
			<div class="card-header">
				Update Information
			</div>
			<div class="card-body">
				<form action="" method="post">
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputFname">First Name</label>
							<input type="text" class="form-control" name= "inputFname" placeholder="First Name">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputLname">Last Name</label>
							<input type="text" class="form-control" name= "inputLname" placeholder= "Last Name">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputUsername">Username</label>
							<input type="text" class="form-control" name="inputUsername" placeholder="Username">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" name= "inputEmail" placeholder="myemail@domain.com">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputPhone">Phone Number</label>
							<input type="text" class="form-control" name = "inputPhone" placeholder="000-000-0000">
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12">
							<button type="submit" class="btn btn-success btn-block" name="update">Update</button>
						</div>
					</div>
				</form>
			<?php
				if(isset($_GET['update'])){
					if($_GET['update'] == "success"){
						echo "<div class='alert alert-success text-center' role='alert'>
								Information Successfully Updated
								<br /><small> All information may not change immediately, refresh the page to check </small>
							  </div>";
					}
				}

			?>
			</div>
		</div>
	</div>
</div>

<?php
	if(isset($_POST['update'])){
		$fname = $_POST['inputFname'];
		$lname = $_POST['inputLname'];
		$username = $_POST['inputUsername'];
		$email = $_POST['inputEmail'];
		$phone = $_POST['inputPhone'];
		$userid = $_GET['user'];


		$queries = "";

		if(!empty($fname)){
			$queries .= "UPDATE users SET fname='" . $fname . "' WHERE userid=" . $userid . ";";
		}
		if(!empty($lname)){
			$queries .= "UPDATE users SET lname='" . $lname . "' WHERE userid=" . $userid . ";";
		}
		if(!empty($username)){
			$queries .= "UPDATE users SET username='" . $username . "' WHERE userid=" . $userid . ";";
		}
		if(!empty($email)){
			$queries .= "UPDATE users SET email='" . $email . "' WHERE userid=" . $userid . ";";
		}
		if(!empty($phone)){
			$queries .= "UPDATE users SET phone='" . $phone . "' WHERE userid=" . $userid . ";";
		}

		mysqli_multi_query($conn, $queries);
		header("Location: edit-user.php?user=" . $userid . "&update=success");
	}


	require "footer.php";
?>