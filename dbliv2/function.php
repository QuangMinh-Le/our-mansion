<?php

function check_login_customer($con)
{
	if ( isset ($_SESSION['client_SSN'] )){
		$client_SSN = $_SESSION['client_SSN'];
		$query = "SELECT * FROM client WHERE client_SSN = '$client_SSN' LIMIT 1";
		$result = mysqli_query($con, $query);
		if($result && mysqli_num_rows($result) >0){
			$client_data = mysqli_fetch_assoc($result);
			return $client_data;
		}
		
	}
	//redirect to login
	header("Location: login_customer.php");
	die;
}

function check_login_employee($con)
{
	if ( isset ($_SESSION['employee_SSN'] )){
		$employee_SSN = $_SESSION['employee_SSN'];
		$query = "SELECT * FROM employee WHERE employee_SSN = '$employee_SSN' LIMIT 1";
		$result = mysqli_query($con, $query);
		if($result && mysqli_num_rows($result) >0){
			$employee_data = mysqli_fetch_assoc($result);
			return $employee_data;
		}

	}
	//redirect to login
	header("Location: login_employee.php");
	die;
}


