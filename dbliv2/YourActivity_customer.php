<?php
session_start();
	include("connection.php");
	include("function.php");
	$client_data = check_login_customer($con);
    $client_SSN = $client_data['client_SSN'];

    $tableName1="reservation";
	$fetchReservation = fetch_yourdata($con, $tableName1, $client_SSN);

   function fetch_yourdata($db, $tableName, $client_SSN){
	if(empty($db)){
		$msg= "Database connection error";
		}elseif(empty($tableName)){
		$msg= "Table Name is empty";
	}else{
		$query = "SELECT * FROM $tableName"." WHERE client_SSN = '$client_SSN' ORDER BY reservation_id ASC";
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
	
    $tableName1="booking";
	$fetchBooking = fetch_yourdata($con, $tableName1, $client_SSN);




	$_SESSION; 
?>

<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Your Activity customer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Your Activity</h1>
		<a href="logout_customer.php"> Logout</a>
		
		<br>
		Hello, <?php echo $client_data['cFullName']; ?>
		<br>
		 logined as customer
		 <br>
         <a href="home_customer.php"> back to home</a>
		 

		 <br><br>
         <h1 style= " text-align: center;"> Your past reservations:</h1>

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

        <br><br>
        <h1 style= " text-align: center;"> Your past bookings:</h1>

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