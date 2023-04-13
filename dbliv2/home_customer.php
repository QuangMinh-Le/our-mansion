<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
$client_data = check_login_customer($con);

$_SESSION;
$roomsBrowsed;

if (isset($_POST['filter'])) {
	$city = $_POST['city'];
	$peopleCapacity = $_POST['peopleCapacity'];
	$chain_name = $_POST['chain_name'];
	$ratingStars = $_POST['ratingStars'];
	$lowprice = $_POST['lowprice'];
	$highprice = $_POST['highprice'];
	$view = $_POST['view'];
	$numberOfRooms = $_POST['numberOfRooms'];

	$startDate = date('Y-m-d', strtotime($_POST['startDateFilter']));
	$endDate = date('Y-m-d', strtotime($_POST['endDateFilter']));

	$query = "SELECT room_id, room_number, room.hotel_id, price, peopleCapacity, view, extandable, damage, chain_name, ratingStars, city, hotel.numberOfRooms  
				FROM room, hotel  WHERE hotel.hotel_id=room.hotel_id AND city=$city AND peopleCapacity=$peopleCapacity AND chain_name=$chain_name AND ratingStars=$ratingStars AND view = $view AND hotel.numberOfRooms = $numberOfRooms AND price BETWEEN $lowprice AND $highprice 
				And room_id NOT IN (SELECT distinct room_id from Reservation WHERE (!(startDate < '$startDate' and endDate < '$startDate')  and !(startDate > '$endDate' and endDate > '$startDate'))) and room_id NOT IN (SELECT distinct room_id from Booking WHERE (!(startDate < '$startDate' and endDate < '$startDate')  and !(startDate > '$endDate' and endDate > '$startDate')))";
	$result = $con->query($query);
	if ($result->num_rows > 0) {
		$roomsBrowsed = mysqli_fetch_all($result, MYSQLI_ASSOC);
	} else {
		$roomsBrowsed = [];
	}
}

if (isset($_POST['reserve'])) {
	$client_SSN = $client_data['client_SSN'];
	$room_id = $_POST['room_id'];
	$startDate = date('Y-m-d', strtotime($_POST['startDate']));
	$endDate = date('Y-m-d', strtotime($_POST['endDate']));
	if ($startDate === '1970-01-01' or $endDate === '1970-01-01') {
		echo "<div class=\"alert alert-warning\" role=\"alert\">Date input is blank. Please try again!</div> ";
	} else {
		$query_checker1 = "SELECT distinct room_id 
								from Reservation 
								WHERE room_id = $room_id
								and(!(startDate < '$startDate' and endDate < '$startDate')  and !(startDate > '$endDate' and endDate > '$startDate'))";

		$checker = mysqli_query($con, $query_checker1);

		if (mysqli_num_rows($checker) > 0) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">The room that you are reserving is not available in the date range you just inputted. You should put the same date with the one in filter!</div>";
		} else {
			$query_checker2 = "SELECT distinct room_id 
			from Booking
			WHERE room_id = $room_id
			and(!(startDate < '$startDate' and endDate < '$startDate')  and !(startDate > '$endDate' and endDate > '$startDate'))";

			$checker2 = mysqli_query($con, $query_checker2);

			if (mysqli_num_rows($checker2) > 0) {
				echo "<h4 style= \"color:red\"> The room that you are reserving is not available in the date range you just inputted. You should put the same date with the one in filter!</h4> ";
			} else {
				$query = "INSERT INTO Reservation (client_SSN, room_id, startDate, endDate, archived) values ('$client_SSN', $room_id, '$startDate', '$endDate', 0)";
				try {
					$result = mysqli_query($con, $query);
					echo "<div class=\"alert alert-success\" role=\"alert\">Your reservation is successfully executed!</div>";
				} catch (Exception $e) {
					echo "<div class=\"alert alert-danger\" role=\"alert\">Reservation counldn't be created! Try again!</div>";
					echo $e->getMessage();
					//exit;
				}
			}
		}
	}


}


?>



<!DOCTYPE html>
<html>

