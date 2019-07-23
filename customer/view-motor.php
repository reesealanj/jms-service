<?php
	require "header.php";

	if(!isset($_SESSION['userid'])){
		header("Location: services.php?error=nec");
	}
	else{
		$service = $_SESSION['userid'];
		$query = "SELECT * FROM services WHERE serviceid=" . $service;
		$run = mysqli_query($conn, $query);
		$service_row = mysqli_fetch_assoc($run);

		$engine_num = $_GET['e'];

		if($engine_num == 1){
			$query = "SELECT engine1 FROM services WHERE serviceid=" . $service;
			$run = mysqli_query($conn, $query);
			$mid_row = mysqli_fetch_assoc($run);
			$engine = $mid_row['engine1'];
			$query = "SELECT * FROM motors WHERE motorid=" . $engine;
			$run = mysqli_query($conn, $query);
			$engine_row = mysqli_fetch_assoc($run);
		}
		else if($engine_num == 2){
			$query = "SELECT engine2 FROM services WHERE serviceid=" . $service;
			$run = mysqli_query($conn, $query);
			$mid_row = mysqli_fetch_assoc($run);
			$engine = $mid_row['engine2'];
			$query = "SELECT * FROM motors WHERE motorid=" . $engine;
			$run = mysqli_query($conn, $query);
			$engine_row = mysqli_fetch_assoc($run);
		}
		else if($engine_num == 3){
			$query = "SELECT engine3 FROM services WHERE serviceid=" . $service;
			$run = mysqli_query($conn, $query);
			$mid_row = mysqli_fetch_assoc($run);
			$engine = $mid_row['engine3'];
			$query = "SELECT * FROM motors WHERE motorid=" . $engine;
			$run = mysqli_query($conn, $query);
			$engine_row = mysqli_fetch_assoc($run);
		}
		
		
	}
?>

<div class="container">
	<div class="row">
		<div class="col col-12 mt-2">
			<div class="card mt-1">
				<div class="card-header">
					<h2>Engine Information</h2>
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<b>Make: </b> <?php echo $engine_row['make']; ?>
						</li>
						<li class="list-group-item">
							<b>Model: </b> <?php echo $engine_row['model']; ?>
						</li>
						<li class="list-group-item">
							<b>Year: </b> <?php echo $engine_row['year']; ?>
						</li>
						<li class="list-group-item">
							<b>VIN: </b> <?php echo $engine_row['vin']; ?>
						</li>
						<li class="list-group-item">
							<b>Model Number: </b> <?php echo $engine_row['modelno']; ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-left">
		<div class="col-2 mt-2">
			<a href="view-service.php?id=<?php echo $service_row['serviceid'];?>" class="btn-info btn" role="button">Back</a>
		</div>
	</div>
</div>
<?php 
	require "footer.php";
 ?>