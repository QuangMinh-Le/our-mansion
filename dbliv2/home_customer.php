<?php
session_start();
include("connection.php");
include("function.php");
$client_data = check_login_customer($con);

// $_SESSION;

if (isset($_POST['reserve'])) {
	$client_SSN = $client_data['client_SSN'];
	echo "$client_SSN    ";
	
	$room_id = $_POST['room_id'];
	echo "$room_id    ";
	$startDate = date('Y-m-d', strtotime($_POST['startDate']));
	echo "$startDate    ";
	$endDate = date('Y-m-d', strtotime($_POST['endDate']));
	echo "$endDate    ";

	$query ="INSERT INTO Reservation (client_SSN, room_id, startDate, endDate, archived) values ('$client_SSN', $room_id, '$startDate', '$endDate', 0)";
	try{
		$result = mysqli_query($con, $query);
 	}catch (Exception $e){
		 echo "<p style= \"color:red\"> Reservation counldn't be created! Try again!</p>";
		 echo $e->getMessage();
		 //exit;
 	}

	

}

?>



<!DOCTYPE html>
<html>

<head>
	<title> OurMansion | Home customer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<link rel="stylesheet" href="themes/bootstrap-theme/ej.web.all.min.css" />
	<script src="scripts/external/jquery-3.1.1.min.js"></script>
	<script src="scripts/web/ej.web.all.min.js"> </script>

	<!-- Date picker -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

</head>
<style type="text/css">
	.form {
		padding: 30px;
		outline: solid 1px #026afa;
		background-color: rgba(0, 174, 255, 0.1);
		border-radius: 10px;
		margin-bottom: 50px;
	}

	/* #reservation_date {
		display: none;
	} */

	.hidden {
		display: none;
	}
</style>

<body>
	<h1 style="font-family: fantasy ; text-align: center;">OurMansion</h1>
	<a href="logout_customer.php"> Logout</a>
	<h1>This is the home page</h1>
	<br>
	Hello,
	<?php echo $client_data['cFullName']; ?>
	<br>
	logined as customer
	<br><br><br>
	<h1 style=" text-align: center;"> Existing rooms to reserve:</h1>


	<div class="container" style="width: 2500px;">
		<div class="row" style="width: 2500px;margin: 0.1%;">
			<div class="col-sm-8">
				<?php echo $deleteMsg ?? ''; ?>
				<div class="table-responsive">
					
				</div>
			</div>
		</div>
		<tbody>
			<?php
			if (is_array($fetchData)) {

				foreach ($fetchData as $data) {
					?>
					<div class="form">
						<form method="POST">
							<h2>
								<?php echo $data['chain_name'] ?? ''; ?>
							</h2>
							<div class="mb-3">
								<h4>
									<?php echo $data['ratingStars'] ?? ''; ?> &#11088;
								</h4>
							</div>
							<div class="mb-3">
								<h4>Location:
									<?php echo $data['city'] ?? ''; ?>
								</h4>
							</div>
							<div class="mb-3">
								<h4>Room number:
									<?php echo $data['room_number'] ?? ''; ?>
								</h4>
							</div>
							<div class="mb-3 hidden">
								<h4>Room id:
									<input type = "number" name = "room_id" value= "<?php echo $data['room_id'] ?? ''; ?>"></input>
								</h4>
							</div>
							<div class="mb-3">
								<h4>View:
									<?php echo $data['view'] ?? ''; ?>
								</h4>
							</div>
							<div class="mb-3">
								<h4>Price (per night):
									<?php echo $data['price'] ?? ''; ?>
								</h4>
							</div>

							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
								Reserve
							</button>

							<!-- Modal -->
							<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
								tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div id="reservation_date">
												<div class="mb-3">
													<label for="startDate">Start Date</label>
													<input id="startDate" class="form-control" type="date" name="startDate"/>
												</div>
												<div class="mb-3">
													<label for="startDate">End Date</label>
													<input id="endDate" class="form-control" type="date" name="endDate"/>
												</div>
												<div class="mb-3">
													<label for="startDate">Total Price:</label>
												</div>

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary" name="reserve">Confirm Reserve</button>
										</div>
									</div>
								</div>
							</div>

						</form>
					</div>
					<?php
				}
			} else { ?>
				<tr>
					<td colspan="8">
						<?php echo $fetchData; ?>
					</td>
				<tr>
					<?php
			} ?>
	</div>


</body>

<!-- Script for reserve trigger -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script>

	const myModal = document.getElementById('myModal')
	const myInput = document.getElementById('myInput')

	myModal.addEventListener('shown.bs.modal', () => {
		myInput.focus()
	})
</script>

</html>