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
<meta charset="utf-8">
<title>Update Balance</title>
<link rel="stylesheet" type="text/css" href="css/page_layout.css" />
<link rel="stylesheet" type="text/css" href="css/forums_and_tables.css" />
<link rel="stylesheet" type="text/css" href="css/navbar_design.css" />
</head>
<body>
<div class="main-container-outer-wrapper">
<div class="main-container-inner-wrapper">


<?php
// Staff Can Only Update Balance Of current Date
//declare a date variable
$date_day		= date('d');
$date_month		= date('m');
$date_year		= date('Y');
$date_session = $date_year."-".$date_month."-".$date_day;
?>


<?php
// Action after balance update button pressed
$alert_msg  = "";
$flag = 1;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['date']) && isset($_POST['amount']))
{	
	$id              = htmlspecialchars($_POST['id']);
	$name            = htmlspecialchars(urldecode($_POST['name']));
	$date            = htmlspecialchars($_POST['date']);
	$amount          = htmlspecialchars($_POST['amount']);
	
	// Test string length > 0 of each $_GET variable
	foreach($_POST as $test)
	{
		if(strlen($test) <= 0)
		{
			$flag = 0 ;
			break;
		}
	}
	
	if($flag ==1)
	{
		// Genrate Indivisual Tablename by name and Id
		$table_name = find_indivisual_table_name($name , $id);
		// SQL Query to check does row exist on that date
		$result = $conn->query("SELECT amount FROM $table_name WHERE date = '$date' ");
		
		// Prepare Sql Statement : If row in indivisual table already exist than update that , else Create new row
		if( $result->num_rows > 0)
		{
			$sql = " UPDATE $table_name SET amount =  $amount WHERE date = '$date' ";
		}
		else  
		{
			$sql = " INSERT INTO $table_name (date , amount) VALUES('$date', $amount) ";
		}
		
		// Execute new Prepared SQL statement
		if($conn->query($sql))
		{
			// find total SUM of amount from indivisual table
			$result			= $conn->query("SELECT SUM(amount) FROM $table_name");
			$total_balance	= $result->fetch_array()[0];
			
			// insert total SUM of amount to the master record
			if($conn->query("UPDATE client_details SET total_balance = $total_balance , last_update = '$date' WHERE id = $id"))
			{
				$alert_msg = "<div class='sucess-msg-alert'>Your Amount Has Been Updated </div>";
			}
		}
		else
		{
			$alert_msg = "<div class='failure-msg-alert' >Your Amount Cannot Been Updated</div>";
		}
	}
}
?>



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
    <li><a href="#">						Home</a></li>
    <li><a href="#">						Add Client</a></li>
    <li><a class="active" href="#">			Update Balance </a></li>
    <li><a href="#">						Delete Client</a></li>
</ul>
</div>
</div>



<!--**********************************
>>>>>>>>> Content Area <<<<<<<<<<<
***********************************-->
<div class="content-area-wrapper" >
<div class="content-area" >
<div class="content-holder-max-width">

    <div class="container-box-wrapper">
        <div class="container-box-body">
			
			<div id="alertBox"><?php echo $alert_msg; ?></div>
			
			<table class="index-table" width="100%">
			<tr>
				<th>Date</th>
				<th>Information</th>
				<th>Name</th>
				<th>Cheak</th>
				<th>Amount</th>
				<th>Action</th>
			</tr>

			<?php
			// Fetch MySQL row data from Master table
			$sql = "SELECT id,name,information,last_update,account_type FROM client_details ORDER BY last_update desc";
			$result = $conn->query($sql);
			$total_collection = 0;
			
			if($result->num_rows > 0)
			{
				$tr_class_alter = "type_1"; // class name alternating for each row to change color
				
				while($row = $result->fetch_array())
				{
					// Fetch amount from each indivisual table in every loop
					$indivisual_table = find_indivisual_table_name($row['name'] , $row['id']) ;
					$sql_temp = "SELECT amount FROM $indivisual_table WHERE date = '$date_session' ";

					if($result_temp = $conn->query($sql_temp))
					{
						// if match found on that date
						if($result_temp->num_rows == 1) 
						{
							$row_temp	= $result_temp->fetch_assoc();
							$amount		= $row_temp['amount'];
							$total_collection += $amount;
							
							$image_icon = "image/tick-icon.png";
							if($amount == 0) $image_icon = "image/cross-icon.png"; // Special Case For Zero Balance
						}
						else
						{
							$amount = null;
							$image_icon = "image/cross-icon.png";
						}
					}
					
					// Loan Account Indicator
					if($row['account_type'] == 'loan') 
						$account_type = "<span style=color:red;> ( LOAN )</span>";
					else  
						$account_type = "" ;

					?>
					
					<form onsubmit="return confirm('Do you Want To Add')" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?>">
					<input type="hidden" name="id" value="<?php echo $row['id'] ; ?>" />
					<input type="hidden" name="name" value="<?php echo urlencode($row['name']) //Name's white space replace by underscore ; ?>" />
					<input type="hidden" name="date" value="<?php echo $date_session ; ?>" />
					
					<tr class="<?php echo $tr_class_alter ; ?>">
						<td><?php echo rearr_date($date_session) ; ?></td>
						<td><?php echo $row['information'] ; ?></td>
						<td><?php echo $row['name'].$account_type ; ?></td>
						<td><img src="<?php echo $image_icon ; ?>" /></td>
						<td><input type="number" value="<?php echo $amount; ?>" name="amount" placeholder="Amount"/></td>
						<td><input type="submit" value="Update" /></td>
					</tr>
					</form>
					
					<?php
					 // Condition to change row color by applying class name in each loop
					if($tr_class_alter == "type_1")	$tr_class_alter = "type_2";  
					else							$tr_class_alter = "type_1";	
				}
				// output total no. of rows in MYSQL Table
				echo "<tr class='sucess-msg-row'>
						<td colspan ='3'>".$result->num_rows." Person </td><td>Total amount</td>
						<td colspan ='3'>$total_collection</td>
					</tr>";
			}
			else
			{
				echo "<tr class='failure-msg-row'>
						<td colspan='6'>Sorry no data found</td>
					</tr>";
			}
			?>
			</table>

		</div>
	</div>

</div>
</div>
</div>



<script type="text/javascript">
// Script To Get Date Data From PHP 
// and Assign that value to index of dropdown box

var day		= "<?php echo $date_day ?>";
var month	= "<?php echo $date_month ?>";
var year	= "<?php echo $date_year ?>";

var dayOptionObj    =document.getElementById('dayOptionSelector');
var monthOptionObj  =document.getElementById('monthOptionSelector');
var yearOptionObj   =document.getElementById('yearOptionSelector');

//create a funtion which accept OptionObj & value as parameter
function changeOptionIndex(optionObj , valueToChange)
{    
    var optionArray = optionObj.options;
    // Loop to check dataTchange exist on which Index
    for(var i=0 ; i<optionArray.length ; i++)
    {
        if(optionArray[i].value == valueToChange)
        {
            optionObj.selectedIndex = i ;
            break;
        }
    }
}

changeOptionIndex(dayOptionObj , day);
changeOptionIndex(monthOptionObj , month);
changeOptionIndex(yearOptionObj , year);
</script>


<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require 'footer.php' ; ?>

</div>
</div>
</body>
</html>