<?php
session_start();
if(isset($_SESSION['username']))
{
	$time = time() - 36400;
	setcookie("username","",$time);
	setcookie("password","",$time);
	session_destroy();
	header("location:login.php");
}
?>