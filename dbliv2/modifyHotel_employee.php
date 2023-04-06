<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchHotel = fetch_hotel($con);

    function fetch_hotel($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  hotel WHERE 1=1 ORDER BY hotel_id ASC";
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

    if($_SERVER['REQUEST_METHOD']== "POST"){//smt was posted
        if(isset($_POST['edit']) ){
            $room_id = $_POST['room_id'];
            $room_number = $_POST['room_number'];
            $hotel_id =$_POST['hotel_id'];
            $price = $_POST['price'];
            $peopleCapacity = $_POST['peopleCapacity'];            
            $view = $_POST['view'];
            $extandable =$_POST['extandable'];

            $damage = $_POST['damage'];

            $query ="UPDATE room SET room_number=$room_number, hotel_id=$hotel_id, price=$price, peopleCapacity=$peopleCapacity, view ='$view', extandable=$extandable, damage='$damage' WHERE room_id = $room_id    ";
            $result = $con->query($query);

        }if(isset($_POST['delete'])){
            $room_id = $_POST['room_id2'];
            $query = "DELETE FROM room WHERE room_id=$room_id";
            //echo "delete room with room_id= $room_id";
            $result = $con->query($query); 
        }if(isset($_POST['add'])){
            $chain_name = $_POST['chain_name1'];
            $ratingStars =$_POST['ratingStars1'];
            $city = $_POST['city1'];
            $address = $_POST['address1'];            
            $phone = $_POST['phone1'];
            $email =$_POST['email1'];
            //echo "room_number = $room_number1";
            $query = "INSERT INTO Hotel (chain_name, ratingStars, numberOfRooms, city , address, phone, email) VALUES ('$chain_name',$ratingStars,0,'$city','$address', '$phone', '$email')";
            $result = $con->query($query);
        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyHotel employee
    	</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
				padding:10px;
			}
		</style>
</head>
<body>
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyHotel</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Hotel page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add a hotel</div>
				<br><br>
				<input id="text" type="text" name="chain_name1" placeholder="chain_name"><br><br>
                <input id="text" type="text" name="ratingStars1" placeholder="ratingStars (1-5)"><br><br>
                <input id="text" type="text" name="city1" placeholder="city"><br><br>
                <input id="text" type="text" name="address1" placeholder="address"><br><br>
                <input id="text"  type="text" name="phone1" placeholder="phone"><br><br>
                <input id="text"  type="text" name="email1" placeholder="email"><br><br>
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing hotels to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>hotel_id</th>

				<th>chain_name</th>
				<th>ratingStars</th>
				<th style="width: 20%;">numberOfRooms</th>
				<th>city</th>
				<th style="width:50%;">address</th>
				<th>phone </th>
				<th style="width:200%;">email</th>
			</thead>
            <tbody>
		<?php
			if(is_array($fetchHotel)){      
			
			foreach($fetchHotel as $data){
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
                <form method="post">
                    <td><input style="width:0%" name="room_id2" value="<?php echo $data['room_id']??''; ?>" /><input type="submit" name="delete" value="delete"   /></td>

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