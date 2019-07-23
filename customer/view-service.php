<?php 
	require "header.php";

	if(!isset($_GET['id'])){
		header("Location: services.php");
	}

	$service = $_GET['id'];
	$query = "SELECT * FROM services WHERE serviceid=" . $service;
	$run = mysqli_query($conn, $query);

	if(mysqli_num_rows($run) < 1){
		header("Location: services.php");
	}

	$boat = 0;
	$engines = 0;

	$service_row = mysqli_fetch_assoc($run);

	if($service_row['boatid'] != NULL){
		$boat = 1;
	}
	if($service_row['engine1'] != NULL && $service_row['engine1'] != 0){
		$engines++;
	}
	if($service_row['engine2'] != NULL && $service_row['engine2'] != 0){
		$engines++;
	}
	if($service_row['engine3'] != NULL && $service_row['engine3'] != 0){
		$engines++;
	}

	$customer = $service_row['customer'];
	if($customer != NULL && $customer != 0){
		$query = "SELECT * FROM users WHERE userid=" . $customer;
		$run_cust = mysqli_query($conn, $query);
		$customer_row = mysqli_fetch_assoc($run_cust);
	}
	
	$employee = $service_row['employee']; 
	$query = "SELECT * FROM users WHERE userid=" . $employee;
	$run_emp = mysqli_query($conn, $query);
	$employee_row = mysqli_fetch_assoc($run_emp);

	$trailer = $service_row['trailerid'];
	if($trailer != NULL && $trailer != 0){
		$query = "SELECT * FROM trailers WHERE trailerid=" . $trailer;
		$run_trailer = mysqli_query($conn, $query);
		$trailer_row = mysqli_fetch_assoc($run_trailer);
	}

	$boat = $service_row['boatid'];
	if($boat != NULL && $boat != 0){
		$query = "SELECT * FROM boats WHERE boatid=" . $boat;
		$run_boat = mysqli_query($conn, $query);
		$boat_row = mysqli_fetch_assoc($run_boat);
	}

	$lines = $service_row['serviceid'];
	$query = "SELECT * FROM ticketlines WHERE ticketid=" . $lines . " ORDER BY itemtype ASC";
	$run_lines = mysqli_query($conn, $query);
	//Now I have $employee_row, $customer_row, $service_row, and $lines_row


	$status_num = $service_row['status'];
	$status_word = "";

	if($status_num == 0){
		$status_word = "Service In Progress";
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

?>
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card my-4">
				<div class="card-header">
					<b>Service Information</b>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Service ID:</b> <?php echo $service_row['serviceid']; ?>
						</li>
						<li class="list-group-item">
							<?php
							if($customer == NULL || $customer == 0){
								echo "<b>No Customer Listed</b>";
							}
							else {
								echo "<b>Customer Name: </b>" . $customer_row['fname'] ." " . $customer_row['lname']; 
							}
							?>
						</li>
						<li class="list-group-item">
							<b>Date Recieved:</b> <?php echo $service_row['recieved']; ?>
						</li>
						<li class="list-group-item">
							<b>Current Status:</b> <?php echo $status_word; ?> 
						</li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col">
			<div class="card my-4">
				<div class="card-header">
					<b>Boat Information</b>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
					<?php
						if(($status_num == 6) && ($boat == NULL || $boat == 0)){
							echo "<li class='list-group-item'>No Boat Listed</li>";
						}
						else{
							$output = "
							<li class='list-group-item'>
								<b>Vin:</b>
							" . $boat_row['vin'] . "
							</li>
							<li class='list-group-item'>
								<b>Make: </b>
							" . $boat_row['make'] . "
							</li>
							<li class='list-group-item'>
								<b>Model:</b>
							" . $boat_row['model'] . "
							</li>
							<li class='list-group-item'>
								<a href='view-boat.php?id=" . $boat_row['boatid'] . "
							' class='btn btn-info btn-sm' role='button'>View</a>
							</li>
							";

							echo $output;
						}
					?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card my-4">
				<div class="card-header">
					<b>Engine Information</b>
					(<?php echo $engines;?> on boat)
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php
							if($engines >= 1){
								echo "<li class='list-group-item'><a href='view-motor.php?id={$service_row['serviceid']}&e=1' class='btn btn-info btn-sm mx-1'>Engine 1</a></li>";
							}
							if($engines >= 2){
								echo "<li class='list-group-item'><a href='view-motor.php?id={$service_row['serviceid']}&e=2' class='btn btn-info btn-sm mx-1'>Engine 2</a></li>";
							}
							if($engines >= 3){
								echo "<li class='list-group-item'><a href='view-motor.php?id={$service_row['serviceid']}&e=3' class='btn btn-info btn-sm mx-1'>Engine 3</a></li>";
							}
							if(($engines == 0) && ($status_num == 6)){
								echo "<li class='list-group-item'>No Engines Listed</li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card my-4">
				<div class="card-header">
					<b>Trailer Information</b>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
					<?php
						if(($trailer == NULL || $trailer == 0) && $status_num == 6){
							echo "<li class='list-group-item'>No Trailer Listed</li>";
						}
						if($trailer != NULL && $trailer != 0){
							echo "<li class='list-group-item'>
								<b>Vin:</b>
							" . $trailer_row['vin'] . "
							</li>
							<li class='list-group-item'>
								<b>Make: </b>
							" . $trailer_row['make'] . "
							</li>
							<li class='list-group-item'>
								<b>Model:</b>
							" . $trailer_row['model'] . "
							</li>
							<li class='list-group-item'>
								<a href='view-trailer.php?id=" . $service_row['serviceid'] . "
							' class='btn btn-info btn-sm' role='button'>View</a>
							</li>
							";
						}
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
		$parts = "SELECT * FROM ticketlines WHERE ticketid=" . $lines . " AND itemtype=1";
		$run = mysqli_query($conn, $parts);
		$service = "SELECT * FROM ticketlines WHERE ticketid=" . $lines . " AND itemtype=0";
		$run2 = mysqli_query($conn, $service);
	?>
	<div class="row">
		<div class="col col-12">
			<div class="card my-3">
				<div class="card-header">
					<h2>Ticket Contents <span class="badge badge-primary badge-pill"><?php echo mysqli_num_rows($run2); ?></span><span class="badge badge-secondary badge-pill mx-2"><?php echo mysqli_num_rows($run);?></span></h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php
							$parts_total = 0.0;
							$hours_total = 0.0;

							while($lines_row = mysqli_fetch_assoc($run_lines)){
								switch ($lines_row['itemtype']){
									case(1):
										//This is a part
										$partnum = $lines_row['partnumber'];
										$query = "SELECT * FROM partitems WHERE partnumber=" . $partnum;
										$run = mysqli_query($conn, $query);
										$part_info = mysqli_fetch_assoc($run);
										$parts_total += $part_info['partcost'];
										$line = "<li class='list-group-item'><b>Part:</b> " . $part_info['partname'] . " ($" . $part_info['partcost'] . ")";
										if($lines_row['hours'] != NULL){
											$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Hours:</b> " . $lines_row['hours'];
											$hours_total += $lines_row['hours'];
										}
										if($lines_row['comments'] != NULL){
											$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:</b> " . $lines_row['comments'] . "</li>";
										}
										else{
											$line .="</li>";
										}
										echo $line;
										break;

									case(0):
										//This is a service item
										$servicenum = $lines_row['partnumber'];
										$query = "SELECT * FROM servicelines WHERE itemid= " . $servicenum;
										$run = mysqli_query($conn, $query);
										$line_info = mysqli_fetch_assoc($run);
										$line = "<li class='list-group-item'><b>Labor: </b>" . $line_info['description'];
										if($lines_row['comments'] != NULL){
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
					<h5>Total Cost in Parts: $<?php echo$parts_total;?> || Total Labor Hours: <?php echo $hours_total;?></h5>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require "footer.php";
?>