<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
$client_data = check_login_customer($con);

$_SESSION;


if (isset($_POST['reserve'])) {
	$client_SSN = $client_data['client_SSN'];
	$room_id = $_POST['room_id'];
	$startDate = date('Y-m-d', strtotime($_POST['startDate']));
	echo "$startDate    ";
	$endDate = date('Y-m-d', strtotime($_POST['endDate']));
	echo "$endDate    ";

	$query = "INSERT INTO Reservation (client_SSN, room_id, startDate, endDate, archived) values ('$client_SSN', $room_id, '$startDate', '$endDate', 0)";
	try {
		$result = mysqli_query($con, $query);
	} catch (Exception $e) {
		echo "<p style= \"color:red\"> Reservation counldn't be created! Try again!</p>";
		echo $e->getMessage();
		//exit;
	}

}


if (isset($_POST['filter'])) {
	$city = $_POST['city'];
	echo "$city   ";
	$peopleCapacity = $_POST['peopleCapacity'];
	$chain_name = $_POST['chain_name'];
	$ratingStars = $_POST['ratingStars'];
	$lowprice = $_POST['lowprice'];
	$highprice = $_POST['highprice'];
	$view = $_POST['view'];
	$numberOfRooms = $_POST['numberOfRooms']; 

	$startDate = date('Y-m-d', strtotime($_POST['startDateFilter']));
	echo "$startDate    ";
	$endDate = date('Y-m-d', strtotime($_POST['endDateFilter']));
	echo "$endDate    ";

	$query = "SELECT room_id, room_number, room.hotel_id, price, peopleCapacity, view, extandable, damage, chain_name, ratingStars, city, hotel.numberOfRooms  
				FROM room, hotel  WHERE hotel.hotel_id=room.hotel_id AND city=$city AND peopleCapacity=$peopleCapacity AND chain_name=$chain_name AND ratingStars=$ratingStars AND view = $view AND hotel.numberOfRooms = $numberOfRooms AND price BETWEEN $lowprice AND $highprice 
				And room_id NOT IN (SELECT distinct room_id from Reservation WHERE (!(startDate < '$startDate' and endDate < '$startDate')  and !(startDate > '$endDate' and endDate > '$startDate')))";
	$result = $con->query($query);
	if ($result->num_rows > 0) {
		$roomsBrowsed = mysqli_fetch_all($result, MYSQLI_ASSOC);
	} else {
		$roomsBrowsed = [];
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
<style type="text/css">
	.reservation_form {
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
	h6 {
		color: red;
		font-weight: bolder;
		font-size: 1.5rem;
	}
</style>


<body>

        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
		<a href="logout_customer.php"> Logout</a>
		<h1>This is the home page</h1>
		<br>
		Hello, <?php echo $client_data['cFullName']; ?>
		<br>
		 logined as customer, options:
		 <br>
		 <a href="modifyInfo_customer.php"> modify your infos</a><br>
		 
		 <a href="YourActivity_customer.php">see your activity (bookings, reservations)</a>

		 <br><br>
		 
		 <h1 style= " text-align: center;"> Existing rooms to reserve:</h1>


		<div class="container" style="width: 2500px;"	>

	<div class="container" style="width: 100%;">

		<!-- Room filter -->


		<form action="" method="post">


			<div class="mb-3">
				<label for="startDate">Start Date</label>
				<input id="startDate" class="form-control" type="date" name="startDateFilter" />
			</div>
			<div class="mb-3">
				<label for="startDate">End Date</label>
				<input id="endDate" class="form-control" type="date" name="endDateFilter" />
			</div>
			<br>
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

			<input type="submit" name="filter" value="Filter" />
		</form>

		<tbody>
			<?php
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


							<div class="mb-3">
								<label for="startDate">Start Date</label>
								<input id="startDate" class="form-control" type="date" name="startDate" />
							</div>
							<div class="mb-3">
								<label for="startDate">End Date</label>
								<input id="endDate" class="form-control" type="date" name="endDate" />
							</div>

							<button type="submit" class="btn btn-primary" name="reserve">Confirm Reservation</button>

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
			} ?>
	</div>


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