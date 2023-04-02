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
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the home page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee

</body>
</html>