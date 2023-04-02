<?php
session_start();
	include("connection.php");
	include("function.php");
	$client_data = check_login_customer($con);
	
	
	
	$_SESSION; 


?>

<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Home customer
    	</title>
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
		<a href="logout_customer.php"> Logout</a>
		<h1>This is the home page</h1>
		<br>
		Hello, <?php echo $client_data['cFullName']; ?>
		<br>
		 logined as customer
		
</body>
</html>