<?php
	require "header.php";
?>
<div class="container container-fluid">
	<div class="row">
		<div class="col-12 col">
			<div class="card my-4">
				<div class="card-header">
					<h3>Service History</h3>
				</div>
				<div class="card-body">
				<?php
					$user = $_SESSION['userid'];
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE s.customer=" . $user . " AND u.userid=s.customer ORDER BY recieved";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) == 0){
						echo "<h3 class='text-muted text-center'>There are no services matching your search</h3>";
					}
					else{
						$table = " ";
						$rows = mysqli_num_rows($run);
						$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $rows . " Services.</caption>
													<thead>
														<tr>
															<th>Service ID</th>
															<th>Customer ID</th>
															<th>Customer Name</th>
															<th>Service Status</th>
															<th>Start Date</th>
															<th>Finish Date</th>
															<th>Actions</th>
														</tr>
													</thead>
												<tbody>";
						while ($row = mysqli_fetch_assoc($run)){
							$customer = $row['customer'];
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
								<td>" . $customer . "</td>
								<td>".$cust_fname." " .$cust_lname."</td>
								<td>" . $status_word . "</td>
								<td>" . $start . "</td>
								<td>" . $finish . "</td>
								<td>";
								$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>View</a>";
								$table.=	"
								</td>
							</tr>\n
							";
						}
						$table .= "</tbody></table></div></div>";
									echo $table;
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	require "footer.php";
?>