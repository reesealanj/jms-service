<?php
	require "header.php";

	if(!isset($_GET['id'])){
		header("Location: services.php?error=nsc");
	}
	else{
		$service = $_GET['id'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);

		if(mysqli_num_rows($run) < 1){
			header("Location: services.php?error=sne");
		}

		$service_row = mysqli_fetch_assoc($run);

		$customer = $service_row['customer'];
		$query = "SELECT * FROM users WHERE userid=" . $customer;
		$run = mysqli_query($conn, $query);
		$customer_row = mysqli_fetch_assoc($run);

		$query = "SELECT * FROM services WHERE serviceid=" . $service . " AND customer="  . $customer;
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
	<div class="row">
		<div class="col col-4">
			<div class="card mt-1">
				<div class="card-header">
					<h2>Engine 1 Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php
							if($service_row['engine1'] == 0){
								echo "<li class='list-group-item'>
									<b>No Engine 1</b> </li>";
							}
							else{
								$query = "SELECT * FROM motors WHERE motorid=" . $service_row['engine1'];
								$run = mysqli_query($conn, $query);
								$engine1 = mysqli_fetch_assoc($run);
								echo "<li class='list-group-item'>
										<b>Make: </b> {$engine1['make']} 
									</li>
									<li class='list-group-item'>
										<b>Model: </b> {$engine1['model']}
									</li>
									<li class='list-group-item'>
										<b>Year: </b> {$engine1['year']}
									</li>
									<li class='list-group-item'>
										<b>VIN: </b> {$engine1['vin']}
									</li>
									<li class='list-group-item'>
										<b>Model Number: </b> {$engine1['modelno']}
									</li>
									";
							}
						?>
					</ul>
				</div>
				
			</div>
		</div>
		<div class="col col-4">
			<div class="card mt-1">
				<div class="card-header">
					<h2>Engine 2 Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php
							if($service_row['engine2'] == NULL || $service_row['engine2'] == 0){
								echo "<li class='list-group-item'>
									<b>No Engine 2</b></li>";
							}
							else{
								$query = "SELECT * FROM motors WHERE motorid=" . $service_row['engine2'];
								$run = mysqli_query($conn, $query);
								$engine2 = mysqli_fetch_assoc($run);
								echo "<li class='list-group-item'>
										<b>Make: </b> {$engine2['make']} 
									</li>
									<li class='list-group-item'>
										<b>Model: </b> {$engine2['model']}
									</li>
									<li class='list-group-item'>
										<b>Year: </b> {$engine2['year']}
									</li>
									<li class='list-group-item'>
										<b>VIN: </b> {$engine2['vin']}
									</li>
									<li class='list-group-item'>
										<b>Model Number: </b> {$engine2['modelno']}
									</li>
									";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col col-4">
			<div class="card mt-1">
				<div class="card-header">
					<h2>Engine 3 Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php
							if($service_row['engine2'] == NULL || $service_row['engine3'] == 0){
								echo "<li class='list-group-item'>
									<b>No Engine 3</b></li>";
							}
							else{
								$query = "SELECT * FROM motors WHERE motorid=" . $service_row['engine3'];
								$run = mysqli_query($conn, $query);
								$engine3 = mysqli_fetch_assoc($run);
								echo "<li class='list-group-item'>
										<b>Make: </b> {$engine3['make']} 
									</li>
									<li class='list-group-item'>
										<b>Model: </b> {$engine3['model']}
									</li>
									<li class='list-group-item'>
										<b>Year: </b> {$engine3['year']}
									</li>
									<li class='list-group-item'>
										<b>VIN: </b> {$engine3['vin']}
									</li>
									<li class='list-group-item'>
										<b>Model Number: </b> {$engine3['modelno']}
									</li>
									";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-left my-2">
		<div class="col-3">
			<form action="" method="post">
				<button class="btn btn-danger btn-lg" type="submit" name="remove-submit">Remove Engines</button>
			</form>
		</div>
	</div>
	<div class="row justify-content-left my-2">
		<div class="col-2">
			<a href="view-service.php?id=<?php echo $service_row['serviceid'];?>" class="btn-info btn" role="button">Back</a>
		</div>
	</div>
</div>
<?php 
	if(isset($_POST['remove-submit'])){
		$boat = $_GET['id'];
		$queries = "UPDATE services SET engine1=0, engine2=0, engine3=0 WHERE serviceid=" . $boat . ";";
		
		$e1 = $engine1['motorid'];
		$e2 = $engine2['motorid'];
		$e3 = $engine3['motorid'];

		$queries .= "DELETE FROM motors WHERE motorid=" . $e1 . ";";
		$queries .= "DELETE FROM motors WHERE motorid=" . $e2 . ";";
		$queries .= "DELETE FROM motors WHERE motorid=" . $e3 . ";"; 

		$run = mysqli_multi_query($conn, $queries);
		header("Location: view-service.php?id=" . $service);
	}

	require "footer.php";
?>