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
			$status_word = "Service Completed - Customer Contacted";
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
				<div class="card-footer justify-content-centers">
					<form action="" method="post">
						<button class="btn btn-danger btn-lg" type="submit" name="remove-submit">Remove Boat</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	if(isset($_POST['remove-submit'])){
		$boat = $_GET['id'];
		$queries = "UPDATE services SET boatid=0 WHERE boatid=" . $boat . ";";
		$queries .= "DELETE FROM boats WHERE boatid=" . $boat . ";";

		$run = mysqli_multi_query($conn, $queries);
		header("Location: view-service.php?id=" . $service);
	}

	require "footer.php";
?>