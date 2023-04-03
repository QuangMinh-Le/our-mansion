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
	<title> OurMansion | Home customer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion</h1>
		<a href="logout_customer.php"> Logout</a>
		<h1>This is the home page</h1>
		<br>
		Hello, <?php echo $client_data['cFullName']; ?>
		<br>
		 logined as customer
		 <br><br><br>
		 <h1 style= " text-align: center;"> Existing rooms to reserve:</h1>


		<div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>room_id</th>

				<th>room_number</th>
				<th>hotel_id</th>
				<th>price</th>
				<th>peopleCapacity</th>
				<th>view</th>
				<th>extandable </th>
				<th>damage</th>
				<th>chain_name</th>
				<th>star rating (1-5)</th>
				<th>city</th>
			</thead>
			<tbody>
		<?php
			if(is_array($fetchData)){      
			
			foreach($fetchData as $data){
			?>
			<tr>
			<td><?php echo $data['room_id']??''; ?></td>
			<td><?php echo $data['room_number']??''; ?></td>
			<td><?php echo $data['hotel_id']??''; ?></td>
			<td><?php echo $data['price']??''; ?></td>
			<td><?php echo $data['peopleCapacity']??''; ?></td>
			<td><?php echo $data['view']??''; ?></td>
			<td><?php echo $data['extandable ']??''; ?></td>
			<td><?php echo $data['damage']??''; ?></td>
			<td><?php echo $data['chain_name']??''; ?></td>
			<td><?php echo $data['ratingStars']??''; ?></td>
			<td><?php echo $data['city']??''; ?></td>  
			</tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchData; ?>
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