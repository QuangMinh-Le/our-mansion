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

$db = $con;
$tableName="room";
$columns= ['room_id', 'room_number','room.hotel_id','price','peopleCapacity', 'view','extandable','damage','chain_name','ratingStars', 'city'];
$fetchData = fetch_data($db, $tableName, $columns);


function fetch_data($db, $tableName, $columns){
	if(empty($db)){
	 $msg= "Database connection error";
	}elseif (empty($columns) || !is_array($columns)) {
	 $msg="columns Name must be defined in an indexed array";
	}elseif(empty($tableName)){
	  $msg= "Table Name is empty";
   }else{
	   
   $columnName = implode(", ", $columns);
   $query = "SELECT ".$columnName." FROM $tableName".", hotel WHERE hotel.hotel_id=room.hotel_id ORDER BY room_id ASC";
   $result = $db->query($query);
   if($result== true){ 
	if ($result->num_rows > 0) {
	   $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
	   $msg= $row;
	} else {
	   $msg= "No Data Found"; 
	}
   }else{
	 $msg= mysqli_error($db);
   }
   }
   return $msg;
   }

   	$tableName1="reservation";
	$fetchReservation = fetch_reservations($db, $tableName1);

   function fetch_reservations($db, $tableName){
	if(empty($db)){
		$msg= "Database connection error";
		}elseif(empty($tableName)){
		$msg= "Table Name is empty";
	}else{
		$query = "SELECT * FROM $tableName"." ORDER BY reservation_id ASC";
		$result = $db->query($query);
		if($result== true){ 
			if ($result->num_rows > 0) {
				$row= mysqli_fetch_all($result, MYSQLI_ASSOC);
				$msg= $row;
			} else {
			 	$msg= "No Data Found"; 
			}
		}else{
			$msg= mysqli_error($db);
		}
	}
	return $msg;
   }

   function bookReservation ($con, $reservation_id, $employee_SSN, $client_SSN, $room_id, $startDate, $endDate, $archived  ){
		$query = "INSERT INTO Booking (reservation_id,employee_SSN, client_SSN, room_id, startDate, endDate, archived, paid) VALUE ('$reservation_id','$employee_SSN','$client_SSN','$room_id', '$startDate','$endDate', '$archived', TRUE )";
		$result = mysqli_query($con, $query);
		if($result)
		{
			echo "<p> Booking created for reservation_id '$reservation_id' ! </p> ";

		}
		else
		{
			echo "<p> Booking counldn't be created! Maybe booking already exist for this reservation !</p>";

		}
   }