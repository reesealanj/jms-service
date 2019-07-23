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
		$hours_total = 0.0;

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
					$num = 0;

					while($lines_row = mysqli_fetch_assoc($run_line_items)){
						$num++; 
						switch($lines_row['itemtype']){
							//case 1 -- Part Line
							case(1):
								$part_number = $lines_row['partnumber'];
								$query = "SELECT * FROM partitems WHERE partnumber=" . $part_number;
								$run = mysqli_query($conn, $query);
								$part_info = mysqli_fetch_assoc($run);

								$parts_total += $part_info['partcost'];
								$line = "<li class='list-group-item'><a href='remove-line-item.php?t=1&s=" . $service . "&p=" . $part_info['partnumber'] . "' class='btn btn-sm btn-danger mr-1' role='button'>x</a><b>Part:</b> " . $part_info['partname'] . " ($" . $part_info['partcost'] . ")";
								if($lines_row['comments'] != NULL){
									$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:</b> " . $lines_row['comments'] . "</li>";
								}
								else{
									$line .="<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#modal" . $num . "'>Add Comment</button>

										<div class='modal fade' id='modal" . $num . "' tabindex='-1' role='dialog' aria-labelledby='modal" . $num . "Title' aria-hidden='true'>
											<div class='modal-dialog modal-dialog-centered' role='document'>
												<div class='modal-content'>
													<div class='modal-header'>
														<h5 class='modal-title' id='modal" . $num . "Title'>
															Add Comments
														</h5>
														<button class='close' type='button' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
												<form method='post' action='add-comment.php?s=" . $service . "&p=" . $part_info['partnumber'] . "&t=1'>
													<div class='modal-body'>
														<div class='form-row'>
															<div class='form-group'>
																<label for='comments'>Comments:</label>
																<textarea name='comments' class='form-control' cols='50' rows='5'></textarea>
															</div>
														</div>
													</div>
													<div class='modal-footer'>
														<button class='btn btn-secondary' data-dismiss='modal'>Close</button>
														<button class='btn btn-primary' type='submit' name='add-comment-submit'>Add</button>
													</div>
												</form>
												</div>
											</div>
										</div>";
								}

								echo $line;
								break;
							case(0):
								$service_number = $lines_row['partnumber'];
								$query = "SELECT * FROM servicelines WHERE itemid=" . $service_number;
								$run = mysqli_query($conn, $query);
								$line_info = mysqli_fetch_assoc($run);
								$line = "<li class='list-group-item'><a href='remove-line-item.php?t=0&s=" . $service . "&p=" . $line_info['itemid'] . "' class='btn btn-sm btn-danger mr-1' role='button'>x</a><b>Labor: </b>" . $line_info['description'];
								if($lines_row['hours'] != NULL){
									$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Hours:</b> " . $lines_row['hours'];
									$hours_total += $lines_row['hours'];
								}
								else{
									$line .="<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#modal2" . $num . "'>Add Hours</button>

										<div class='modal fade' id='modal2" . $num . "' tabindex='-1' role='dialog' aria-labelledby='modal2" . $num . "Title' aria-hidden='true'>
											<div class='modal-dialog modal-dialog-centered' role='document'>
												<div class='modal-content'>
													<div class='modal-header'>
														<h5 class='modal-title' id='modal2" . $num . "Title'>
															Add Hours
														</h5>
														<button class='close' type='button' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
												<form method='post' action='add-hours.php?s=" . $service . "&p=" . $line_info['itemid'] . "&t=0'>
													<div class='modal-body'>
														<div class='form-row'>
															<div class='form-group'>
																<label for='hours'>Hours:</label>
																<input type='number' name='hours' class='form-control' step='any' min='0' placeholder='00.00'>
															</div>
														</div>
													</div>
													<div class='modal-footer'>
														<button class='btn btn-secondary' data-dismiss='modal'>Close</button>
														<button class='btn btn-primary' type='submit' name='add-comment-submit'>Add</button>
													</div>
												</form>
												</div>
											</div>
										</div>";
								}
								if($lines_row['comments'] != NULL){
									$line .= " <br />&nbsp;&nbsp;&nbsp;&nbsp;<b>Comment:</b> " . $lines_row['comments'] . "</li>";
								}
								else{
									$line .="<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#modal" . $num . "'>Add Comment</button>

										<div class='modal fade' id='modal" . $num . "' tabindex='-1' role='dialog' aria-labelledby='modal" . $num . "Title' aria-hidden='true'>
											<div class='modal-dialog modal-dialog-centered' role='document'>
												<div class='modal-content'>
													<div class='modal-header'>
														<h5 class='modal-title' id='modal" . $num . "Title'>
															Add Comments
														</h5>
														<button class='close' type='button' data-dismiss='modal' aria-label='Close'>
															<span aria-hidden='true'>&times;</span>
														</button>
													</div>
												<form method='post' action='add-comment.php?s=" . $service . "&p=" . $line_info['itemid'] . "&t=0'>
													<div class='modal-body'>
														<div class='form-row'>
															<div class='form-group'>
																<label for='comments'>Comments:</label>
																<textarea name='comments' class='form-control' cols='50' rows='5'></textarea>
															</div>
														</div>
													</div>
													<div class='modal-footer'>
														<button class='btn btn-secondary' data-dismiss='modal'>Close</button>
														<button class='btn btn-primary' type='submit' name='add-comment-submit'>Add</button>
													</div>
												</form>
												</div>
											</div>
										</div>";
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
	<div class="row">
		<div class="col col-6">
			<div class="card">
				<div class="card-header">
					<h3>Service/Labor</h3>
				</div>
				<div class="card-body col-12 align-text-center">
					<!-- Modal Trigger -->
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#serviceModal">Create New</button>
					<!-- Modal Code -->
					<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="serviceModalTitle">
										Create Service Item
									</h5>
									<button class="close" type="button" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<form method="post" action="">
								<div class="modal-body">
									<div class="form-row">
										<div class="form-group">
											<label for="description">Description</label>
											<textarea name="description" class="form-control" cols="30" rows="2"></textarea>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group">
											<label for="hours">Labor Hours</label>
											<input type="number" class="form-control" name="labor" step="any" min="0" placeholder="00.00">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group">
											<label for="comments">Comments</label>
											<textarea name="comments" class="form-control" cols="30" rows="5"></textarea>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit" name="add-service-submit">Add</button>
								</div>
							</form>
							</div>
						</div>
					</div>

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
									<caption>Displaying " . mysqli_num_rows($run) . " labor items.</caption>
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
									<a class='btn btn-success btn-sm mx-0 my-1' href='add-line-item.php?t=0&s=" . $service . "&p=" . $table_row['itemid'] . "' role='button'>Add</a>
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
					<!-- Modal Trigger -->
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#partsModal">Create New</button>
					<!-- Modal Code -->
					<div class="modal fade" id="partsModal" tabindex="-1" role="dialog" aria-labelledby="partsModalTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="partsModalTitle">
										Create Part
									</h5>
									<button class="close" type="button" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<form method="post" action="">
								<div class="modal-body">
									<div class="form-row">
										<div class="form-group">
											<label for="partname">Name:</label>
											<input type="text" class="form-control" name="partname" placeholder="Name">

											<label for="partcost">Cost:</label>
											<input class="form-control" type="number" min="0" step="any" placeholder="000.00" name="partcost">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group">
											<label for="comments">Comments</label>
											<textarea name="comments" class="form-control" cols="30" rows="5"></textarea>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit" name="add-part-submit">Add</button>
								</div>
							</form>
							</div>
						</div>
					</div>

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
									<a class='btn btn-success btn-sm mx-0 my-1' href='add-line-item.php?t=1&s=" . $service . "&p=" . $table_row['partnumber'] . "' role='button'>Add</a>
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
	if(isset($_POST['add-service-submit'])){
		$service = $_GET['id'];
		$description = $_POST['description'];
		$comments = $_POST['comments'];
		$hours = $_POST['labor'];

		$insert_service = "INSERT INTO servicelines (description) VALUES ('" . $description . "')";
		$run_insert_service = mysqli_query($conn, $insert_service);

		$get_number = "SELECT * FROM servicelines WHERE description='" . $description . "'";
		$run_get_number=mysqli_query($conn, $get_number);
		$number_row=mysqli_fetch_assoc($run_get_number);

		$number=$number_row['itemid'];
		$add_ticket = "INSERT INTO ticketlines (ticketid, itemtype, partnumber, comments, hours) VALUES (" . $service . ", 0, " . $number . ", '" .$comments ."', " . $hours . ")";
		$run_add_ticket = mysqli_query($conn, $add_ticket);
		echo "<script> location.replace('add-service.php?id=" . $service . "');</script>";
		exit();
	}
	if(isset($_POST['add-part-submit'])){
		$service = $_GET['id'];
		$name = $_POST['partname'];
		$cost = $_POST['partcost'];
		$comments = $_POST['comments'];

		$insert_part = "INSERT INTO partitems (partname, partcost) VALUES ('" . $name . "', " . $cost . ")";
		$run_insert_part = mysqli_query($conn, $insert_part);

		$get_number = "SELECT * FROM partitems WHERE partname='" . $name . "' AND partcost=" . $cost;
		$run_get_number = mysqli_query($conn, $get_number);
		$number_row = mysqli_fetch_assoc($run_get_number);

		$number = $number_row['partnumber'];
		$add_ticket = "INSERT INTO ticketlines (ticketid, itemtype, partnumber, comments) VALUES (" . $service . ", 1, " . $number . ", '" .$comments ."')";
		$run_add_ticket = mysqli_query($conn, $add_ticket);
		echo "<script> location.replace('add-service.php?id=" . $service . "');</script>";
		exit();
	}
	require "footer.php";
?>