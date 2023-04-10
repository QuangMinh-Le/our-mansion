<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchEmployee = fetch_employee($con);

    function fetch_employee($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  employee WHERE 1=1 ORDER BY employee_SSN ASC";
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
            $employee_SSN = $_POST['employee_SSN'];

            $hotel_id = $_POST['hotel_id'];
            $email =$_POST['email'];
            //no change to number of rooms            
            $efullName= $_POST['efullName'];            
            $eaddress = $_POST['eaddress'];
            $jobPosition =$_POST['jobPosition'];
            $epass = $_POST['epass'];
			try{
	            $query ="UPDATE Employee SET hotel_id='$hotel_id', email='$email', efullName='$efullName', eaddress='$eaddress', jobPosition ='$jobPosition', epass='$epass' WHERE employee_SSN = '$employee_SSN'";
    	        $result = $con->query($query);
			}catch (Exception $e){
					
				echo "<h1 style= \"color:red ; text-align: center;\"> Error! There must be a problem with the type of your input</h1>";
				echo $e->getMessage();
				//exit;
			}
        }if(isset($_POST['delete'])){
            $employee_SSN = $_POST['employee_SSN2'];
			echo "<h1 style= \"color:red ; text-align: center;\"> cannot delete all info of an employee due to reservations and bookings depending on it</h1>";
			echo "<h1 style= \"color:red ; text-align: center;\">  partial deletion of employee in database</h1>";
			$query ="UPDATE Employee SET hotel_id=NULL, email = NULL, efullName='', eaddress='', jobPosition ='', epass='' WHERE employee_SSN = '$employee_SSN'";
			$result = $con->query($query); 
			/*try{
            	$query = "DELETE FROM employee WHERE employee_SSN=$employee_SSN";
				$result = $con->query($query); 
            //echo "delete hotel with hotel_id= $hotel_id";
			}catch (Exception $e ){ echo"<h1 style= \"color:red ; text-align: center;\">error, employee is a manager,<br> please remove him from his function first!</h1>";
				echo $e->getMessage();
			}*/
            
        }if(isset($_POST['add'])){
            $employee_SSN = $_POST['employee_SSN1'];
			$hotel_id = $_POST['hotel_id1'];
			$email = $_POST['email1'];
			$efullName = $_POST['efullName1'];
			$eaddress = $_POST['eaddress1'];
			$jobPosition = $_POST['jobPosition1'];
			$epass= $_POST['epass1'];
			if(!empty($employee_SSN) && !empty($hotel_id) && !empty($email  ) && !empty($efullName ) && !empty($eaddress ) && !empty($jobPosition) && !empty($epass)  ){
				//save to database
				try{
					$query = "insert into Employee (employee_SSN, hotel_id, email, efullName, eaddress, jobPosition, epass ) value ('$employee_SSN ', '$hotel_id','$email','$efullName','$eaddress','$jobPosition','$epass' )";
					mysqli_query($con, $query);
				}catch (Exception $e ){ echo"<h1 style= \"color:red ; text-align: center;\">error,employee_SSN or email already used!</h1>";
                    echo $e->getMessage();
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyEmployees</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Employee page</h1>
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
				<input id="text" type="text" name="employee_SSN1" placeholder="employee_SSN"><br><br>
				
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
				<input id="text" type="text" name="email1" placeholder="email/username"><br><br>
				<input id="text" type="text" name="efullName1" placeholder="fullName"><br><br>
				<input id="text" type="text" name="eaddress1" placeholder="address"><br><br>
				<input id="text" type="text" name="jobPosition1" placeholder="jobPosition"><br><br>


				<input id="text"  type="password" name="epass1" placeholder="password"><br><br>
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing employee to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>employee_SSN</th>


				<th>workplace(hotel_id)</th>

				<th style="width: 50%;">email</th>
				<th style="width: 20%;">efullName</th>
				<th style="width:50%;">eaddress</th>
				<th style="width:20%;">jobPosition</th>

				<th style="width:50%;">epassword</th>

			</thead>
            <tbody>
		<?php
			if(is_array($fetchEmployee)){      
			
			foreach($fetchEmployee as $data){
			?>
			<tr>
                <form method="post">
                    <td><input name="employee_SSN" value="<?php echo $data['employee_SSN']??''; ?>" style="width:100%;" readonly></td>

                    <td><input name="hotel_id" value="<?php echo $data['hotel_id']??''; ?>" style="width:100%;"></td>
                    <td><input name="email" value="<?php echo $data['email']??''; ?>" style="width:50%;"></td>
                    <td><input name="efullName" value="<?php echo $data['efullName']??''; ?>" style="width:75%;" ></td>
                    <td><input name="eaddress" value="<?php echo $data['eaddress']??''; ?>" style="width:75%;"></td>
                    <td><input name="jobPosition" value="<?php echo $data['jobPosition']??''; ?>" style="width:110%;"></td>
                    <td><input name="epass" value="<?php echo $data['epass']??''; ?>" style="width:75%;"></td>
                    

                    

                    <td> <input type="submit" name="edit"  value="edit" /></td>
                </form>
                <form method="post">

                    <td><input style="width:0%;display: none;" name="employee_SSN2" value="<?php echo $data['employee_SSN']??''; ?>" readonly /><input type="submit" name="delete" value="delete"   /></td>


                </form>

            </tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchHotel; ?>
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