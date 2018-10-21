<?php

session_start();
// For staff Login We Only need to set SEssion
// Cookie is no necessary anymore

// Condition to check session fafter each page refreshment

if(!isset($_SESSION['staff_username']) && !strpos($_SERVER['PHP_SELF'],'login.php') )
{
	header("location:login.php");
}

?>