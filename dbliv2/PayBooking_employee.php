<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

	
	$tableName1="booking";
	$fetchBooking = fetch_booking($con, $tableName1);

   function fetch_booking($db, $tableName){
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

   function payBooking ($con, $booking_id ){
		$query = "UPDATE Booking SET paid = TRUE WHERE booking_id =$booking_id";
        $result = mysqli_query($con, $query);
		if($result)
		{
			echo "<p> Booking payed for id= '$booking_id' ! </p> ";
		}
		else
		{
			echo "<p> Booking counldn't be payed! Try again!</p>";
		}
   }

    if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
        $booking_id = $_POST['booking_id'];
        
        //echo"<p> $reservation_id $client_SSN  $room_id  $startDate $endDate  $archived </p>";
		try{
        	payBooking($con, $booking_id);
		}catch (Exception $e){
			echo "<p style= \"color:red\"> Booking counldn't be payed! Try again!</p>";
			echo $e->getMessage();
			//exit;
		}

    }


?>

<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Pay Booking employee
    	</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Bookings</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the booking page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
         <br>
         <a href="home_employee.php"> back to home</a>

		 <br><br><br>
		 <h1 style= " text-align: center;"> Existing booking to pay:</h1>
		 <p style= " text-align: center;"> please reload page after paying, to display the change</p>


		<div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr>
                <th>booking_id</th>
                <th>reservation_id</th>
				<th>client_SSN</th>
				<th>room_id</th>
				<th>startDate</th>
				<th>endDate</th>
				<th>archived</th>
                <th>paid</th>
				
			</thead>
			<tbody>
		<?php
			if(is_array($fetchBooking)){      
			
			foreach($fetchBooking as $data){
			?>
			<tr>
			<td><?php echo $data['booking_id']??''; ?></td>
            <td><?php echo $data['reservation_id']??''; ?></td>
			<td><?php echo $data['client_SSN']??''; ?></td>
			<td><?php echo $data['room_id']??''; ?></td>
			<td><?php echo $data['startDate']??''; ?></td>
			<td><?php echo $data['endDate']??''; ?></td>
			<td><?php echo $data['archived']??''; ?></td>  
            <td><?php echo $data['paid']??''; ?></td>   
			<td> <form method="post">
                    <input style="width:0.1%; display: none;" name="booking_id" value="<?php echo $data['booking_id']??''; ?>" readonly>
                    <input type="submit" value="pay booking" />
                 </form>
            </td>
			</tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchBooking; ?>
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