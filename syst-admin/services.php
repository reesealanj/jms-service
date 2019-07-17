<?php
	require "header.php";
?>
<div class="container">
	<div class="row">
		<div class="col col-12">
			<div class="card mt-4">
				<div class="card-header">
					Quick Actions
				</div>
				<div class="card-body">
					<a href="create-service.php" class="btn btn-success  mx-1 my-1" role="button">New Service</a>
					<a href="service-history.php" class="btn btn-success mx-1 my-1" role="button">Service History</a>
					<a href="service-items.php" class="btn btn-info mx-1 my-1" role="button">View Line Items</a>
					<a href="create-service-item.php" class="btn btn-success mx-1 my-1" role="button">Create Line Item</a>
					<a href="part-items.php" class="btn btn-info" role="button mx-1 my-1">View Part Items</a>
					<a href="create-part-item.php" class="btn btn-success mx-1 my-1" role="button">Create Part Items</a>
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
								$status_word = "Service Completed - Customer Not Contacted";
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
</div>
	
<?php
	require "footer.php";
?>