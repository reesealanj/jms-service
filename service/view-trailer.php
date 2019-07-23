<?php
	require "header.php";

	if(!isset($_GET['id'])){
		header("Location: services.php?error=ntc");
	}
	else{
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);

		if(mysqli_num_rows($run) < 1){
			header("Location: services.php?error=tne");
		}

		$service_row = mysqli_fetch_assoc($run);

		$trailer = $service_row['trailerid'];
		$customer = $service_row['customer'];

		$query = "SELECT * FROM users WHERE userid=" . $customer;
		$run = mysqli_query($conn, $query);
		$customer_row = mysqli_fetch_assoc($run);

		$query = "SELECT * FROM trailers WHERE trailerid=" . $trailer;
		$run = mysqli_query($conn, $query);
		$trailer_row = mysqli_fetch_assoc($run);

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
	<div class="row">
		<div class="col col-12 mt-4">
			<div class="card my-1">
				<div class="card-header">
					Service Information
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
					<h2>Trailer Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Make: </b> <?php echo $trailer_row['make']; ?>
						</li>
						<li class="list-group-item">
							<b>Model: </b> <?php echo $trailer_row['model']; ?>
						</li>
						<li class="list-group-item">
							<b>Year: </b> <?php echo $trailer_row['year']; ?>
						</li>
						<li class="list-group-item">
							<b>VIN: </b> <?php echo $trailer_row['vin']; ?>
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