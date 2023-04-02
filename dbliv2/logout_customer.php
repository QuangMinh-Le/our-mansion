<?php 

session_start();

if (isset($_SESSION['client_SSN'])){
	unset($_SESSION['client_SSN']);
}

header("Location: index.php");
die;