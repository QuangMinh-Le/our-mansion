<?php
session_start();
	include("connection.php");
	include("function.php");

	if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
		$email = $_POST['user_name'];
		$epass = $_POST['password'];
		if(!empty($email) && !empty($epass)){
			//read from database
			$user_id;
			$query ="SELECT * FROM Employee WHERE email = '$email' LIMIT 1 ";

			$result = mysqli_query($con, $query);

			if($result && mysqli_num_rows($result) >0){
				$employee_data = mysqli_fetch_assoc($result);
				if ($employee_data['epass'] === $epass){
					$_SESSION['employee_SSN'] = $employee_data['employee_SSN'];
					header("Location: home_employee.php");
					die;
				}
			}
			echo"<h1 style= \"color:red ; text-align: center;\">Wrong username or password!</h1>";
		}else{
			echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title> OurMansion | login employee
        	</title>
	</head>
	<body>
	    <h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
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
		<div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Login employee</div>
				<br><br>
				<input id="text" type="text" name="user_name" placeholder="email/username"><br><br>
				<input id="text"  type="password" name="password" placeholder="password"><br><br>
				<input id="button"  type="submit" value="Login" ><br><br>

				<a href="signup_employee.php">Click to Signup</a><br><br>

			</form>
		</div>
	</body>

</html>