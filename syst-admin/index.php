<?php
	require "header.php";

	$user_id = $_SESSION['userid'];
	$user_query = "SELECT * FROM users WHERE userid=" . $user_id;
	$run_user_query = mysqli_query($conn, $user_query);
	$result = mysqli_fetch_assoc($run_user_query);
	$fname = $result['fname'];

	echo "<div class='jumbotron'>
			<h1 class='display-4'>Welcome, {$result['fname']}</h1>
		  <hr class='my-0'></div>";

?>
<div class="container">
	<div class="row">
		<div class="col col-12">
			<div class="card mt-4">
				<div class="card-header">
						Current Rigging Requests
				</div>
				<div class="card-body">
				<?php
					$query = "SELECT * FROM services WHERE status = 7";
					$run = mysqli_query($conn, $query);
					$open = mysqli_num_rows($run);
					echo "<h5 class='card-title'><span class='badge badge-info'>{$open}</span> Open Rigging Requests</h5><hr class='my-1'>\n";
					if($open == 0){
						echo "<p class='card-text'>There are <b>no</b> open rigging requests</p>";
					}
				?>	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-12">
			<div class="card mt-4">
				<div class="card-header">
						Current Services
				</div>
				<div class="card-body">
				<?php
					$query = "SELECT * FROM services WHERE status != 6";
					$run = mysqli_query($conn, $query);
					$open = mysqli_num_rows($run);
					echo "<h5 class='card-title'><span class='badge badge-info'>{$open}</span> Open Services</h5><hr class='my-1'>\n";
					if($open == 0){
						echo "<p class='card-text'>There are <b>no</b> open service tickets! Click <a href='create-service.php'>here</a> to open a new ticket.</p>";

					}
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE s.status != 6 AND u.userid = s.customer";
					$run = mysqli_query($conn, $query);

					$table = "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $open . " Services.</caption>
													<thead>
														<tr>
															<th>Service ID</th>
															<th>Customer Name</th>
															<th>Service Status</th>
															<th>Start Date</th>
															<th>Actions</th>
														</tr>
													</thead>
												<tbody>";
					while ($row = mysqli_fetch_assoc($run)) {
							$cust_fname = $row['fname'];
							$cust_lname = $row['lname'];
							$serviceid = $row['serviceid'];
							$status_num = $row['status'];
							$start = $row['recieved'];
							$finish = $row['completed'];

							$status_word = "";

							if($status_num == 0){
								$status_word = "Ticket Opened - No Action Taken";
							}
							else if($status_num == 1){
								$status_word = "Service In Progress";
							}
							else if($status_num == 2){
								$status_word = "Service Paused - Waiting For Parts";
							}
							else if($status_num == 3){
								$status_word = "Service Paused - Waiting For Callback";
							}
							else if($status_num == 4){
								$status_word = "Service Completed - Customer Contacted";
							}
							else if($status_num == 5){
								$status_word = "Service Completed - Customer Contacted";
							}
							else if($status_num == 6){
								$status_word = "Ticket Closed - Customer Collected";
							}

							$table .= "
							<tr>
								<td>" . $serviceid . "</td>
								<td>".$cust_fname." " .$cust_lname."</td>
								<td>" . $status_word . "</td>
								<td>" . $start . "</td>
								<td>";
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>View </a>
								</td>
							</tr>\n
							";
						}
						$table .= "</tbody></table></div></div>";
						echo $table;
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-6">
			<div class="card my-4">
				<div class="card-header">
					Contact Information
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
					<?php
						$query = "SELECT * FROM users WHERE userid=" . $_SESSION['userid'];
						$run = mysqli_query($conn, $query);
						$result = mysqli_fetch_assoc($run);

						echo "<li class='list-group-item'>Phone Number: {$result['phone']}</li>\n";
						echo "<li class='list-group-item'>Email: {$result['email']}</li>\n";
					?>
					</ul>
				</div>
				<div class="card-footer text-muted">
					Edit your information with the form to the right.
				</div>
			</div>
		</div>
			<div class="col col-6">
				<div class="card mt-4">
					<div class="card-header">
						Update Contact Information
					</div>
					<div class="card-body">
						<form action="update-info.php" method="post">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail">Email</label>
									<input type="email" class="form-control" name="inputEmail" placeholder="Email">
								</div>
								<div class="form-group col-md-6">
									<label for="inputPhone">Phone Number</label>
									<input type="tel" class="form-control" name="inputPhone" placeholder="Phone Number">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<button type="submit" class="btn btn-success btn-block" name="update">Update</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>	
</div>
<?php
	require "footer.php";
?>