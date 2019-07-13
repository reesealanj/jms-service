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
			$status_word = "Service Completed - Customer Contacted";
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
	<!-- Add Engine Card -->
	<div class="row">
		<div class="col col-12 mt-2">
			<div class="card my-1">
				<div class="card-header">
					<h2>Add Engine to Ticket</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<form action="" method="post">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="make">Make</label>
									<input type="text" class="form-control" name="make" placeholder="Make">
								</div>
								<div class="form-group col-md-6">
									<label for="model">Model</label>
									<input type="text" class="form-control" name="model" placeholder="Model">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="vin">Vin</label>
									<input type="text" class="form-control" name="vin" placeholder="Vin">
								</div>
								<div class="form-group col-md-6">
									<label for="year">Year</label>
									<input type="text" class="form-control" name="year" placeholder="0000">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="modelno">Model Number</label>
									<input type="text" class="form-control" name="modelno" placeholder="Model Number">
								</div>
							</div>
							<div class="form-row justify-content-center">
								<div class="form-group">
									<button class="btn btn-success btn-lg" type="submit" name="engine-submit">
										Add Engine
									</button>
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
	if(isset($_POST['engine-submit'])){
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);
		$service_row = mysqli_fetch_assoc($run);

		$customer = $service_row['customer'];
		$make = $_POST['make'];
		$model = $_POST['model'];
		$year = $_POST['year'];

		$vin = $_POST['vin'];
		$modelno = $_POST['modelno'];

		$insert = "INSERT INTO motors (customer, make, model, year, vin, modelno) VALUES (". $customer . ",'" . $make . "','" . $model . "'," . $year . ",'" . $vin . "','" . $modelno  . "')";
		$run = mysqli_query($conn, $insert);
		$select = "SELECT * FROM motors WHERE vin='" . $vin . "'";
		$run_select = mysqli_query($conn, $select);
		$row = mysqli_fetch_assoc($run_select);

		$select_service = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $select_service);
		$service_row = mysqli_fetch_assoc($run);

			$engines = 0;
			if($service_row['engine1'] != NULL){
				$engines++;
			}
			if($service_row['engine2'] != NULL){
				$engines++;
			}
			if($service_row['engine3'] != NULL){
				$engines++;
			}

			if($engines == 0){
				$update = "UPDATE services SET engine1=" . $row['motorid'] . " WHERE serviceid=" . $service_row['serviceid'];
				$run_update = mysqli_query($conn, $update);
			}
			else if($engines == 1){
				$update = "UPDATE services SET engine2=" . $row['motorid'] . " WHERE serviceid=" . $service_row['serviceid'];
				$run_update = mysqli_query($conn, $update);
			}
			else if($engines == 2){
				$update = "UPDATE services SET engine3=" . $row['motorid'] . " WHERE serviceid=" . $service_row['serviceid'];
				$run_update = mysqli_query($conn, $update);
			}

		header("Location: view-service.php?id=" . $service_row['serviceid']);
	}
	require "footer.php";
?>