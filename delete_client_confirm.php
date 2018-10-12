<?php 
    //include all config files
    require "config_files/db_config.php";
    require "config_files/defined_function.php";
    require "config_files/session_tracking.php";
    require "config_files/timezone_config.php";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Delete Client</title>
<link rel="stylesheet" type="text/css" href="css/page_layout.css" />
<link rel="stylesheet" type="text/css" href="css/forums_and_tables.css" />
<link rel="stylesheet" type="text/css" href="css/navbar_design.css" />
</head>
<body>
<div class="main-container-outer-wrapper">
<div class="main-container-inner-wrapper">



<!--***********************************
>>>>>>>> Header Section <<<<<<<<<<<
************************************-->
<?php require "header.php"; ?>



<!--**********************************
>>>>>>>>> Navigation Bar <<<<<<<<<<<
***********************************-->
<div class="navbar-wrapper">
<div class="navbar">
<ul>
    <li><a href="index.php">						Home</a></li>
    <li><a href="add_client.php">					Add Client</a></li>
    <li><a href="update_balance.php">				Update Balance </a></li>
    <li><a class="active" href="delete_client.php">	Delete Client</a></li>
</ul>
</div>
</div>


<?php
// Get data from previous page to initialize variable parameter to display
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])  && isset($_GET['name']))
{
	$name	= htmlspecialchars(urldecode($_GET['name']));
	$id		= htmlspecialchars($_GET['id']);
	if (!is_numeric($id))
	{
		header("location:delete_client.php?response=0");
	}
}
?>


<?php
// Execute delete action after confirm button pressed
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['confirm']) )
{
	$name = htmlspecialchars(urldecode($_POST['name']));
	$id   = htmlspecialchars($_POST['id']);
	
	if($_POST['confirm'] == 1) // confirmation test pass
	{
		$table_name  = find_indivisual_table_name($name , $id);
		
		$sql_1 = "DELETE FROM client_details WHERE id = $id "; //delete master record
		$sql_2 = "DROP TABLE $table_name ";             //delete indivisual table
	
		if($conn->query($sql_1) && $conn->query($sql_2)) 
		{
			header("location:delete_client.php?response=1") ;
		}
		else
		{
			header("location:delete_client.php?response=0");
		}
	}
	else // confirmation test fail
	{
		header("location:delete_client.php");
	}
}
?>

<!--**********************************
>>>>>>>>> Content Area <<<<<<<<<<<
***********************************-->
<div class="content-area-wrapper" >
<div class="content-area" >
<div class="content-holder-min-width">

    <div class="container-box-wrapper">
        <div class="container-box-header">
            Confirm Delete
        </div>
        
        <div class="container-box-body">
		<center>
			<table width="40%" class="index-table">
				<tr>
					<th style="text-align:center" colspan="100%">
						<?php echo $name; ?>
					</th>
				</tr>
				<tr>
					<td style="text-align:center">
						<!-- form for Confirm buton -->
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<input type="hidden" name="name" value="<?php echo $name; ?>" />
							<input type="hidden" name="id" value="<?php echo $id; ?>" />
							<input type="hidden" name="confirm" value="1" />
							<input type="submit" value="Yes" />
						</form>
					</td>
					<td style="text-align:center">
						<!-- form for Cancel buton -->
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<input type="hidden" name="confirm" value="0" />
							<input type="submit" value="No" />
						</form>
					</td>
				</tr>
			</table>
		</center>	
        </div>
    </div>
	
</div> 
</div>
</div>
    

<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require "footer.php" ; ?>

</div>
</div>
</body>
</html>