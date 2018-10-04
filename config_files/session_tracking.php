<?php

// Every page require to have assigned value to session "username" to work 
// if session "username" isn't assigned then it redirect to login page

session_start();

/***********************************************************************
Condition 1 : If older cookie found from last login

session "username" = False
cookie 	"username" = True

Then lets verify password from datatbase using older cookie data
if it's ok then set session "username"
***********************************************************************/

if(!isset($_SESSION['username']) && isset($_COOKIE['username']))
{
	$sql	= "SELECT password FROM admin WHERE username = '".$_COOKIE['username']."' ";
	$result	= $conn->query($sql);
	$row	= $result->fetch_assoc(); 
	
	if($_COOKIE['password'] == $row['password'])
	{	
		$_SESSION['username'] = $_COOKIE['username'];
	}
	else
	{
		die("Clear The Cookie And Re Login");
	}
}

/***********************************************************************
Condition 2 : If older cookie doesn't found and it's first time login

cookie 	"username" = False

Redirect the url to login page 
***********************************************************************/
elseif(!isset($_COOKIE['username']) && $_SERVER['PHP_SELF'] != "/collection_money/login.php" )
{
	header('location:login.php');
}

?>