<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);



	$_SESSION;


?>

<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Home employee
    	</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Home</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the home page</h1>
		<div style="text-align:center;">
			<br>
			Hello,<?php echo $employee_data['efullName']; ?>

			<br>
			logined as employee, options:
			<br>
			<a href="BrowseRooms_employee.php"> Browse Rooms to book</a><br>
			<a href="BookReservation_employee.php"> See/Book Reservations</a> <br>
			<a href="PayBooking_employee.php"> See/Pay Bookings</a> <br>
			<a href="modifyInfo_employee.php"> Modify infos</a>

			<br><br><br>
		</div>
		 


		

</body>
</html>