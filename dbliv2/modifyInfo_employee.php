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
	<title> OurMansion | Info employee
    	</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Infos</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Info page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>
		 <a href="modifyRoom_employee.php"> add, update, delete rooms</a> <br> 
		 <a href="modifyAmenities_employee.php"> add, update, delete room amenities</a> <br> 
		 <a href="modifyHotel_employee.php"> add, update, delete hotels</a> <br>
		 <a href="modifyEmployee_employee.php"> add, update, delete employees</a><br>
		 <a href="modifyManager_employee.php"> add, update, delete manager</a><br>
		 <a href="modifyCustomer_employee.php"> add, update, delete customers</a>
</body>
</html>