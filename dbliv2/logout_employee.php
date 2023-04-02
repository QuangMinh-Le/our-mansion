<?php

session_start();

if (isset($_SESSION['employee_SSN'])){
	unset($_SESSION['employee_SSN']);
}

header("Location: index.php");
die;