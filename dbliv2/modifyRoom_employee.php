<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

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
			try{	
            	$query ="UPDATE room SET room_number=$room_number, hotel_id=$hotel_id, price=$price, peopleCapacity=$peopleCapacity, view ='$view', extandable=$extandable, damage='$damage' WHERE room_id = $room_id    ";
            	$result = $con->query($query);
			}catch (Exception $e){
					
				echo "<h1 style= \"color:red ; text-align: center;\"> Error! There must be a problem with the type of your input</h1>";
				echo $e->getMessage();
				//exit;
			}

        }if(isset($_POST['delete'])){
            $room_id = $_POST['room_id2'];
            $query = "DELETE FROM room WHERE room_id=$room_id";
            //echo "delete room with room_id= $room_id";
            $result = $con->query($query); 
        }if(isset($_POST['add'])){
            $room_number = $_POST['room_number1'];
            $hotel_id =$_POST['hotel_id1'];
            $price = $_POST['price1'];
            $peopleCapacity = $_POST['peopleCapacity1'];            
            $view = $_POST['view1'];
            $extandable =$_POST['extandable1'];
            $damage = $_POST['damage1'];
            //echo "room_number = $room_number";
			if(!empty($room_number) && !empty($hotel_id) && !empty($price  ) && !empty($peopleCapacity ) && !empty($view ) &&  !empty($extandable) && !empty($damage)  ){
				//save to database
				try{
					$query = "INSERT INTO Room (room_number, hotel_id, price, peopleCapacity, view, extandable,damage) VALUES ($room_number,$hotel_id,$price,$peopleCapacity, '$view', $extandable, '$damage')";
					$result = $con->query($query);
				}catch (Exception $e){
					
					echo "<h1 style= \"color:red ; text-align: center;\"> Error! There must be a problem with the type of your input</h1>";
					echo $e->getMessage();
					//exit;
				}

			}else{
				echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
			}
            
        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyRooms employee
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyRooms</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Rooms page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add a room</div>
				<br><br>
				<input id="text" type="text" name="room_number1" placeholder="room_number"><br><br>
                
                <select name="hotel_id1">
                    <option value="">Select hotel_id</option>
                    <?php 
                        $query ="SELECT DISTINCT hotel_id FROM hotel";
                        $result = $con->query($query);
                        if($result->num_rows> 0){
                            while($optionData=$result->fetch_assoc()){
                            $option =$optionData['hotel_id'];
                            //$id =$optionData['hotel_id'];
                        ?>
                        <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                    <?php
                    }}
                    ?>
                </select>
				
				<br><br>
                <input id="text" type="text" name="price1" placeholder="price $"><br><br>
                <input id="text" type="text" name="peopleCapacity1" placeholder="peopleCapacity"><br><br>
                <input id="text"  type="text" name="view1" placeholder="view"><br><br>
                <select name="extandable1"> 
					<option value="">Select extandable(0-1) </option>
					<option value="0"> 0 </option>
					<option value ="1"> 1</option>
				</select>
				<br><br>
                <input id="text"  type="text" name="damage1" placeholder="damage description"><br><br>

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing rooms to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

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
                <form method="post">
                    <td><input style="width:0%;display: none;" name="room_id2" value="<?php echo $data['room_id']??''; ?>" readonly /><input type="submit" name="delete" value="delete"   /></td>

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