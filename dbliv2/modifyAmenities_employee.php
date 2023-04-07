<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchAmenities = fetch_amenities($con);

    function fetch_amenities($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM Amenities WHERE 1=1 ORDER BY room_id ASC";
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

            $TV = $_POST['TV'];
            $AC =$_POST['AC'];
                     
            $fridge = $_POST['fridge'];            
            $kitchen = $_POST['kitchen'];

            $query ="UPDATE Amenities SET TV=$TV, AC=$AC, fridge=$fridge, kitchen=$kitchen WHERE room_id = $room_id";
            $result = $con->query($query);

        }if(isset($_POST['delete'])){
            $room_id = $_POST['room_id2'];
            $query = "DELETE FROM Amenities WHERE room_id=$room_id";
            //echo "delete hotel with hotel_id= $hotel_id";
            $result = $con->query($query); 
        }if(isset($_POST['add'])){
            $room_id = $_POST['room_id1'];
            $TV =$_POST['TV1'];
            $AC = $_POST['AC1'];
            $fridge = $_POST['fridge1'];            
            $kitchen = $_POST['kitchen1'];
           
            //echo "room_number = $room_number1";
            if(!empty($room_id) && !empty($TV) && !empty($AC  ) && !empty($fridge ) && !empty($kitchen )   ){
				//save to database
                $query = "INSERT INTO Amenities (room_id, TV, AC, fridge , kitchen) VALUES ($room_id,$TV,$AC,$fridge,$kitchen)";
                $result = $con->query($query);
                //echo "inserted";

            }else{
				echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
			}
        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyAmenities employee
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyAmenities</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Room's Amenities page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add Amenities for a existing room</div>
				<br><br>
				<input id="text" type="text" name="room_id1" placeholder="room_id"><br><br>
                <input id="text" type="text" name="TV1" placeholder="TV (0-1)"><br><br>
                <input id="text" type="text" name="AC1" placeholder="AC (0-1)"><br><br>
                <input id="text" type="text" name="fridge1" placeholder="fridge (0-1)"><br><br>
                <input id="text"  type="text" name="kitchen1" placeholder="kitchen (0-1)"><br><br>
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing amenities to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>room_id</th>

				<th>TV</th>
				<th>AC</th>
				<th style="width: 20%;">fridge</th>
				<th style="width:20%;">kitchen</th>
			</thead>
            <tbody>
		<?php
			if(is_array($fetchAmenities)){      
			
			foreach($fetchAmenities as $data){
			?>
			<tr>
                <form method="post">
                    <td><input name="room_id" value="<?php echo $data['room_id']??''; ?>" style="width:100%;" readonly></td>

                    <td><input name="TV" value="<?php echo $data['TV']??''; ?>" style="width:100%;"></td>
                    <td><input name="AC" value="<?php echo $data['AC']??''; ?>" style="width:50%;"></td>
                    <td><input name="fridge" value="<?php echo $data['fridge']??''; ?>" style="width:75%;" ></td>
                    <td><input name="kitchen" value="<?php echo $data['kitchen']??''; ?>" style="width:50%;"></td>
                    

                    

                    <td> <input type="submit" name="edit"  value="edit" /></td>
                </form>
                <form method="post">
                    <td><input style="width:0%" name="room_id2" value="<?php echo $data['room_id']??''; ?>" readonly/><input type="submit" name="delete" value="delete"   /></td>

                </form>

            </tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchAmenities; ?>
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