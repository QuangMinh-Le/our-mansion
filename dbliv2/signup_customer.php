<?php

session_start();
	include("connection.php");
	include("function.php");
	
	if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
        $client_SSN = $_POST['client_SSN'];
        $cmail = $_POST['cmail'];
        $cFullName = $_POST['cFullName'];
        $caddress = $_POST['caddress'];
        $cpass= $_POST['cpass'];
        if(!empty($client_SSN)  && !empty($cmail  ) && !empty($cFullName) && !empty($caddress )  && !empty($cpass)  ){
            //save to database

            $query = "insert into Client (client_SSN,  cmail, cFullName, caddress, cpass ) value ('$client_SSN', '$cmail','$cFullName','$caddress','$cpass' )";
            mysqli_query($con, $query);
            header("Location: login_customer.php");
            die;
        }else{
			echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
        }
    }
?>

	


<!DOCTYPE html>
<html>
	<head>
		<title> OurMansion | signup customer
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
				<div style="font-size:20px;margin:10px;color:black;color:white;">Signup customer</div>
				<br><br>
				<input id="text" type="text" name="client_SSN" placeholder="client_SSN"><br><br>
                <input id="text" type="text" name="cmail" placeholder="mail/username"><br><br>
                <input id="text" type="text" name="cFullName" placeholder="FullName"><br><br>
                <input id="text" type="text" name="caddress" placeholder="address"><br><br>


                <input id="text"  type="password" name="cpass" placeholder="password"><br><br>
				<input id="button"  type="submit" value="sign up"><br><br>
				<a href="login_customer.php">Click to Login</a><br><br>
				
			</form>
		</div>
	</body>
	
</html>