<head>
	<title> OurMansion | Home customer</title>
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

		<div class="filter-room">

			<div class="card" style="width: 100%;">
				<img src="./img/Background_Homepage.png" class="card-img-top" alt="...">
				<div class="card-body">

					<h1 style=" text-align: center;"> Existing rooms to reserve:</h1>
					<!-- Room filter -->
					<form action="" method="post">
						<div class="filter-date">

							<div class="mb-3">
								<label for="startDate">Start Date</label>
								<input id="startDate" class="form-control" type="date" name="startDateFilter" />
							</div>
							<div class="mb-3">
								<label for="startDate">End Date</label>
								<input id="endDate" class="form-control" type="date" name="endDateFilter" />
							</div>
						</div>

						<div class="filter-other">

							<select name="city">
								<option value="city">Select City</option>
								<?php
								$query = "SELECT DISTINCT city FROM hotel";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['city'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="'<?php echo $option; ?>'"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>
							<select name="peopleCapacity">
								<option value="peopleCapacity">Select people capacity</option>
								<?php
								$query = "SELECT DISTINCT peopleCapacity FROM Room";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['peopleCapacity'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="<?php echo $option; ?>"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>
							<select name="chain_name">
								<option value="chain_name">Select hotel chain</option>
								<?php
								$query = "SELECT DISTINCT chain_name FROM HotelChain";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['chain_name'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="'<?php echo $option; ?>'"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>

							<select name="ratingStars">
								<option value="ratingStars">Select rating categorie</option>
								<?php
								$query = "SELECT DISTINCT ratingStars FROM Hotel";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['ratingStars'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="<?php echo $option; ?>"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>

							<select name="numberOfRooms">
								<option value="numberOfRooms">Select number of rooms in a hotel</option>
								<?php
								$query = "SELECT DISTINCT numberOfRooms FROM Hotel";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['numberOfRooms'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="<?php echo $option; ?>"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>

							<select name="view">
								<option value="view">Select room view</option>
								<?php
								$query = "SELECT DISTINCT view FROM Room";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['view'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="'<?php echo $option; ?>'"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>

							<select name="lowprice">
								<option value="0">Select lowest price</option>
								<?php
								$query = "SELECT DISTINCT price FROM Room";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['price'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="<?php echo $option; ?>"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>

							<select name="highprice">
								<option value="1000000">Select highest price</option>
								<?php
								$query = "SELECT DISTINCT price FROM Room";
								$result = $con->query($query);
								if ($result->num_rows > 0) {
									while ($optionData = $result->fetch_assoc()) {
										$option = $optionData['price'];
										//$id =$optionData['hotel_id'];
										?>
										<option value="<?php echo $option; ?>"><?php echo $option; ?> </option>
										<?php
									}
								}
								?>
							</select>
						</div>

						<input type="submit" name="filter" value="Filter" class="filter-btn" />
					</form>
				</div>
			</div>


		</div>

		<tbody>
			<?php
			if (isset($roomsBrowsed)) {
				if (count($roomsBrowsed) > 0) {

					foreach ($roomsBrowsed as $data) {
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
									<h4>Location:
										<?php echo $data['city'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Room number:
										<?php echo $data['room_number'] ?? ''; ?>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Room id:
										<input type="number" name="room_id" readonly value="<?php echo $data['room_id'] ?? ''; ?>"></input>
									</h4>
								</div>
								<div class="mb-3">
									<h4>Room capacity:
										<?php echo $data['peopleCapacity'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>Room condition:
										<?php echo $data['damage'] ?? ''; ?>
									</h4>
								</div>

								<div class="mb-3">
									<h4>Total number of rooms in hotel:
										<?php echo $data['numberOfRooms'] ?? ''; ?>
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

								<div class="reservation-date">
									<div class="mb-3">
										<label for="startDate">Start Date</label>
										<input id="startDate" class="form-control" type="date" name="startDate" />
									</div>
									<div class="mb-3">
										<label for="startDate">End Date</label>
										<input id="endDate" class="form-control" type="date" name="endDate" />
									</div>
								</div>

								<button type="submit" class="reservation-btn" name="reserve">Confirm Reservation</button>

							</div>
						</form>

						<?php
					}
				} else {

					?>
					<h6>---There is no room that matches the selected criterias---</h5>
						<tr>
							<td colspan="8">
								<?php echo $fetchData; ?>
							</td>
						<tr>
							<?php
				}
			} ?>
		</tbody>

</body>

<!-- Script for reserve trigger -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script>
	$(function () {
		const date = new Date();

		let day = date.getDate();
		let month = date.getMonth() + 1;
		let year = date.getFullYear();

		let currentDate = `${month}/${day}/${year}`;
		console.log(currentDate);

		var dateFormat = "mm/dd/yy",
			from = $("#from")
				.datepicker({
					defaultDate: null,
					changeMonth: true,
					numberOfMonths: 2,
					minDate: currentDate
				})
				.on("change", function () {
					to.datepicker("option", "minDate", getDate(this));
				}),
			to = $("#to").datepicker({
				defaultDate: null,
				changeMonth: true,
				numberOfMonths: 2,
				minDate: currentDate
			})
				.on("change", function () {
					from.datepicker("option", "maxDate", getDate(this));
				});


		function getDate(element) {
			var date;
			try {
				date = $.datepicker.parseDate(dateFormat, element.value);
			} catch (error) {
				date = null;
			}

			return date;
			console.log(date);
		}
	});

</script>

</html>