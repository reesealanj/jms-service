<?php
	require "header.php";
?>
<div class="container container-fluid">
	<div class="row">
		<div class="col-lg align-self-center">
			<div class="card mt-4">
				<div class="card-header text-center">
					<h1 class="display-3">
						Remove User
					</h1>
					<h3 class="text-muted">
						Removing a user will destroy all traces of them from the database, this action CANNOT be undone.
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col">
								<div class="form-row">
									<div class="form-group col">
										<?php
										if(isset($_GET['user'])){
											$userid = $_GET['user'];
											$query = "SELECT * FROM users WHERE userid=" . $userid;
											$run = mysqli_query($conn, $query);
											//If the account is not there, redirect to users page
											if(mysqli_num_rows($run) < 1){
												header("Location: users.php");
											}
											else{
												$result = mysqli_fetch_assoc($run);
												echo "<h4 class='text-center mt-4'><b>User: </b>" . $result['fname'] . " " . $result['lname'] . "</h4>";
											}
										}
										?>
									</div>
									<div class="form-group col">
										<a href="delete-submit.php?user=<?php echo $_GET['user']; ?>" class="btn btn-danger mt-4 ml-4" role="button">Confirm Delete</a>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-2 align-self-left mt-3">
			<a href="users.php" class="btn btn-info">Back</a>
		</div>
	</div>
</div>
<?php
	require "footer.php";
?>