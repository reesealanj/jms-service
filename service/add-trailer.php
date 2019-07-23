<?php 
	require "header.php";

	if(isset($_GET['id'])){
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);

		$service_row = mysqli_fetch_assoc($run);
		$customer = $service_row['customer'];
		$cust_query = "SELECT * FROM users WHERE userid=" . $customer;
		$run_cust = mysqli_query($conn, $cust_query);
		$customer_row = mysqli_fetch_assoc($run_cust);

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
	else{
		header("Location: services.php");
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
	<!-- Add Trailer Information -->
	<div class="row">
		<div class="col col-12 mt-2">
			<div class="card my-1">
				<div class="card-header">
					<h2>Add Trailer to Ticket</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<form action="" method="post">
							<div class="form-row">
								<div class="form-group col-6">
									<label for="make">Make</label>
									<input type="text" class="form-control" name="make" placeholder="Make">
								</div>
								<div class="form-group col-6">
									<label for="model">Model</label>
									<input type="text" class="form-control" name="model" placeholder="Model">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-6">
									<label for="year">Year</label>
									<input type="text" class="form-control" name="year" placeholder="0000">
								</div>
								<div class="form-group col-6">
									<label for="vin">VIN</label>
									<input type="text" class="form-control" name="vin" placeholder="VIN">
								</div>
							</div>
							<div class="form-row justify-content-center">
								<div class="form-group">
									<button class="btn btn-success btn-lg" type="submit" name="trailer-submit">Add Trailer</button>
								</div>
							</div>
						</form>
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
	if(isset($_POST['trailer-submit'])){
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);
		$service_row = mysqli_fetch_assoc($run);

		$customer = $service_row['customer'];

		$make = $_POST['make'];
		$model = $_POST['model'];
		$year = $_POST['year'];
		$vin = $_POST['vin'];

		$insert = "INSERT INTO trailers (customer, make, model, year, vin) VALUES ({$customer}, '{$make}', '{$model}', {$year}, '{$vin}')";
		$run = mysqli_query($conn, $insert);

		$select = "SELECT * FROM trailers WHERE vin='" . $vin . "'";
		$run = mysqli_query($conn, $select);
		$row = mysqli_fetch_assoc($run);

		$update = "UPDATE services SET trailerid=" . $row['trailerid'] . " WHERE serviceid=" . $service;
		$run_update = mysqli_query($conn, $update);
	}

	require "footer.php";
?>