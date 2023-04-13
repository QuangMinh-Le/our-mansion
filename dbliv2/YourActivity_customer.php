<?php
session_start();
include("connection.php");
include("function.php");
$client_data = check_login_customer($con);
$client_SSN = $client_data['client_SSN'];

$tableName1 = "reservation";
$fetchReservation = fetch_yourdata($con, $tableName1, $client_SSN);

function fetch_yourdata($db, $tableName, $client_SSN)
{
	if (empty($db)) {
		$msg = "Database connection error";
	} elseif (empty($tableName)) {
		$msg = "Table Name is empty";
	} else {
		$query = "SELECT * FROM $tableName" . " WHERE client_SSN = '$client_SSN' ORDER BY reservation_id ASC";
		$result = $db->query($query);
		if ($result == true) {
			if ($result->num_rows > 0) {
				$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$msg = $row;
			} else {
				$msg = "No Data Found";
			}
		} else {
			$msg = mysqli_error($db);
		}
	}
	return $msg;
}

$tableName1 = "booking";
$fetchBooking = fetch_yourdata($con, $tableName1, $client_SSN);




$_SESSION;
?>


<!DOCTYPE html>
<html>

<head>
	<title> OurMansion | Your Activity customer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<script src="scripts/external/jquery-3.1.1.min.js"></script>
	<script src="scripts/web/ej.web.all.min.js"> </script>

	<!-- Date picker -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<style>
	<?php include './CSS/home.css'; ?>
</style>

<body>
	<div class="bigContainer">


		<div class="header">
			<!-- Navigation bar -->
			<nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-dark" data-bs-theme="dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="home_customer.php">Our mansion</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
						data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavDropdown">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="home_customer.php">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="modifyInfo_customer.php">Account</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout_customer.php">Logout</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
									aria-expanded="false">
									Your activity
								</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="YourActivity_customer.php">Your Reservations</a></li>
									<li><a class="dropdown-item" href="YourActivity_customer.php">Your Bookings</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>

		<!-- Welcome part -->
		<div class="welcome">
			<div class="accordion" id="accordionPanelsStayOpenExample">
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button" type="button" data-bs-toggle="collapse"
							data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
							aria-controls="panelsStayOpen-collapseOne">
							Welcome to Ourmansion!
						</button>
					</h2>
					<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
						<div class="accordion-body">
							<strong>Hello,
								<?php echo $client_data['cFullName']; ?>
							</strong>
							<br>
							Looking for a convenient and hassle-free way to book your next hotel stay? Look no further than our
							hotel booking app!
							<br>
							Our app makes it easy to search for and book accommodations in just a few simple steps. Whether
							you're
							looking for a budget-friendly option or a luxurious getaway, our app has options to fit your needs
							and
							budget.
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
							aria-controls="panelsStayOpen-collapseTwo">
							Tip #1
						</button>
					</h2>
					<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
						<div class="accordion-body">
							<strong>Tip #1 of the day</strong>
							<br>
							With our app, you can search for hotels based on your location or destination, view photos and
							amenities, read reviews from other travelers, and even compare prices from multiple booking sites
							to ensure you're getting the best deal possible.
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
							aria-controls="panelsStayOpen-collapseThree">
							Tip #2
						</button>
					</h2>
					<div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
						<div class="accordion-body">
							<strong>Tip #2</strong>
							<br>Once you've found the perfect hotel, booking is a breeze. Just enter your travel dates and
							payment information, and you'll receive an instant confirmation. And if you need to make any
							changes to your reservation, our app makes it easy to do so right from your mobile device.
						</div>
					</div>
				</div>
			</div>
		</div>

		<h1 style=" text-align: center;"> Your past reservations:</h1>

		<tbody>
		<?php
			if (is_array($fetchReservation)) {
				foreach ($fetchReservation as $data) {
					?>
						<form method="post" class="reservation_form">
							<div>
								<div class="mb-3">
									<h4>Reservation_id:
										<?php echo $data['reservation_id'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Client_SSN:
										<?php echo $data['client_SSN'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Room id:
										<?php echo $data['room_id'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Start Date:
										<?php echo $data['startDate'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>End Date:
										<?php echo $data['endDate'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>Archived:
										<?php echo $data['archived'] ?? ''; ?>
									</h4>
								</div>


							</div>
						</form>

						<?php
					}}
				 else {

					?>
					<h6>---Your have no reservation yet---</h5>
						<tr>
							<td colspan="8">
								<?php echo $fetchData; ?>
							</td>
						<tr>
							<?php
				}
			 ?>
		</tbody>

		<br><br>
		<h1 style=" text-align: center;"> Your past bookings:</h1>
		<tbody>
		<?php
			if (is_array($fetchBooking)) {
				foreach ($fetchBooking as $data) {
					?>
						<form method="post" class="reservation_form">
							<div>
								<h2>
									<?php echo $data['chain_name'] ?? ''; ?>
								</h2>
								<div class="mb-3">
									<h4>
										<?php echo $data['ratingStars'] ?? ''; ?> &#11088;
									</h4>
								</div>
								<div class="mb-3">
									<h4>Reservation_id:
										<?php echo $data['reservation_id'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Client_SSN:
										<?php echo $data['client_SSN'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Room id:
										<?php echo $data['room_id'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Start Date:
										<?php echo $data['startDate'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>End Date:
										<?php echo $data['endDate'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>Archived:
										<?php echo $data['archived'] ?? ''; ?>
									</h4>
								</div>


							</div>
						</form>

						<?php
					}}
				 else {

					?>
					<h6>---Your have no past booking yet---</h5>
						<tr>
							<td colspan="8">
								<?php echo $fetchData; ?>
							</td>
						<tr>
							<?php
				}
			 ?>
		</tbody>

		
	</div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</html>