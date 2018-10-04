<?php
session_start();
if(isset($_SESSION['staff_username']))
{
	session_destroy();
	header("location:login.php");
}
?>