<?php

session_start();
	include("connection.php");
	include("function.php");

	if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
		$employee_SSN = $_POST['employee_SSN'];
		$hotel_id = $_POST['hotel_id'];
		$email = $_POST['email'];
        $efullName = $_POST['efullName'];
		$eaddress = $_POST['eaddress'];
		$jobPosition = $_POST['jobPosition'];
		$epass= $_POST['epass'];
		if(!empty($employee_SSN) && !empty($hotel_id) && !empty($email  ) && !empty($efullName ) && !empty($eaddress ) && !empty($jobPosition) && !empty($epass)  ){
			//save to database

			$query = "insert into Employee (employee_SSN, hotel_id, email, efullName, eaddress, jobPosition, epass ) value ('$employee_SSN ', '$hotel_id','$email','$efullName','$eaddress','$jobPosition','$epass' )";
            mysqli_query($con, $query);
			header("Location: login_employee.php");
			die;
		}else{
			echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
		}
	}
?>




<!DOCTYPE html>
<html>
	<head>
		<title> OurMansion | signup employee
        	</title>
	</head>
	<body>
		<style type="text/css">
			#text{
				height: 25px;
				border-radius:5px;
				padding:4px;
				border: solid thin #aaa;
				width: 100%

			}
			#button{
				padding:10px;
				width:100px;
				color:white;
				background-color: Lightblue;
				border: none;
			}
			#box{
				background-color:grey;
				margin:auto;
				width: 300px;
				padding:20px;
			}
		</style>
		<h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
		<div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Signup employee</div>
				<br><br>
				<input id="text" type="text" name="employee_SSN" placeholder="employee_SSN"><br><br>
				<input id="text" type="text" name="hotel_id" placeholder="hotel_id VALUES BETWEEN(1-40)"><br><br>
				<input id="text" type="text" name="email" placeholder="email/username"><br><br>
				<input id="text" type="text" name="efullName" placeholder="fullName"><br><br>
				<input id="text" type="text" name="eaddress" placeholder="address"><br><br>
				<input id="text" type="text" name="jobPosition" placeholder="jobPosition"><br><br>


				<input id="text"  type="password" name="epass" placeholder="password"><br><br>
				<input id="button"  type="submit" value="sign up"><br><br>
				<a href="login_employee.php">Click to Login</a><br><br>

			</form>
		</div>
	</body>

</html>



