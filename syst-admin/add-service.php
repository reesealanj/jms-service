<?php
	require "header.php";
	if(!isset($_GET['id'])){

	}
	else{
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);
		$service_row = mysqli_fetch_assoc($run);

		$customer = $service_row['customer'];
		$query = "SELECT * FROM users WHERE userid=" . $customer;
		$run = mysqli_query($conn, $query);
		$customer_row = mysqli_fetch_assoc($run);

		$query = "SELECT * FROM ticketlines WHERE ticketid=" . $service;
		$run_line_items = mysqli_query($conn, $query);

		$parts = "SELECT * FROM ticketlines WHERE ticketid=" . $service . " AND itemtype=1";
		$run_parts = mysqli_query($conn, $parts);

		$services = "SELECT * FROM ticketlines WHERE ticketid=" . $service . " AND itemtype=0"; 
		$run_service = mysqli_query($conn, $services);

		$parts_total = 0.0;

		$status_num = $service_row['status'];
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
	}
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-2 mt-2">
			<a href="view-service.php?id=<?php echo $service;?>" class="btn-info btn" role="button">Back</a>
		</div>
	</div>
	<div class="row">
		<div class="col col-12">
			<div class="card my-2">
				<div class="card-header">
					<h2>Current Ticket Items <span class="badge badge-primary badge-pill"><?php echo mysqli_num_rows($run_service); ?></span><span class="badge badge-secondary badge-pill mx-2"><?php echo mysqli_num_rows($run_parts);?></span></h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
					<?php
					$line = "";

					while($lines_row = mysqli_fetch_assoc($run_line_items)){
						switch($lines_row['itemtype']){
							//case 1 -- Part Line
							case(1):
								$part_number = $lines_row['partnumber'];
								$query = "SELECT * FROM partitems WHERE partnumber=" . $part_number;
								$run = mysqli_query($conn, $query);
								$part_info = mysqli_fetch_assoc($run);

								$parts_total += $part_info['partcost'];
								$line = "<li class='list-group-item'><a href='remove-line-item.php?s=" . $service . "&p=" . $part_info['partnumber'] . "' class='btn btn-sm btn-danger mr-1' role='button'>x</a><b>Part:</b> " . $part_info['partname'] . " ($" . $part_info['partcost'] . ")";
								if($lines_row['comments'] != NULL){
									$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:</b> " . $lines_row['comments'] . "</li>";
								}
								else{
									$line .="</li>";
								}

								echo $line;
								break;
							case(0):
								$service_number = $lines_row['partnumber'];
								$query = "SELECT * FROM servicelines WHERE itemid=" . $service_number;
								$run = mysqli_query($conn, $query);
								$line_info = mysqli_fetch_assoc($run);

								$line = "<li class='list-group-item'><b>Labor: </b>" . $line_info['description'];
								if($lines_info['comments'] != NULL){
									$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:</b> " . $lines_row['comments'] . "</li>";
								}
								else{
									$line .="</li>";
								}

								echo $line;
								break;
						}
					}
					?>
					</ul>
				</div>
				<div class="card-footer">
					<h5>Total Cost in Parts: $<?php echo $parts_total; ?></h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-6">
			<div class="card">
				<div class="card-header">
					<h3>Service/Labor</h3>
				</div>
				<div class="card-body col-12 align-text-center">
					<a href="new-service-item.php" role="button" class="btn btn-success btn-block">Create New</a>
					<form action="" class="my-2 form-inline" method="post">
						<input type="search" class="form-control col-9 ml-auto" placeholder="Search" aria-label="search" name="user-query-service">
						<button class="btn btn-info btn-sm col-2 ml-auto" type="submit" name="search-service">Search</button>
					</form>
			<?php
				if(isset($_POST['search-service'])){
					$table = "";

					$search = $_POST['user-query-service'];
					$query = "SELECT * FROM servicelines WHERE description LIKE '%{$search}%' ORDER BY itemid DESC";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) > 0){
						$table .= "
						<div class='container'>
							<div class='table-responsive'>
								<table class='table table-hover'>
									<caption>Displaying " . mysqli_num_rows($run) . " parts.</caption>
									<thead>
										<tr>
											<th>Description</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
						\n";

						while($table_row = mysqli_fetch_assoc($run)){
							$name = $table_row['description'];

							$table .= "
							<tr>
								<td>" . $name . "</td>
								<td>
									<a class='btn btn-warning btn-sm mx-0 my-1' href='edit-service-item.php?id=" . $table_row['itemid'] . "' role='button'>Edit</a>
									<a class='btn btn-success btn-sm mx-0 my-1' href='add-service-line.php?s=" . $service . "&p=" . $table_row['itemid'] . "' role='button'>Add</a>
								</td>
							\n";
						}

						$table .= "</tbody></table></div></div>";
						echo $table;
					}
					else{
						echo "<h6 class='align-text-center'>There are no Labor Items matching your search.</h6>";
					}
				}

			?>
				</div>
			</div>
		</div>
		<div class="col col-6">
			<div class="card">
				<div class="card-header">
					<h3>Parts</h3>
				</div>
				<div class="card-body col-12">
					<a href="new-part.php" role="button" class="btn btn-success btn-block">Create New</a>
					<form action="" class="my-2 form-inline" method="post">
						<input type="search" class="form-control col-9 ml-auto" placeholder="Search" aria-label="search" name="user-query-parts">
						<button class="btn btn-info btn-sm col-2 ml-auto" type="submit" name="search-parts">Search</button>
					</form>
			<?php
				if(isset($_POST['search-parts'])){
					$table = "";

					$search = $_POST['user-query-parts'];
					$query = "SELECT * FROM partitems WHERE partname LIKE '%{$search}%' ORDER BY partnumber DESC";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) > 0){
						$table .= "
						<div class='container'>
							<div class='table-responsive'>
								<table class='table table-hover'>
									<caption>Displaying " . mysqli_num_rows($run) . " parts.</caption>
									<thead>
										<tr>
											<th>Part Name</th>
											<th>Cost</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
						\n";

						while($table_row = mysqli_fetch_assoc($run)){
							$name = $table_row['partname'];
							$cost = $table_row['partcost'];

							$table .= "
							<tr>
								<td>" . $name . "</td>
								<td>" . $cost . "</td>
								<td>
									<a class='btn btn-warning btn-sm mx-0 my-1' href='edit-part.php?id=" . $table_row['partnumber'] . "' role='button'>Edit</a>
									<a class='btn btn-success btn-sm mx-0 my-1' href='add-part.php?s=" . $service . "&p=" . $table_row['partnumber'] . "' role='button'>Add</a>
								</td>
							\n";
						}

						$table .= "</tbody></table></div></div>";
						echo $table;
					}
					else{
						echo "<h6>There are no Parts matching your search.</h6>";
					}
				}

			?>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-left">
		<div class="col-2 mt-2">
			<a href="view-service.php?id=<?php echo $service;?>" class="btn-info btn" role="button">Back</a>
		</div>
	</div>
</div>
<?php
	require "footer.php";
?>