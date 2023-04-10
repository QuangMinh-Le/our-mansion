<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

	
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
		$query = "INSERT INTO Booking (reservation_id,employee_SSN, client_SSN, room_id, startDate, endDate, archived, paid) VALUE ('$reservation_id','$employee_SSN','$client_SSN','$room_id', '$startDate','$endDate', '$archived', FALSE )";
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

    if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
        $reservation_id = $_POST['reservation_id'];
        $employee_SSN = $employee_data['employee_SSN'];
        $client_SSN= $_POST['client_SSN'];
        $room_id = $_POST['room_id'];
        $startDate = $_POST['startDate'];
        $endDate =  $_POST['endDate'];
        $archived = $_POST['archived'];
        //echo"<p> $reservation_id $client_SSN  $room_id  $startDate $endDate  $archived </p>";
		try{
        	bookReservation($con,$reservation_id, $employee_SSN, $client_SSN, $room_id, $startDate, $endDate, $archived);
		}catch (Exception $e){
			echo "<p style= \"color:red\"> Booking counldn't be created! Maybe booking already exist for this reservation !</p>";
			echo $e->getMessage();
			//exit;
		}

    }


?>

<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Book reservation employee
    	</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Reservations</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the reservation page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
         <br>
         <a href="home_employee.php"> back to home</a>

		 <br><br><br>
		 <h1 style= " text-align: center;"> Existing reservations to book:</h1>


		<div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>reservation_id</th>

				<th>client_SSN</th>
				<th>room_id</th>
				<th>startDate</th>
				<th>endDate</th>
				<th>archived</th>
				
			</thead>
			<tbody>
		<?php
			if(is_array($fetchReservation)){      
			
			foreach($fetchReservation as $data){
			?>
			<tr>
			<td><?php echo $data['reservation_id']??''; ?></td>
			<td><?php echo $data['client_SSN']??''; ?></td>
			<td><?php echo $data['room_id']??''; ?></td>
			<td><?php echo $data['startDate']??''; ?></td>
			<td><?php echo $data['endDate']??''; ?></td>
			<td><?php echo $data['archived']??''; ?></td>
			<td> <form method="post">
                    <input style="width:0.1%; display: none;" name="reservation_id" value="<?php echo $data['reservation_id']??''; ?>" readonly> 
                    <input style="width:0.1%;  display: none;" name="client_SSN" value="<?php echo $data['client_SSN']??''; ?>"readonly> 
                    <input style="width:0.1%; display: none;" name="room_id" value="<?php echo $data['room_id']??''; ?>"readonly> 
                    <input style="width:0.1%; display: none;" name="startDate" value="<?php echo $data['startDate']??''; ?>"readonly> 
                    <input style="width:0.1%; display: none;" name="endDate" value="<?php echo $data['endDate']??''; ?>"readonly> 
                    <input style="width:0.1%; display: none;" name="archived" value="<?php echo $data['archived']??''; ?>"readonly> 
                    <input type="submit" value="book reservation" />
                 </form>
            </td>
			</tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchReservation; ?>
		</td>
			<tr>
			<?php
			}?>
			</tbody>
			</table>
		</div>
		</div>
		</div>
		</div>

</body>
</html>