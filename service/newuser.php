<?php
	require "header.php";
?>
<div class="container">
	<div class="row">
		<div class="col-lg align-self-center">
			<div class="card mt-4">
				<div class="card-header text-center">
					<h1 class="display-3">
						Create New User
					</h1>
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
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="phone">Phone Number</label>
									<input type="text" class="form-control" name="phone" placeholder="000-000-0000">
								</div>
								<div class="form-group col-md-6">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" placeholder="myname@domain.com">
								</div>
							</div>
							<div class="form-row align-items-left">
								<div class="form-group col-md-4">
									<label for="userSelect">User Type</label>
									<select name="userSelect" class="custom-select mr-sm-2">
										<option selected>Choose User Type</option>
										<option value="0">System Administrator</option>
										<option value="1">Superuser</option>
										<option value="2">Service Employee</option>
										<option value="3">Sales Employee</option>
										<option value="4">Customer</option>
									</select>
								</div>
							</div>
							<div class="form-row align-self-center">
								<div class="form-group col">
									<button class="btn btn-success col" type="submit" name="create-submit">
										Create User
									</button>
								</div>
							</div>
						</form>
						<div class="row">
					<?php
						if(isset($_POST['create-submit'])){

							$error = 0;

							$fname = $_POST['fname'];
							$lname = $_POST['lname'];
							$phone = $_POST['phone'];
							$email = $_POST['email'];
							$role = $_POST['userSelect'];

							if(empty($fname) || empty($lname)){
								echo "<div class='col col-auto alert alert-danger text-center mx-1' role='alert'>You must fill in all fields!</div>";
								$error = $error + 1;
							}

							if($role ==  "Choose User Type"){
								echo "<div class='col col-auto alert alert-danger text-center mx-1' role='alert'>You must select a user type!</div>";
								$error = $error + 1;
							}

							if($error == 0){
								//There have been no errors, proceed creating a profile
								$query = "INSERT INTO users(fname, lname, email, phone, role) VALUES ('". $fname . "','" . $lname . "','" . $email . "','" . $phone . "'," . $role . ")";
								$run  = mysqli_query($conn, $query);
								echo "<div class='col col-auto alert alert-success text-center mx-1' role='alert'>User Successfully Created!</div>";
							}
						}
					?>
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-2 align-self-left mt-3">
			<a href="users.php" class="btn btn-info" role="button">Back</a>
		</div>
	</div>
</div>
<?php
	require "footer.php";
?>