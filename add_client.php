<?php 
    //include all config files
    require '/config_files/db_config.php';
    require '/config_files/defined_function.php';
    require '/config_files/session_tracking.php';
    require '/config_files/timezone_config.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Client</title>
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
    <li><a class="active" href="add_client.php">	Add Client</a></li>
    <li><a href="update_balance.php">				Update Balance </a></li>
    <li><a href="delete_client.php">				Delete Client</a></li>
</ul>
</div>
</div>


<?php
// Action after forum submitted
$alert_msg = "";
$date = "";
$flag = 1 ;
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['forum_condition'] ))
{ 
	///String Type Data 
	$name             = htmlspecialchars($_GET['name']);
	$information      = htmlspecialchars($_GET['information']);
	$account_type     = htmlspecialchars($_GET['account_type']);
	$year             = htmlspecialchars($_GET['year']);
	$month            = htmlspecialchars($_GET['month']);
	$day              = htmlspecialchars($_GET['day']);
	$loan_amount	  = htmlspecialchars($_GET['loan_amount']);
	$collected_amount = htmlspecialchars($_GET['collected_amount']);

	// Test string length > 0 of each $_GET variable
	foreach($_GET as $test)
	{
		if(strlen($test) <= 0)
		{
			$flag = 0 ;
			break;
		}
	}
	
	// Verify (date) variables and merge it to single value
	if(($year > 1988 && $year <2080)&&($month>=1 && $month<=12)&&($day>=1 && $day<=31) && $flag == 1 )
	{
		$date = $year."-".$month."-".$day;
	}
	else
	{
		$alert_msg = "<div class='failure-msg-alert'>Date data was wrong</div>";
		$flag = 0;
	}
	
	// Cheak the (amount) variable is numeric or not
	if( (!is_numeric($collected_amount) || !is_numeric($loan_amount) ) && $flag == 1)
	{
		$alert_msg = "<div class='failure-msg-alert'>Input Amount Was Wrong</div>";
		$flag = 0;
	}
	if($flag ==1)
	{	
		// Add New Row into Master table
		$sql= "INSERT INTO peoples (name ,information ,join_date ,last_update ,total_balance,account_type,loan_amount) VALUES('$name','$information','$date','$date',$collected_amount,'$account_type',$loan_amount)";
		if($conn->query($sql))
		{
			//If new person added than create indivisual table for that person
			$current_id = $conn->insert_id;
			$table_name = find_indivisual_table_name($name , $current_id);
			
			$sql = "CREATE TABLE $table_name (date DATE NOT NULL, amount FLOAT NOT NULL)";
			if($conn->query($sql))
			{
				// If indivisual table created than insert current amount into that
				$sql = "INSERT INTO $table_name (date ,amount) VALUES('$date','$collected_amount')";
				if($conn->query($sql))
				{
					$alert_msg = "<div class='sucess-msg-alert'>Person Added</div>";
				}
				else
				{
					$alert_msg = "<div class='failure-msg-alert'>Indivisual Data insertion failure</div>";
				}
			}
			else
			{
				$alert_msg = "<div class='failure-msg-alert'>Failed to create indivisual table</div>";
			}
		}
		else
		{
			$alert_msg = "<div class='failure-msg-alert'>Main Record Failed To Create</div>";
		}
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
            Add Person
        </div>
        
        <div class="container-box-body">
		
			<div id="alertBox"><?php echo $alert_msg; ?></div>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="forum-medium-input">
			<input type="hidden" name="forum_condition" value="1"/>
            <table class="forum-holder-table">
                <tr>
                    <td>
                        <label>Name :</label>
                    </td>
                    <td>
                        <input name="name" type="text" />
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <label>Information :</label>
                    </td>
                    <td>
                        <input name="information" type="text" />
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <label>Date ( D/M/Y ) :</label>
                    </td>
                    <td>
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
                            <option value="01">January [01]</option>
                            <option value="02">Februray [02]</option>
                            <option value="03">March [03]</option>
                            <option value="04">April [04]</option>
                            <option value="05">May [05]</option>
                            <option value="06">Jun [06]</option>
                            <option value="07">July [07]</option>
                            <option value="08">August [08]</option>
                            <option value="09">September [09]</option>
                            <option value="10">October [10]</option>
                            <option value="11">November [11]</option>
                            <option value="12">December [12]</option>
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
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <label>Account Type :</label>
                    </td>
                    <td>
                        <select name="account_type" onChange="box_action()" id="accountTypeDropdownSelector">
                            <option  value="collection">collection</option>
                            <option  value="loan">loan</option>
                        </select>
                    </td>                    
                </tr>
                <tr id="loanTableRowSelector">
                    <td>
                        <label>Loan Amount :</label>
                    </td>
                    <td>
                        <input id="loanInputBoxSelector" placeholder="Loan amount" name="loan_amount" type="number" />
                    </td>                
                </tr>
                <tr>
                    <td>
                        <label>Collected Amount :</label>
                    </td>
                    <td>
                        <input id="collectInputBoxSelector" name="collected_amount" type="number" />
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" value="Submit"/>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
    
    
</div> 
</div>
</div>
    
<script type="text/javascript">
//Get Table Row Which is to be display:none
var loanTableRowObj      = document.getElementById("loanTableRowSelector");

//Get amount box to set Values onChange action
var loanInputBoxObj    = document.getElementById("loanInputBoxSelector");
var collectInputBoxObj = document.getElementById("collectInputBoxSelector");
    
//If browser support javascript then hide the row using JS
loanTableRowObj.style.display = "none" ;
loanInputBoxObj.value = 0 ;


function box_action()
{
    var select = document.getElementById("accountTypeDropdownSelector");
    
    if(select.value == "loan")
    {
        loanTableRowObj.style.display = "";
        loanInputBoxObj.value = "" ;
        collectInputBoxObj.value = "0";
    }
    else
    {
        loanTableRowObj.style.display = "none";
        loanInputBoxObj.value = "0" ;
        collectInputBoxObj.value = "";
    }
}
</script>

<script type="text/javascript">
// Script To Get Date Data From PHP 
// and Assign that value to index of dropdown box

var day     = "<?php echo date('d') ?>";
var month   = "<?php echo date('m') ?>";
var year    = "<?php echo date('Y') ?>";

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