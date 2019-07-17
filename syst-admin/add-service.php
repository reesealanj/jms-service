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
	<div class="row">
		<div class="col col-12">
			<div class="card my-5">
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
								$line = "<li class='list-group-item'><b>Part:</b> " . $part_info['partname'] . " ($" . $part_info['partcost'] . ")";
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
</div>
<?php
	require "footer.php";
?>