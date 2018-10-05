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
            $sql 	= "SELECT * FROM peoples WHERE id = $id";
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
    <table width="300px" class="basic-dashed-table enable_border_bottom" style="text-align:center" >
    <tr>
        <th>
            Date
        </th>
        <th>
            Amount
        </th>
    </tr>
    <?php
        // fetch date and amount of indivisual table
        $table_name = find_indivisual_table_name($name,$id);
        $sql = "SELECT date,amount FROM $table_name";
        $result = $conn->query($sql);
    
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                ?>
                    <tr>
                        <td>
                            <?php echo $row['date']; ?>
                        </td>
                        <td>
                            <?php echo $row['amount']; ?>
                        </td>
                    </tr>
                <?php
            }
        }
    ?>
    </table>
</div>

<div style="clear:both"></div>

</div>
</div>
</body>
</html>