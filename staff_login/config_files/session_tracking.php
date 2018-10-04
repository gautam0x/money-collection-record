<?php

session_start();
// For staff Login We Only need to set SEssion
// Cookie is no necessary anymore

// Condition to check session fafter each page refreshment

if(!isset($_SESSION['staff_username']) && $_SERVER['PHP_SELF'] != "/collection_money/staff_login/login.php")
{
	header("location:login.php");
}

?>