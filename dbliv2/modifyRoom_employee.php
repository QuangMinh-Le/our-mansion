<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
        if(isset($_POST['edit']) ){
            

        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyRooms employee
    	</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyRooms</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Rooms page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>


         <h1 style= " text-align: center;"> Existing rooms to modify:</h1>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>room_id</th>

				<th>room_number</th>
				<th>hotel_id</th>
				<th style="width: 20%;">price</th>
				<th>peopleCapacity</th>
				<th style="width:50%;">view</th>
				<th>extandable </th>
				<th style="width:200%;">damage</th>
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
                <form method="post">
                    <td><input name="room_id" value="<?php echo $data['room_id']??''; ?>" style="width:100%;" readonly></td>

                    <td><input name="room_number" value="<?php echo $data['room_number']??''; ?>" style="width:25%;"></td>
                    <td><input name="hotel_id" value="<?php echo $data['hotel_id']??''; ?>" style="width:50%;"></td>
                    <td><input name="price" value="<?php echo $data['price']??''; ?>" style="width:75%;"></td>
                    <td><input name="peopleCapacity" value="<?php echo $data['peopleCapacity']??''; ?>" style="width:50%;"></td>
                    <td><input name="view" value="<?php echo $data['view']??''; ?>" style="width:110%;"></td>
                    <td><input name="extandable" value="<?php echo $data['extandable']??''; ?>" style="width:50%;"></td>
                    <td><input name="damage" value="<?php echo $data['damage']??''; ?>" style="width:110%;"></td>

                    <td><?php echo $data['chain_name']??''; ?></td>
                    <td><?php echo $data['ratingStars']??''; ?></td>
                    <td><?php echo $data['city']??''; ?></td>

                    <td> <input type="submit" name="edit"  value="edit" /></td>
                </form>
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