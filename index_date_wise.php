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
<title>Date Wise Collection</title>
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
    <li><a class="active" href="index.php">		Home</a></li>
    <li><a href="add_client.php">				Add Client</a></li>
    <li><a href="update_balance.php">			Update Balance </a></li>
    <li><a href="delete_client.php">			Delete Client</a></li>
</ul>
</div>
</div>
    
    
<?php
// set date variable after date forum submit
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']))
{
	// Set date value received by forum
	$date_day	= $_POST['day'];
	$date_month	= $_POST['month'];
	$date_year	= $_POST['year'];
}
else
{
	// Set default date
	$date_day	= date('d');
	$date_month	= date('m');
	$date_year	= date('Y');
}

$date = $date_year."-".$date_month."-".$date_day;
?>




<!--**********************************
>>>>>>>>> Content Area <<<<<<<<<<<
***********************************-->
<div class="content-area-wrapper" >
<div class="content-area" >
<div class="content-holder-max-width">    
    
    
    <div class="container-box-wrapper">
     
        
        <div class="container-box-link-bar">
            <a href="index.php">Collected</a>
            <a href="index_loan.php" >Loan</a>
            <a href="index_date_wise.php" class="active">Date Wise</a>
        </div>
        
        <div class="container-box-body ">  
            
            <div class="date-dropdown-option-holder">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <select name="day" id="dayOptionSelector">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
            </select>
            <select name="month" id="monthOptionSelector">
                <option value="01">January</option>
                <option value="02">Februray</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select name="year" id="yearOptionSelector">
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
            <input type="submit" value="Change Date"/>
            </form>
            
            <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="day" value="<?php echo date('d') ?>" />
            <input type="hidden" name="month" value="<?php echo date('m') ?>" />
            <input type="hidden" name="year" value="<?php echo date('Y') ?>" />
            <input type="submit" value="Reset date"/>
            </form>
            </div>

            <table class="index-table" width="100%">
            <tr>
                <th>Name</th>
                <th>Information</th>
                <th>Date</th>
                <th>Cheak</th>
                <th>Amount</th>
            </tr>

            <?php
            // Fetch MySQL row data from table
            $sql = 'SELECT id,name,information,last_update,account_type FROM client_details ORDER BY last_update desc';
            $result = $conn->query($sql);

            if($result->num_rows > 0)
            {
				$total_collection = 0;
                $tr_class_alter = "type_1"; // class name alternating for each row to change color
                while($row = $result->fetch_array())
                {
                    // Get Amount From Indivisual Table Of Each id
                    $indivisual_table = find_indivisual_table_name($row['name'] , $row['id']) ;
                    $sql_temp = "SELECT amount FROM $indivisual_table WHERE date = '$date' ";

                    if($result_temp = $conn->query($sql_temp))
                    {
                        if($result_temp->num_rows == 1)
                        {
                            $row_temp   = $result_temp->fetch_assoc();
                            $amount     = $row_temp['amount'];
							$total_collection += $row_temp['amount'];
                            $image_icon = "image/tick-icon.png";
                            if($amount == 0) $image_icon = "image/cross-icon.png"; // Special Case For Zero Balance
                        }
                        else
                        {
                            $amount = 0;
                            $image_icon = "image/cross-icon.png";
                        }
                    }
                    
                    // Loan Account Indicator
                    if($row['account_type'] == 'loan') 
                        $account_type = "<span style=color:red;> ( LOAN )</span>";
                    else  
                        $account_type = "" ;

                    ?>
                    
                    <tr class="<?php echo $tr_class_alter ; ?>">
                        <td><a target="_blank"  href="client_profile.php?id=<?php echo $row['id']; ?>"> <?php echo $row['name'].$account_type ;?></a></td>
                        <td><?php echo $row['information'] ; ?></td>
                        <td><?php echo rearr_date($date) ; ?></td>
                        <td><img src="<?php echo $image_icon ; ?>" /></td>
                        <td><?php echo $amount; ?></td>
                    </tr>

                    <?php
                    //Condition to change row color by altering TableRow class name in each loop
                    if($tr_class_alter == "type_1")   $tr_class_alter = "type_2";  
                    else                              $tr_class_alter = "type_1";
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

var day     = "<?php echo $date_day ?>";
var month   = "<?php echo $date_month ?>";
var year    = "<?php echo $date_year ?>";

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