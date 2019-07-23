<?php 
	require "header.php";
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-2 align-self-left mt-2">
			<a href="services.php" class="btn btn-info" role="button">Back</a>
		</div>
	</div>
	<div class="row">
		<div class="col">
				<div class="card mt-3">
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
							<input type="search" class="form-control col ml-auto" placeholder="Search" aria-label="search" name="user-query-parts">
							<button class="btn btn-info btn-sm col-2 mx-1" type="submit" name="search-parts">Search</button>
							<button class="btn btn-info btn-sm col-2 mx-1" type="submit" name="show-all-parts">Display All</button>
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
									</tr>
								\n";
							}

							$table .= "</tbody></table></div></div>";
							echo $table;
						}
						else{
							echo "<h6>There are no Parts matching your search.</h6>";
						}
					}
					if(isset($_POST['show-all-parts'])){
						$table = "";

						$search = $_POST['user-query-parts'];
						$query = "SELECT * FROM partitems ORDER BY partnumber DESC";
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
									</tr>
								\n";
							}

							$table .= "</tbody></table></div></div>";
							echo $table;
						}
						else{
							echo "<h6>There are no Parts in the system.</h6>";
						}
					}
				?>
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-2 align-self-left mt-2">
			<a href="services.php" class="btn btn-info" role="button">Back</a>
		</div>
	</div>
</div>
<?php
	if(isset($_POST['add-part-submit'])){
		$name = $_POST['partname'];
		$cost = $_POST['partcost'];

		$insert_part = "INSERT INTO partitems (partname, partcost) VALUES ('" . $name . "', " . $cost . ")";
		$run_insert_part = mysqli_query($conn, $insert_part);

		echo "<script> location.replace('part-items.php');</script>";
		exit();
	}

	require "footer.php";
?>
