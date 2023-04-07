<?php
session_start();
	include("connection.php");
	include("function.php");
	$client_data = check_login_customer($con);
	$_SESSION;

    $fetchCustomer = fetch_customer($con, $client_data['client_SSN'] );

    function fetch_customer($db, $client_SSN ){
        if(empty($db)){
         $msg= "Database connection error";
       }else{
       $query = "SELECT * FROM  client WHERE client_SSN = '$client_SSN' LIMIT 1";
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
			
            $query ="UPDATE client SET cmail='$cmail', cFullName='$cFullName', caddress='$caddress',  cpass='$cpass' WHERE client_SSN = '$client_SSN'";
            $result = $con->query($query);

        }



    }


?>


<!DOCTYPE html>
<html>
<head>
	<title> OurMansion | ModifyInfos Customer
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
        <h1 style= "font-family: fantasy ; text-align: center;">OurMansion - ModifyInfo</h1>
		<a href="logout_customer.php"> Logout</a>
		<h1>This is the Modify Info page</h1>
		<br>
		Hello,<?php echo $client_data['cFullName']; ?>
		 <br>
		 logined as employee
		 <br>
         <a href="home_customer.php"> back to home</a> <br><br>

         <h1 style= " text-align: center;"> Your data you can modify:</h1> <br>
         <p style= " text-align: center;"> modify the values and then press edit button (you might need to reload twice the page after, for the change to take effect)</p>

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

                    <td> <input type="submit" name="edit"  value="edit" /></td>
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