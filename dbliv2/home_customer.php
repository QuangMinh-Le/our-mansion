<?php
session_start();
include("connection.php");
include("function.php");
$client_data = check_login_customer($con);

$_SESSION;

if (isset($_POST['reserve'])) {
	$client_SSN = $_POST['client_id'];
	$room_id = $_POST['room_id'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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

	.hidden{
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
					<!-- <table class="table table-bordered" >
			<thead><tr><th>room_id</th>

				<th>room_number</th>
				<th>hotel_id</th>
				<th>price</th>
				<th>peopleCapacity</th>
				<th>view</th>
				<th>extandable </th>
				<th>damage</th>
				<th>chain_name</th>
				<th>star rating (1-5)</th>
				<th>city</th>
			</thead>
			<tbody>
		<?php
		if (is_array($fetchData)) {

			foreach ($fetchData as $data) {
				?>
		</div>
			<tr>
			<td><?php echo $data['room_id'] ?? ''; ?></td>
			<td><?php echo $data['room_number'] ?? ''; ?></td>
			<td><?php echo $data['hotel_id'] ?? ''; ?></td>
			<td><?php echo $data['price'] ?? ''; ?></td>
			<td><?php echo $data['peopleCapacity'] ?? ''; ?></td>
			<td><?php echo $data['view'] ?? ''; ?></td>
			<td><?php echo $data['extandable '] ?? ''; ?></td>
			<td><?php echo $data['damage'] ?? ''; ?></td>
			<td><?php echo $data['chain_name'] ?? ''; ?></td>
			<td><?php echo $data['ratingStars'] ?? ''; ?></td>
			<td><?php echo $data['city'] ?? ''; ?></td>  
			<td> <input type="button" value="<?php echo $data['room_id'] ?? ''; ?>" onclick= /></td>
			</tr>
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
			</tbody>
			</table> -->
				</div>
			</div>
		</div>
		<tbody>
			<?php
			if (is_array($fetchData)) {

				foreach ($fetchData as $data) {
					?>
					<div class="form">
						<form method="post">
							<h2>
								<?php echo $data['chain_name'] ?? ''; ?>
							</h2>
							<div class="mb-3">
								<h4><?php echo $data['ratingStars'] ?? ''; ?> &#11088; </h4>
							</div>
							<div class="mb-3">
								<h4>Location: <?php echo $data['city'] ?? ''; ?></h4>
							</div>
							<div class="mb-3">
								<h4>Room number: <?php echo $data['room_number'] ?? ''; ?></h4>
							</div>
							<div class="mb-3">
								<h4>View: <?php echo $data['view'] ?? ''; ?></h4>
							</div>
							<div class="mb-3">
								<h4>Price (per night): <?php echo $data['price'] ?? ''; ?></h4>
							</div>
							

							<button type="button" class="btn btn-primary" id="hide-show">Reserve</button>

							<div id="reservation_date">
								<div class="mb-3">
									<label for="startDate">Start Date</label>
									<input id="startDate" class="form-control" type="date" name="startDate"/>
								</div>
								<div class="mb-3" >
									<label for="startDate">End Date</label>
									<input id="endDate" class="form-control" type="date" name="endDate"/>
								</div>
								<div class="mb-3" >
									<label for="startDate">Total Price:</label>
								</div>

								<script>
									var startDate = document.getElementById("endDate").value;
									console.log(startDate);
								</script>

								<button type="submit" class="btn btn-primary" name="reserve">Confirm Reserve</button>
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
<script>
setHiddable("hide-show", "reservation_date");

/**
 * Ideal to set a hide/show relationship between only two elements
 * @param {string} btnId The ID of the button that toggle the view
 * @param {string} elementId The ID of the element to be toggled
 */
function setHiddable(btnId, elementId) {
    const btn = document.querySelector(`#${btnId}`);

    // Listen to clicks
    btn.addEventListener("click", (ev) => {
        const targetEl = document.querySelector(`#${elementId}`);
        // Hide if shown
        // Show if hidden
        targetEl.classList.toggle("hidden");
    });
}
</script>
</html>