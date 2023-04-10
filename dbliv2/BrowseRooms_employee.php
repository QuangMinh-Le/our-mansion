<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    if($_SERVER['REQUEST_METHOD']== "POST"){
        if( isset($_POST['submit'])){
            $city= $_POST['city'];
            $peopleCapacity= $_POST['peopleCapacity'];
            $chain_name = $_POST['chain_name']; 
            $ratingStars = $_POST['ratingStars'];
            $lowprice = $_POST['lowprice']; 
            $highprice = $_POST['highprice'];
            $view = $_POST['view'];

            $query ="SELECT room_id, room_number, room.hotel_id, price, peopleCapacity, view, extandable, damage, chain_name, ratingStars, city,numberOfRooms  FROM room, hotel  WHERE hotel.hotel_id=room.hotel_id AND city=$city AND peopleCapacity=$peopleCapacity AND chain_name=$chain_name AND ratingStars=$ratingStars AND view = $view AND price BETWEEN $lowprice AND $highprice ;";
            $result = $con->query($query);
            if($result->num_rows> 0){
                $roomsBrowsed= mysqli_fetch_all($result, MYSQLI_ASSOC);
            }else{
                $roomsBrowsed=[];
            }
        }
        if(isset($_POST['book'])){
     
            $employee_SSN  = $employee_data['employee_SSN'];
            //echo "$client_SSN    ";
            
            $client_SSN = $_POST['client_SSN'];
            $room_id = $_POST['room_id'];
            $startDate = date('Y-m-d', strtotime($_POST['startDate']));
            $endDate = date('Y-m-d', strtotime($_POST['endDate']));

           if(!empty($client_SSN) && !empty($startDate) && !empty($endDate)){
                $query ="INSERT INTO booking (employee_SSN, client_SSN, room_id, startDate, endDate, archived, paid) values ('$employee_SSN', $client_SSN, $room_id, '$startDate', '$endDate', 0,0)";
                //$query ="INSERT INTO Reservation (client_SSN, room_id, startDate, endDate, archived) values ($client_SSN, $room_id, '$startDate', '$endDate', 0)";
                try{
                    $result = mysqli_query($con, $query);
                }catch (Exception $e){
                    echo "<p style= \"color:red\"> Booking counldn't be created! Try again!</p>";
                    echo $e->getMessage();
                    //exit;
                }
            }else{
                echo "<h1 style= \"color:red\"> Please fill all the fields</h1>";
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
         <br><br>
		 every time you click submit, the dropdowns are set back to default value

         <form action="" method="post">
            <select name="city">
                <option value="city">Select City</option>
                <?php 
                    $query ="SELECT DISTINCT city FROM hotel";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['city'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            <select name="peopleCapacity">
                <option value="peopleCapacity">Select people capacity</option>
                <?php 
                    $query ="SELECT DISTINCT peopleCapacity FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['peopleCapacity'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            <select name="chain_name">
                <option value="chain_name">Select hotel chain</option>
                <?php 
                    $query ="SELECT DISTINCT chain_name FROM HotelChain";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['chain_name'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="ratingStars">
                <option value="ratingStars">Select rating categorie</option>
                <?php 
                    $query ="SELECT DISTINCT ratingStars FROM Hotel";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['ratingStars'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="view">
                <option value="view">Select room view</option>
                <?php 
                    $query ="SELECT DISTINCT view FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['view'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>
            
            <select name="lowprice">
                <option value="0">Select lowest price</option>
                <?php 
                    $query ="SELECT DISTINCT price FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['price'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <select name="highprice">
                <option value="1000000">Select highest price</option>
                <?php 
                    $query ="SELECT DISTINCT price FROM Room";
                    $result = $con->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['price'];
                        //$id =$optionData['hotel_id'];
                    ?>
                    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                <?php
                }}
                ?>
            </select>

            <input type="submit" name="submit" value="submit"/>
        </form>

        !-----display data-->
    <?php
    if(isset($roomsBrowsed)>0)
    {
    ?>
    <table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>room_id</th>
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
        <th> total numberOfRooms in hotel</th>
    </tr>
    <?php
       if(count($roomsBrowsed)>0)
       {
    
    foreach ($roomsBrowsed as $data) {
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
            <td><?php echo $data['numberOfRooms']??''; ?></td> 
			<td><form method="post">
                <input style="width:0%; display: none;" name="room_id" value="<?php echo $data['room_id']??''; ?>" readonly /> 
                <select name="client_SSN">
                    <option value="">Select client_SSN</option>
                    <?php 
                        $query ="SELECT DISTINCT client_SSN FROM client";
                        $result = $con->query($query);
                        if($result->num_rows> 0){
                            while($optionData=$result->fetch_assoc()){
                            $option =$optionData['client_SSN'];
                            //$id =$optionData['hotel_id'];
                        ?>
                        <option value="'<?php echo $option; ?>'" ><?php echo $option; ?> </option>
                    <?php
                    }}
                    ?>
                </select><br>
                <label for="startDate">Start Date</label>
				<input id="startDate" class="form-control" type="date" name="startDate"/>
                
                <label for="startDate">End Date</label>
				<input id="endDate" class="form-control" type="date" name="endDate"/>

                <input type="submit" value="book" name="book" />
                </form>
            </td>
</tr>
     <?php
   
   }
}else{
    echo "<tr><td colspan='3'>No Data Found</td></tr>";
}
?>
</table>
<?php
}
?>
         
         

</body>
</html>