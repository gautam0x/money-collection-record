<?php
    //include all config files
    require 'config_files/db_config.php';
    require 'config_files/defined_function.php';
    require 'config_files/session_tracking.php';
    require 'config_files/timezone_config.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Edit Client</title>
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
<?php require 'header.php'; ?>


<!--**********************************
>>>>>>>>> Navigation Bar <<<<<<<<<<<
***********************************-->
<div class="navbar-wrapper">
<div class="navbar">
<ul>
    <li><a href="index.php">					Home</a></li>
    <li><a href="add_client.php">				Add Client</a></li>
    <li><a href="update_balance.php">			Update Balance </a></li>
    <li><a href="delete_client.php">			Delete Client</a></li>
</ul>
</div>
</div>

<?php
// GET id value from redirected page and dispaly its data in input box
$alert_msg = "";
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']))
{
    $id     = htmlspecialchars($_GET['id']);
    $sql    = "SELECT name,information FROM client_details WHERE id=$id";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc() ;
        $old_client_name     = $row['name']; // take backup to rename indivisual table
        $new_client_name     = $row['name'];
        $information         = $row['information'];
    }
}
?>

<?php
// Action after forum submit
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_condition']))
{
	$id                 = htmlspecialchars($_POST['id']);
	$information        = htmlspecialchars($_POST['information']);
	$new_client_name    = htmlspecialchars($_POST['new_name']);
	$old_client_name    = htmlspecialchars($_POST['old_name']);

	$old_table_name = find_indivisual_table_name($old_client_name , $id);
	$new_table_name	= find_indivisual_table_name($new_client_name , $id);

	// Update Master Table Record
	$sql = "UPDATE client_details SET name = '$new_client_name' , information = '$information' WHERE id = $id ";
	if($conn->query($sql))
	{
		// if new- name is same as older-name we dont need to change indivisual table name
		if($old_table_name == $new_table_name)
		{
			$alert_msg = "<div class='sucess-msg-alert'>Data Inserted Sucessfully</div>";
		}
		// else change indivisual table name
		else
		{
			$sql = "RENAME TABLE $old_table_name TO $new_table_name";
			if($conn->query($sql))
				$alert_msg = "<div class='sucess-msg-alert'>Data Inserted Sucessfully</div>";
			else
				$alert_msg = "<div class='failure-msg-alert'>Data Corrupted :( </div>";
		}
	}
	else
	{
		$alert_msg = "<div class='failure-msg-alert'>Data cannot be insertrd</div>";
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
            Edit Client Information
        </div>

        <div class="container-box-body">
		<center>
			<div id="alertBox"><?php echo $alert_msg; ?></div>

			<form onsubmit="return validateForm()"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="forum-medium-input" >
			<input name="form_condition" type="hidden" value="1" />
			<input name="id" type="hidden" value="<?php echo $id ?>" />
			<input name="old_name" type="hidden" value="<?php echo $new_client_name ?>" />
			<table class="forum-holder-table">
				<tr>
					<td><label>Name</label></td>
					<td><input id="nameInputBoxSelector" class="medium-width" name="new_name" type="text" value="<?php echo $new_client_name; ?>" /></td>
				</tr>
				<tr>
					<td><label>Information</label></td>
					<td><input class="medium-width" maxlength="35" name="information" type="text" value="<?php echo $information; ?>" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Submit" / > </td>
				</tr>
			</table>
			</form>
		</center>
        </div>
    </div>


</div>
</div>
</div>


<script type="text/javascript">
function validateForm()
{
  var nameInputBoxObj = document.getElementById("nameInputBoxSelector");

  // check input name string before submit the form
  // Name caontains only A-Z ,a-z ,0-9 and does not contains special characters
  var inputString     = nameInputBoxObj.value;
  var outputStringObj = inputString.match(/[a-zA-z0-9 ]+$/ig);
  var outputString    = String(outputStringObj);
  if(inputString.length != outputString.length)
  {
    document.getElementById("alertBox").innerHTML = 'Name does not Contains special character';
    document.getElementById("alertBox").className = 'warning-msg-alert';
    nameInputBoxObj.style.border = "1px solid red";
    return false;
  }
  else
  {
    return confirm('Are You Confirm To Submit');
  }
}
</script>


<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require 'footer.php' ; ?>

</div>
</div>
</body>
</html>
