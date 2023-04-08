<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchHotelChain = fetch_hotel_chain($con);

    function fetch_hotel_chain($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  hotelchain WHERE 1=1 ";
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

            $chain_name = $_POST['chain_name'];            
            $address = $_POST['address'];
            $phone =$_POST['phone'];
            $email = $_POST['email'];
            //no change to number of hotel

            $query ="UPDATE hotelchain SET   centralAddress ='$address', centralPhone  ='$phone', centralEmail ='$email' WHERE chain_name='$chain_name' ";
            $result = $con->query($query);

        }if(isset($_POST['delete'])){
            $chain_name = $_POST['chain_name2'];
            $query = "DELETE FROM Hotelchain WHERE chain_name= '$chain_name'";
            
            $result = $con->query($query); 
        }if(isset($_POST['add'])){
            $chain_name = $_POST['chain_name1'];
            $address = $_POST['address1'];            
            $phone = $_POST['phone1'];
            $email =$_POST['email1'];
            //echo "room_number = $room_number1";
            if(!empty($chain_name)  && !empty($address ) && !empty($phone ) && !empty($email)   ){
				//save to database
                $query = "INSERT INTO Hotelchain (chain_name, centralAddress , centralPhone , centralEmail,numberOfHotels  ) VALUES ('$chain_name','$address', '$phone', '$email', 0)";
                $result = $con->query($query);

            }else{
				echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
			}
        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyHotelChain employee
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyHotelChain</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify HotelChain page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add a hotelchain</div>
				<br><br>
				<input id="text" type="text" name="chain_name1" placeholder="chain_name"><br><br>
                <input id="text" type="text" name="address1" placeholder="address"><br><br>
                <input id="text"  type="text" name="phone1" placeholder="phone"><br><br>
                <input id="text"  type="text" name="email1" placeholder="email"><br><br>
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing hotelChain to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr>

				<th style="width:15%;">chain_name</th>
				<th style="width:15%;">address</th>
				<th style="width:20%;">phone </th>
				<th style="width:500px;">email</th>
                <th style="width:500px;">numberOfHotels </th>
			</thead>
            <tbody>
		<?php
			if(is_array($fetchHotelChain)){      
			
			foreach($fetchHotelChain as $data){
			?>
			<tr>
                <form method="post">
                    

                    <td><input name="chain_name" value="<?php echo $data['chain_name']??''; ?>" style="width:100%;"></td>
                
                    <td><input name="address" value="<?php echo $data['centralAddress']??''; ?>" style="width:110%;"></td>
                    <td><input name="phone" value="<?php echo $data['centralPhone']??''; ?>" style="width:50%;"></td>
                    <td><input name="email" value="<?php echo $data['centralEmail']??''; ?>" style="width:100%;"></td>
                    <td><input name="numberOfHotels " value="<?php echo $data['numberOfHotels']??''; ?>" style="width:75%;" readonly></td>
                    

                    <td> <input type="submit" name="edit"  value="edit" /></td>
                </form>
                <form method="post">
                    <td><input style="width:0%" name="chain_name2" value="<?php echo $data['chain_name']??''; ?>" readonly/><input type="submit" name="delete" value="delete"   /></td>
                        
                </form>

            </tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchHotelChain; ?>
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