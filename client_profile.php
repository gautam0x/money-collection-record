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
<title>Client Detail</title>
<link rel="stylesheet" type="text/css" href="css/black-and-white-page.css" />
</head>

<body>

<div class="page-outer-wrapper">
<div class="page-inner-wrapper">

<div class="link-bar">
    <a href="edit_client_info.php?id=<?php echo $_GET['id'] ?>">Edit Information</a>
    <a href="javascript:window.print();">Print</a>
    <a href="javascript:window.close();">Close Window</a>
</div>

<!--For Left Container-->
<div class="left-container">
<?php
    // Fetch Master record data of GET id
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']))
    {
        $flag = 1;
        $total_amount_sum = 0;
        $id = htmlspecialchars($_GET['id']);  // GET data

        if(!is_numeric($id))
            $flag = 0;


        if($flag == 1)
        {
            $sql 	= "SELECT * FROM client_details WHERE id = $id";
            $result = $conn->query($sql);
            $row	= $result->fetch_assoc();

            $name             = $row['name'];
            $information      = $row['information'];
            $join_date        = $row['join_date'];
            $last_update      = $row['last_update'];
            $total_balance    = $row['total_balance'];
            $account_type	  = $row['account_type'];
            $loan_amount	  = $row['loan_amount'];

            ?>

            <table class="basic-dashed-table" width="550px">
            <tr>
                <th colspan="3">
                    Client Information
                </th>
            </tr>
            <tr>
                <td rowspan="8" style="text-align: center">
                    <img src="image/client_profile_logo.gif" width="80" alt="Profile Pic"/>
                </td>
            </tr>

            <tr>
                <td>
                    Name
                </td>
                <td>
                    <?php echo $name; ?>
                </td>
            </tr>

            <tr class="alt">
                <td>
                    Information
                </td>
                <td>
                    <?php echo $information; ?>
                </td>
            </tr>

            <tr>
                <td>
                    A/C Type
                </td>
                <td>
                    <?php echo $account_type; ?>
                </td>
            </tr>

            <tr class="alt">
                <td>
                    Join Date
                </td>
                <td>
                    <?php echo $join_date; ?>
                </td>
            </tr>

            <tr>
                <td>
                    Collected Amount
                </td>
                <td>
                    <?php echo $total_balance ?>
                </td>
            </tr>

            <?php
                // Set rows display only for loan account
                if($account_type == "loan")
                {
                    ?>
                    <tr class="alt">
                        <td>
                            Loan Amount
                        </td>
                        <td>
                            <?php echo $loan_amount; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Dues Amount
                        </td>
                        <td>
                            <?php echo $loan_amount-$total_balance ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </table>
            <?php
        }
    }
?>
</div>

<!--For right container-->
<div class="right-container">
<?php
 //genrate indivisual table name
 $indivisual_table_name = find_indivisual_table_name($name,$id);
 //fetch join date and last update from client table
 $sql = "SELECT MIN(date),MAX(date) FROM $indivisual_table_name ";
 $result = $conn->query($sql);
 $row = $result->fetch_array();

 $initial_date  = $row[0];
 $final_date    = $row[1];

 $year_month_arr = find_intermediate_year_month_array($initial_date,$final_date);
 $i = 0;

 while($i < count($year_month_arr))
 {
   // fetch date and amount of indivisual table
   $indivisual_table_name = find_indivisual_table_name($name,$id);
   $sql = " SELECT date,amount FROM $indivisual_table_name WHERE date LIKE '$year_month_arr[$i]%' ORDER BY date";
   $result = $conn->query($sql);
   if($result->num_rows > 0)
   {
     ?>
     <table width="300px" class="basic-dashed-table enable_border_bottom" style="text-align:center" >
       <tr>
         <th colspan="2"><?php echo date("F", mktime(0, 0, 0, explode('-',$year_month_arr[$i])[1], 10)).' '.explode('-',$year_month_arr[$i])[0] ; ?></th>
       </tr>
       <?php
       while($row = $result->fetch_assoc())
       {
         ?>
             <tr>
               <td><?php echo explode('-',$row['date'])[2]; ?></td>
               <td><?php echo $row['amount']; ?></td>
             </tr>
           <?php
         }
         ?>
      </table>
      <?php
     }
   $i++;
 }
 ?>
<div style="clear:both"></div>

</div>
</div>
</body>
</html>
