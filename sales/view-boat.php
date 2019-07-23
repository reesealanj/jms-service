<?php
	require "header.php";

	if(!isset($_GET['id'])){
		header("Location: services.php?error=nbc");
	}
	else{
		$boat = $_GET['id'];
		$query = "SELECT * FROM boats WHERE boatid=" . $boat;
		$run = mysqli_query($conn, $query);

		if(mysqli_num_rows($run) < 1){
			header("Location: services.php?error=bne");
		}

		$boat_row = mysqli_fetch_assoc($run);
		$customer = $boat_row['customer'];
		$query = "SELECT * FROM users WHERE userid=" . $customer;
		$run = mysqli_query($conn, $query);
		$customer_row = mysqli_fetch_assoc($run);

		$query = "SELECT * FROM services WHERE boatid=" . $boat . " AND customer="  . $customer;
		$run = mysqli_query($conn, $query);
		$service_row = mysqli_fetch_assoc($run);
		$service = $service_row['serviceid'];
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
	<!-- Current Customer Information -->
	<div class="row">
		<div class="col col-12 mt-4">
			<div class="card my-1">
				<div class="card-header">
					<h2>Service Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Service ID:</b> <?php echo $service_row['serviceid']; ?>
						</li>
						<li class="list-group-item">
							<b>Customer Name:</b> <?php echo $customer_row['fname']; echo " "; echo $customer_row['lname']; ?>
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
		<div class="col col-12 mt-2">
			<div class="card mt-1">
				<div class="card-header">
					<h2>Boat Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Make: </b> <?php echo $boat_row['make']; ?>
						</li>
						<li class="list-group-item">
							<b>Model: </b> <?php echo $boat_row['model']; ?>
						</li>
						<li class="list-group-item">
							<b>Engine Hours: </b> <?php echo $service_row['hours']; ?>
						</li>
						<li class="list-group-item">
							<b>Year: </b> <?php echo $boat_row['year']; ?>
						</li>
						<li class="list-group-item">
							<b>VIN: </b> <?php echo $boat_row['vin']; ?>
						</li>
						<li class="list-group-item">
							<b>Engine Size: </b> <?php echo $boat_row['engine_size']; ?>
						</li>
						<li class="list-group-item">
							<b>Color: </b> <?php echo $boat_row['color']; ?>
						</li>
					</ul>
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