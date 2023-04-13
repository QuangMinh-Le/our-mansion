<?php
session_start();
include("connection.php");
include("function.php");
$client_data = check_login_customer($con);
$_SESSION;

$fetchCustomer = fetch_customer($con, $client_data['client_SSN']);

function fetch_customer($db, $client_SSN)
{
	if (empty($db)) {
		$msg = "Database connection error";
	} else {
		$query = "SELECT * FROM  client WHERE client_SSN = '$client_SSN' LIMIT 1";
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

if ($_SERVER['REQUEST_METHOD'] == "POST") { //smt was posted
	if (isset($_POST['edit'])) {
		$client_SSN = $_POST['client_SSN'];

		$cmail = $_POST['cmail'];
		$cFullName = $_POST['cFullName'];
		$caddress = $_POST['caddress'];
		$cpass = $_POST['cpass'];

		$query = "UPDATE client SET cmail='$cmail', cFullName='$cFullName', caddress='$caddress',  cpass='$cpass' WHERE client_SSN = '$client_SSN'";
		$result = $con->query($query);

	}



}


?>


<!DOCTYPE html>
<html>

<head>
	<title> OurMansion | ModifyInfos Customer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
	<style>
		<?php include './CSS/home.css'; ?>
	</style>
</head>

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

		<br>
		<h1 style=" text-align: center;"> Your data you can modify:</h1> <br>
		<p style=" text-align: center;"> modify the values and then press edit button (you might need to reload twice the
			page after, for the change to take effect)</p>

			<tbody>
			<?php
				if (is_array($fetchCustomer)) {
					foreach ($fetchCustomer as $data) {
						?>
						<form method="post" class="edit_form">
							<div>
								<div class="mb-3">
									<h4>Client_SSN: </h4>
									<input name="client_SSN" value="<?php echo $data['client_SSN'] ?? ''; ?>"
														style="width:50%;" readonly>
								</div>
								<div class="mb-3">
									<h4>Email: </h4>
									<input name="cmail" value="<?php echo $data['cmail'] ?? ''; ?>" style="width:50%;">
								</div>
								<div class="mb-3">
									<h4>Fullname: </h4>
									<input name="cFullName" value="<?php echo $data['cFullName'] ?? ''; ?>"
														style="width:50%;">
								</div>
								<div class="mb-3">
									<h4>Address: </h4>
									<input name="caddress" value="<?php echo $data['caddress'] ?? ''; ?>"
														style="width:50%;">
								</div>

								<div class="mb-3">
									<h4>Password: </h4>
									<input name="cpass" value="<?php echo $data['cpass'] ?? ''; ?>" style="width:50%;">
								</div>


							</div>
							<input type="submit" name="edit" value="edit" class="edit-btn"/>
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
	</div>	

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</html>