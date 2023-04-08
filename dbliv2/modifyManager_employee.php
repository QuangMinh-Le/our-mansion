<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchManager = fetch_manager($con);

    function fetch_manager($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  manager WHERE 1=1 ORDER BY hotel_id ASC";
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
        if(isset($_POST['delete'])){
            $hotel_id = $_POST['hotel_id2'];
            $query = "DELETE FROM Manager WHERE hotel_id=$hotel_id";
            //echo "delete hotel with hotel_id= $hotel_id";
            $result = $con->query($query); 
        }if(isset($_POST['add'])){
            $employee_SSN = $_POST['employee_SSN1'];
			$hotel_id = $_POST['hotel_id1'];
			
			if(!empty($employee_SSN) && !empty($hotel_id)  ){
				//save to database

				$query = "insert into Manager (hotel_id, employee_SSN ) value ('$hotel_id','$employee_SSN ' )";
				mysqli_query($con, $query);
				
			}else{
				echo"<h1 style= \"color:red ; text-align: center;\">Please enter all fields!</h1>";
			}
        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyEmployee employee
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyManager</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Manager page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add an Employee</div>
				<br><br>
				<input id="text" type="text" name="hotel_id1" placeholder="hotel_id VALUES BETWEEN(1-40)"><br><br>
                <input id="text" type="text" name="employee_SSN1" placeholder="employee_SSN"><br><br>
				
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing manager to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr>
                <th>hotel_id</th>   
                <th>employee_SSN</th>
			</thead>
            <tbody>
		<?php
			if(is_array($fetchManager)){      
			
			foreach($fetchManager as $data){
			?>
			<tr>
                <form method="post">
                    <td><input name="hotel_id" value="<?php echo $data['hotel_id']??''; ?>" style="width:100%;" readonly></td>
                    <td><input name="employee_SSN" value="<?php echo $data['employee_SSN']??''; ?>" style="width:100%;" ></td>

                    
                </form>
                <form method="post">
                    <td><input style="width:0%" name="hotel_id2" value="<?php echo $data['hotel_id']??''; ?>" readonly />
                    <input type="submit" name="delete" value="delete"   /></td>

                </form>

            </tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchManager; ?>
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