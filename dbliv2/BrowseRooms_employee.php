<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    if($_SERVER['REQUEST_METHOD']== "POST"){
        if(isset($_POST['city']) && isset($_POST['submit'])){
            $city= $_POST['city'];
            $query ="SELECT room_id, room_number, room.hotel_id, price, peopleCapacity, view, extandable, damage, chain_name, ratingStars, city FROM room, hotel  WHERE hotel.hotel_id=room.hotel_id AND city='$city' ;";
            $result = $conn->query($query);
            if($result->num_rows> 0){
                $roomsBrowsed= mysqli_fetch_all($result, MYSQLI_ASSOC);
            }else{
                $roomsBrowsed=[];
            }
        }
    }



?>



<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | Browse rooms employee
    	</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>  


        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - Browse our rooms</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the browsing page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
         <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <form action="" method="post">
            <label value="">Select City</label>
            <select name="city">
                
                <?php 
                $query ="SELECT city FROM hotel";
                $result = $conn->query($query);
                if($result->num_rows> 0){
                    while($optionData=$result->fetch_assoc()){
                    $option =$optionData['city'];
                    //$id =$optionData['hotel_id'];
                ?>
                <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
            <?php
                }}
                ?>
            </select>
            <input type="submit" name="submit">
         </form>
         
         

</body>
</html>