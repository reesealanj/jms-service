<?php
	include "header.php";
?>
<div class="container container-fluid">
	<div class="row">
		<div class="col col-12">
			<div class="card my-5">
				<div class="card-header">
					<nav class="navbar navbar-light bg-light">
						<a class="navbar-brand"><b>User Search</b></a>
						<form action="" class="form-inline" method="post">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="user-query">
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="search-submit">Search</button>
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="display-all">Display All</button>
    						<a href="newuser.php" class="btn btn-success" role="button">Create New User</a>
						</form>
					</nav>
					<p class="card-text text-muted text-right">
						Search for a User by Name, Username, or UserID number.
					</p>
				</div>
				<div class="card-body">
						<?php
							if(isset($_POST['search-submit'])){

								$table = "";

								$input = $_POST['user-query'];
								$query = "SELECT * FROM users WHERE username LIKE '%{$input}%' OR fname LIKE '%{$input}%' or lname LIKE '%{$input}%' or userid LIKE '%{$input}%' ORDER BY role desc";
								$run = mysqli_query($conn, $query);
								if(mysqli_num_rows($run) > 0){
									$rows = mysqli_num_rows($run);
									$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $rows . " users.</caption>
													<thead>
														<tr>
															<th>UserID</th>
															<th>Name</th>
															<th>Username</th>
															<th>System Role</th>
															<th>Email</th>
															<th>Phone</th>
															<th>Actions</th>
														</tr>
													</thead>
												<tbody>";

									while($row = mysqli_fetch_assoc($run)){
										$userid = $row['userid'];
										$fname = $row['fname'];
										$lname = $row['lname'];
										$username = $row['username'];
										$role = $row['role'];
										$phone = $row['phone'];
										$email = $row['email'];

										$role_word = "";
										if($role == 0){
											$role_word = "System Administrator";
										}
										if($role == 1){
											$role_word = "Superuser";
										}
										if($role == 2){
											$role_word = "Service Employee";
										}
										if($role == 3){
											$role_word = "Sales Employee";
										}
										if($role == 4){
											$role_word = "Customer";
										}

										$table .= "
										<tr>
											<td>".$userid."</td>
											<td>".$fname." " .$lname."</td>
											<td>".$username."</td>
											<td>".$role_word."</td>
											<td>".$email."</td>
											<td>".$phone."</td>
											<td>
												<a class='btn btn-warning btn-sm mx-0 my-1' href='edit-user.php?user=" .$userid. "' role='button'>Edit</a>
											</td>
										</tr>\n
										";

									}

									$table .= "</tbody></table></div></div>";
									echo $table;
								}
							}

							if(isset($_POST['display-all'])){
								$table = "";
								$input = "";

								$query = "SELECT * FROM users WHERE username LIKE '%{$input}%' OR fname LIKE '%{$input}%' or lname LIKE '%{$input}%' or userid LIKE '%{$input}%' ORDER BY role desc";
								$run = mysqli_query($conn, $query);
								if(mysqli_num_rows($run) > 0){
									$rows = mysqli_num_rows($run);
									$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying all " . $rows . " users.</caption>
													<thead>
														<tr>
															<th>UserID</th>
															<th>Name</th>
															<th>Username</th>
															<th>System Role</th>
															<th>Email</th>
															<th>Phone</th>
															<th>Actions</th>
														</tr>
													</thead>
												<tbody>";

									while($row = mysqli_fetch_assoc($run)){
										$userid = $row['userid'];
										$fname = $row['fname'];
										$lname = $row['lname'];
										$username = $row['username'];
										$role = $row['role'];
										$phone = $row['phone'];
										$email = $row['email'];

										$role_word = "";
										if($role == 0){
											$role_word = "System Administrator";
										}
										if($role == 1){
											$role_word = "Superuser";
										}
										if($role == 2){
											$role_word = "Service Employee";
										}
										if($role == 3){
											$role_word = "Sales Employee";
										}
										if($role == 4){
											$role_word = "Customer";
										}

										$table .= "
										<tr>
											<td>".$userid."</td>
											<td>".$fname." " .$lname."</td>
											<td>".$username."</td>
											<td>".$role_word."</td>
											<td>".$email."</td>
											<td>".$phone."</td>
											<td>
												<a class='btn btn-warning btn-sm mx-0 my-1' href='edit-user.php?user=" .$userid. "' role='button'>Edit</a>
											</td>
										</tr>\n
										";

									}

									$table .= "</tbody></table></div></div>";
									echo $table;
								}
							}
						?>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="col col-12 align-self-center">
			<?php
				if(isset($_GET['delete'])){
					if($_GET['delete'] == "success"){
						echo "<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>
								User Successfully Deleted 
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							  </div>";
					}
				}
			?>
		</div>
	</div>
</div>
<?php
	include "footer.php";
?>