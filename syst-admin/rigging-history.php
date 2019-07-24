<?php 
	require "header.php";
?>
<div class="container container-fluid">
	<div class="row">
		<div class="col col-12">
			<div class="card my-5">
				<div class="card-header">
					<nav class="navbar navbar-light bg-light">
						<a class="navbar-brand"><b>Rigging Request Search</b></a>
						<form action="" class="form-inline" method="post">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="user-query">
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="search-submit">Search</button>
    						<button class="btn btn-info my-2 mx-1 my-sm-0" type="submit" name="display-all">Display All</button>
						</form>
					</nav>
					<p class="card-text text-muted text-right">
						Search for a request by Customer Name or Customer ID number.
					</p>
				</div>
				<div class="card-body">
				<?php
				if(isset($_POST['search-submit'])){
					$table = "";
					$input = $_POST['user-query'];
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE (u.fname LIKE '%{$input}%' OR u.lname LIKE '%{$input}%' OR u.userid LIKE '%{$input}%') AND u.userid = s.customer AND status IN (7,8,9,10) ORDER BY s.serviceid DESC";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) == 0){
						echo "<h3 class='text-muted text-center'>There are no requests matching your search</h3>";
					}
					else{
						$rows = mysqli_num_rows($run);
						$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying " . $rows . " Requests.</caption>
													<thead>
														<tr>
															<th>Request ID</th>
															<th>Customer ID</th>
															<th>Customer Name</th>
															<th>Ticket Status</th>
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

							if($status_num == 8){
								$status_word = "Request Completed - Closed";
							}
							else if($status_num == 9){
								$status_word = "Request Completed with Comment - Closed";
							}
							else if($status_num == 10){
								$status_word = "Request not Completed - Closed";
							}
							else if($status_num == 7){
								$status_word = "Rigging Request - Open";
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
								if(($status_num != 8) || ($status_num != 9) || ($status_num != 10)){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>Edit</a>";

								}
								if($status_num == 7){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>View</a>";
								}
								$table.=	"
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
					$query = "SELECT s.*, u.fname, u.lname FROM services as s, users as u WHERE u.userid = s.customer AND status IN (7,8,9,10) order by s.serviceid desc";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) == 0){
						echo "<h3 class='text-muted text-center'>There are no requests in the system.</h3>";
					}
					else{
						$rows = mysqli_num_rows($run);
						$table .= "<div class='container'> 
												<div class='table-responsive'>
												<table class='table table-hover'>
												<caption>Displaying All " . $rows . " Requests.</caption>
													<thead>
														<tr>
															<th>Request ID</th>
															<th>Customer ID</th>
															<th>Customer Name</th>
															<th>Ticket Status</th>
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

							if($status_num == 8){
								$status_word = "Request Completed - Closed";
							}
							else if($status_num == 9){
								$status_word = "Request Completed with Comment - Closed";
							}
							else if($status_num == 10){
								$status_word = "Request not Completed - Closed";
							}
							else if($status_num == 7){
								$status_word = "Rigging Request - Open";
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
								if(($status_num != 8) || ($status_num != 9) || ($status_num != 10)){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>Edit</a>";

								}
								if($status_num == 7){
									$table .= "<a class='btn btn-primary btn-sm mx-1 my-1' href='view-rigging.php?id=" . $serviceid . "' role='button'>View</a>";
								}
								$table.=	"
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
</div>

<?php 
	require "footer.php";
?>