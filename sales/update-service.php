<?php
	require "header.php";
	if(!isset($_GET['id'])){
		header("Location: services.php?error=sne");
		exit();
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
		<div class="col col-12 mt-5">
			<div class="card my-1">
				<div class="card-header">
					<h2>Service Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Service ID: </b> <?php echo $service_row['serviceid']; ?>
						</li>
						<li class="list-group-item">
							<b>Customer: </b> <?php echo $customer_row['fname']; echo " "; echo $customer_row['lname']; ?>
						</li>
						<li class="list-group-item">
							<b>Date Recieved:</b> <?php echo $service_row['recieved']; ?>
						</li>
						<li class="list-group-item">
							<b>Current Status:</b> <?php echo $status_word; ?> 
						</li>
						<li class="list-group-item">
							<form action="" method="post">
								<label for="status"><b>Select New Status</b></label>
								<select name="status" id="status" class="form-control">
									<option class="option" value="0">
										Ticket Opened - No Action Taken
									</option>
									<option class="option" value="1">
										Service In Progress
									</option>
									<option class="option" value="2">
										Service Paused - Waiting For Parts
									</option>
									<option class="option" value="3">
										Service Paused - Waiting For Callback
									</option>
									<option class="option" value="4">
										Service Completed - Customer Not Contacted
									</option>
									<option class="option" value="5">
										Service Completed - Customer Contacted
									</option>
									<option class="option" value="6">
										Ticket Closed - Customer Collected
									</option>
								</select>
								<button type="submit" class="btn btn-lg btn-success my-2" name="status-update">Update Status</button>
							</form>	
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
	if(isset($_POST['status-update'])){
		$status = $_POST['status'];
		$query = "UPDATE services SET status=" . $status . " WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);

		if($status == 6){
			$finish = "UPDATE services SET completed=CURDATE() WHERE serviceid=" . $service;
			$run = mysqli_query($conn, $finish);
		}
		header("Location: update-service.php?id=" . $service);
	}
	require "footer.php";
?>