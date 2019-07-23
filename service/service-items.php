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
		<div class="col col-12">
			<div class="card mt-3">
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
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit" name="create-service-submit">Add</button>
								</div>
							</form>
							</div>
						</div>
					</div>

					<form action="" class="my-2 form-inline" method="post">
						<input type="search" class="form-control col ml-auto" placeholder="Search" aria-label="search" name="user-query-service">
						<button class="btn btn-info btn-sm col-2 mx-1" type="submit" name="search-service">Search</button>
						<button class="btn btn-info btn-sm col-2 mx-1" type="submit" name="show-all-service">Display All</button>
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
										</tr>
									</thead>
									<tbody>
						\n";

						while($table_row = mysqli_fetch_assoc($run)){
							$name = $table_row['description'];

							$table .= "
							<tr>
								<td>" . $name . "</td>
							</tr>
							\n";
						}

						$table .= "</tbody></table></div></div>";
						echo $table;
					}
					else{
						echo "<h6 class='align-text-center'>There are no Labor Items matching your search.</h6>";
					}
				}
				if(isset($_POST['show-all-service'])){
					$table = "";

					$search = $_POST['user-query-service'];
					$query = "SELECT * FROM servicelines ORDER BY itemid DESC";
					$run = mysqli_query($conn, $query);
					if(mysqli_num_rows($run) > 0){
						$table .= "
						<div class='container'>
							<div class='table-responsive'>
								<table class='table table-hover'>
									<caption>Displaying all " . mysqli_num_rows($run) . " labor items.</caption>
									<thead>
										<tr>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
						\n";

						while($table_row = mysqli_fetch_assoc($run)){
							$name = $table_row['description'];

							$table .= "
							<tr>
								<td>" . $name . "</td>
							</tr>
							\n";
						}

						$table .= "</tbody></table></div></div>";
						echo $table;
					}
					else{
						echo "<h6 class='align-text-center'>There are no Labor Items in the system.</h6>";
					}
				}
				if(isset($_POST['create-service-submit'])){

					$description = $_POST['description'];
					$insert_service = "INSERT INTO servicelines (description) VALUES ('" . $description . "')";
					$run_insert_service = mysqli_query($conn, $insert_service);

					echo "<script> location.replace('service-items.php');</script>";
					exit();
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
	require "footer.php";
?>