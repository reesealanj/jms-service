<?php
	require "header.php";
?>
<div class="container">
	<div class="row">
		<div class="col col-9">
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
						echo "<p class='card-text'>There are <b>no</b> open rigging tickets! Click <a href='create-rigging.php'>here</a> to open a new ticket.</p>";

					}
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE s.status = 7 AND u.userid = s.customer";
					$run = mysqli_query($conn, $query);

					$table = "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $open . " Requests.</caption>
													<thead>
														<tr>
															<th>Request ID</th>
															<th>Customer Name</th>
															<th>Ticket Status</th>
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

							$status_word = "Rigging Request - Open";

							$table .= "
							<tr>
								<td>" . $serviceid . "</td>
								<td>".$cust_fname." " .$cust_lname."</td>
								<td>" . $status_word . "</td>
								<td>" . $start . "</td>
								<td>";
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>View </a>
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
		<div class="col col-3">
			<div class="card mt-4">
				<div class="card-header">
					Quick Actions
				</div>
				<div class="card-body">
					<a href="create-rigging.php" class="btn btn-success btn-block mx-1 my-1" role="button">New Request</a>
					<a href="rigging-history.php" class="btn btn-info btn-block mx-1 my-1" role="button">Rigging History</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-9">
			<div class="card mt-2">
				<div class="card-header">
					Closed Rigging Requests
				</div>
				<div class="card-body">
				<?php
					$query = "SELECT * FROM services WHERE status IN (8,9,10)";
					$run = mysqli_query($conn, $query);
					$open = mysqli_num_rows($run);
					echo "<h5 class='card-title'><span class='badge badge-secondary'>{$open}</span> Closed Services</h5><hr class='my-1'>\n";
					
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE s.status IN (8,9,10) AND u.userid = s.customer ORDER BY s.serviceid DESC";
					$run = mysqli_query($conn, $query);

					$table = "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $open . " Requests.</caption>
													<thead>
														<tr>
															<th>Request ID</th>
															<th>Customer Name</th>
															<th>Ticket Status</th>
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

							if($status_num == 8){
								$status_word = "Request Completed - Closed";
							}
							else if($status_num == 9){
								$status_word = "Request Completed with Comment - Closed";
							}
							else if($status_num == 10){
								$status_word = "Request not Completed - Closed";
							}

							$table .= "
							<tr>
								<td>" . $serviceid . "</td>
								<td>".$cust_fname." " .$cust_lname."</td>
								<td>" . $status_word . "</td>
								<td>" . $start . "</td>
								<td>";
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>View </a>
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