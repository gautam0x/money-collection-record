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
<?php require 'header.php'; ?>



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
// Respone message genrate after data delete
$alert_msg = "";
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['response']))
{
  if($_GET['response'] == '1')
    $alert_msg = "<div class='sucess-msg-alert'>Client deleted sucessfully</div>";
  else if($_GET['response'] == '0')
    $alert_msg = "<div class='failure-msg-alert'>Sorry : Failed to delete client</div>";
  else
    $alert_msg = "";
}
?>

<!--**********************************
>>>>>>>>> Content Area <<<<<<<<<<<
***********************************-->
<div class="content-area-wrapper">
<div class="content-area">
<div class="content-holder-max-width">

    <div class="container-box-wrapper">
        <div class="container-box-body">
          <div id="alertBox"><?php echo $alert_msg; ?></div>
            <table class="index-table" width="100%">
				<tr>
					<th>Name</th>
					<th>Information</th>
					<th>Join Date</th>
					<th>Collected</th>
					<th>Action</th>
				</tr>

				<?php
				// Fetch MySQL row data from master table
				$sql = 'SELECT * FROM client_details ORDER BY name';
				$result = $conn->query($sql);

				if($result->num_rows > 0)
				{
					$tr_class_alter = "type_1"; // Alter tr Class to make dashed table

					while($row = $result->fetch_assoc())
					{
						// variable to Highlight Only loan account
						if($row['account_type'] == 'loan')
							$account_type = "<span style=color:red; > ( LOAN )</span>" ;
						else
							$account_type = "" ;
						?>

						<tr class="<?php echo $tr_class_alter ; ?>">
						<td><?php echo $row['name'].$account_type ;?></td>
						<td><?php echo $row['information'] ; ?></td>
						<td><?php echo rearr_date($row['join_date']) ; ?></td>
						<td><?php echo $row['total_balance'] ; ?></td>
						<td><a class="link-as-button" href=delete_client_confirm.php?id=<?php echo $row['id'];?>&name=<?php echo urlencode($row['name']);?> >Delete</a></td>
						</tr>

						<?php
                        //Condition to change row color by altering TableRow class name in each loop
                        if($tr_class_alter == "type_1")   $tr_class_alter = "type_2";
                        else                              $tr_class_alter = "type_1";
					}
					echo "<tr class='sucess-msg-row'>
							<td colspan ='5'>".$result->num_rows." Person </td>
						</tr>";
				}
				else
				{
					echo "<tr class='failure-msg-row'>
							<td colspan='5'>Sorry no data found</td>
						</tr>";
				}
				?>
			</table>
        </div>
    </div>
</div>
</div>
</div>



<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require 'footer.php' ; ?>

</div>
</div>
</body>
</html>
