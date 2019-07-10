<?php 
	require "header.php";
?>
<div class="container container-fluid">
	<div class="row">
		<div class="col col-12">
			<div class="card my-5">
				<div class="card-header">
					<nav class="navbar navbar-light bg-light">
						<a class="navbar-brand"><b>Service Search</b></a>
						<form action="" class="form-inline" method="post">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="user-query">
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="search-submit">Search</button>
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="display-all">Display All</button>
						</form>
					</nav>
					<p class="card-text text-muted text-right">
						Search for a service by Customer Name or Customer ID number.
					</p>
				</div>
				<div class="card-body">
				<?php
				if(isset($_POST['search-submit'])){
					$table = "";
					$input = $_POST['user-query'];
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE (u.fname LIKE '%{$input}%' OR u.lname LIKE '%{$input}%' OR u.userid LIKE '%{$input}%') AND u.userid = s.customer ORDER BY s.serviceid DESC";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) == 0){
						echo "<h3 class='text-muted text-center'>There are no services matching your search</h3>";
					}
					else{
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
								if($status_num != 6){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>Edit</a>";

								}
								if($status_num == 6){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>View</a>";
								}
								$table.=	"<a class='btn btn-danger btn-sm mx-1 my-1' href='delete-service.php?id=" . $serviceid . "' role='button'>Delete</a>
								</td>
							</tr>\n
							";
						}
						$table .= "</tbody></table></div></div>";
									echo $table;
					}
				}
				else if(isset($_POST['display-all'])){
					$table = "";
					$input = $_POST['user-query'];
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE u.userid = s.customer order by s.serviceid desc";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) == 0){
						echo "<h3 class='text-muted text-center'>There are no services in the system.</h3>";
					}
					else{
						$rows = mysqli_num_rows($run);
						$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying All " . $rows . " Services.</caption>
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
								if($status_num != 6){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>Edit</a>";

								}
								if($status_num == 6){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-service.php?id=" . $serviceid . "' role='button'>View</a>";
								}
								$table.=	"<a class='btn btn-danger btn-sm mx-1 my-1' href='delete-service.php?id=" . $serviceid . "' role='button'>Delete</a>
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
		<div class="col-2 align-self-left mt-0">
			<a href="services.php" class="btn btn-info" role="button">Back</a>
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
	require "footer.php";
?>