<?php
session_start();
	include("connection.php");
	include("function.php");
	$employee_data = check_login_employee($con);
	$_SESSION;

    $fetchCustomer = fetch_customer($con);

    function fetch_customer($db ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  client WHERE 1=1 ORDER BY client_SSN ASC";
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
            $client_SSN = $_POST['client_SSN'];
            
            $cmail = $_POST['cmail'];
            $cFullName = $_POST['cFullName'];
            $caddress = $_POST['caddress'];
            $cpass= $_POST['cpass'];
			try{
            	$query ="UPDATE client SET cmail='$cmail', cFullName='$cFullName', caddress='$caddress',  cpass='$cpass' WHERE client_SSN = '$client_SSN'";
            	$result = $con->query($query);
			}catch (Exception $e){
					
				echo "<h1 style= \"color:red ; text-align: center;\"> Error! There must be a problem with the type of your input</h1>";
				echo $e->getMessage();
				//exit;
			}

        }if(isset($_POST['delete'])){
            $client_SSN = $_POST['client_SSN2'];
            //$query = "DELETE FROM  client  WHERE client_SSN=$client_SSN";
            //echo "delete hotel with hotel_id= $hotel_id";
			echo "<h1 style= \"color:red ; text-align: center;\"> cannot delete all info of an client due to reservations and bookings depending on it</h1>";
			echo "<h1 style= \"color:red ; text-align: center;\">  partial deletion of client in database</h1>";
            $query ="UPDATE client SET cmail=NULL, cFullName='', caddress='',  cpass='' WHERE client_SSN = '$client_SSN'";
			$result = $con->query($query); 
        }if(isset($_POST['add'])){
            $client_SSN = $_POST['client_SSN1'];
            $cmail = $_POST['cmail1'];
            $cFullName = $_POST['cFullName1'];
            $caddress = $_POST['caddress1'];
            $cpass= $_POST['cpass1'];
            if(!empty($client_SSN)  && !empty($cmail  ) && !empty($cFullName) && !empty($caddress )  && !empty($cpass)  ){//save to database
				try{
					$query = "insert into Client (client_SSN,  cmail, cFullName, caddress, cpass ) value ('$client_SSN', '$cmail','$cFullName','$caddress','$cpass' )";
					mysqli_query($con, $query);
				}catch (Exception $e ){ echo"<h1 style= \"color:red ; text-align: center;\">error, client_SSN or email already used!</h1>";
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
	<title> OurMansion | ModifyCustomer employee
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyCustomers</h1>
		<a href="logout_employee.php"> Logout</a>
		<h1>This is the Modify Customer page</h1>
		<br>
		Hello,<?php echo $employee_data['efullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_employee.php"> back to home</a> <br><br>

         <div id="box">
			<form method="post">
				<div style="font-size:20px;margin:10px;color:black;color:white;">Add a Customer</div>
				<br><br>
				<input id="text" type="text" name="client_SSN1" placeholder="client_SSN"><br><br>
                <input id="text" type="text" name="cmail1" placeholder="mail/username"><br><br>
                <input id="text" type="text" name="cFullName1" placeholder="FullName"><br><br>
                <input id="text" type="text" name="caddress1" placeholder="address"><br><br>


                <input id="text"  type="password" name="cpass1" placeholder="password"><br><br>
                

				<input id="button"  type="submit" name="add" value="add"><br><br>
				
				
			</form>
		</div>




         <h1 style= " text-align: center;"> Existing customers to modify:</h1> <br>
         <p style= " text-align: center;"> modify the values for a row and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

        <div class="container" style="width: 2500px;"	>
		<div class="row" style="width: 2500px;margin: 0.1%;">
		<div class="col-sm-8">
			<?php echo $deleteMsg??''; ?>
			<div class="table-responsive">
			<table class="table table-bordered" >
			<thead><tr><th>client_SSN</th>
				<th style="width: 20%;">email</th>
				<th style="width: 20%;">cFullName</th>
				<th style="width:25%;">caddress</th>
				<th style="width:50%;">cpassword</th>
				<th style="width:200%;">Date of sign up</th>
			</thead>
            <tbody>
		<?php
			if(is_array($fetchCustomer)){      
			
			foreach($fetchCustomer as $data){
			?>
			<tr>
                <form method="post">
                    <td><input name="client_SSN" value="<?php echo $data['client_SSN']??''; ?>" style="width:100%;" readonly></td>

                    
                    <td><input name="cmail" value="<?php echo $data['cmail']??''; ?>" style="width:50%;"></td>
                    <td><input name="cFullName" value="<?php echo $data['cFullName']??''; ?>" style="width:75%;" ></td>
                    <td><input name="caddress" value="<?php echo $data['caddress']??''; ?>" style="width:50%;"></td>
                    <td><input name="cpass" value="<?php echo $data['cpass']??''; ?>" style="width:50%;"></td>
					<td> <?php echo $data['registrationDate']?></td>

                    <td> <input type="submit" name="edit"  value="edit" /></td>
                </form>
                <form method="post">
                    <td><input style="width:0%" name="client_SSN2" value="<?php echo $data['client_SSN']??''; ?>" readonly /><input type="submit" name="delete" value="delete"   /></td>

                </form>

            </tr>
			<?php
			}}else{ ?>
			<tr>
				<td colspan="8">
			<?php echo $fetchCustomer; ?>
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