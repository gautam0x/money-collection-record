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
<title>Search Result</title>
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
// Prepare data to search from GET parameter
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_data']) )
{
    $search_data = htmlspecialchars($_GET['search_data']);
}
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
            <a href="index_loan.php">Loan</a>
            <a href="index_date_wise.php">Date Wise</a>
        </div>
        
        <div class="container-box-body ">
            <table class="index-table" width="100%">
                <tr>
                    <th>Name</th>
                    <th>Information</th>
                    <th>Join Date</th>
                    <th>Last Update</th>
                    <th>Loan Amount</th>
                    <th>Collected</th>
                </tr>

                <?php
                // Get data from master Table Record
                $sql = "SELECT * FROM peoples WHERE name LIKE '%$search_data%' ORDER BY last_update desc";
                $result = $conn->query($sql);

                if($result->num_rows > 0)
                {
                    $total_collection = 0 ;
                    $tr_class_alter = "type_1";  // class name alternating for each row to change color
                    while($row = $result->fetch_array())
                    {
                        //loop for genrating table rows for each mysql fetch data 

                        // Loan Account Indicator
                        if($row['account_type'] == 'loan')
                        {
                            $account_type = "<span style=color:red;>( LOAN )</span>";
                            $loan_amount = $row['loan_amount'] ;
                        }
                        else 
                        {
                            $account_type = "" ;
                            $loan_amount = null ;
                        }

                        ?>

                        <tr class="<?php echo $tr_class_alter ; ?>">
                            <td><a target="_blank"  href="client_profile.php?id=<?php echo $row['id']; ?>"> <?php echo $row['name'].$account_type ;?></a></td>
                            <td><?php echo $row['information'] ; ?></td>
                            <td><?php echo rearr_date($row['join_date']) ; ?></td>
                            <td><?php if(date('Y-m-d') == $row['last_update']){ echo '<span style=color:green>Today</span>';} else{echo rearr_date($row['last_update']) ;} ?></td>
                            <td><?php echo $loan_amount ?></td>
                            <td><?php echo $row['total_balance'] ; ?></td>
                        </tr>

                        <?php
                        
                        //total amount Sum in the loop
                        $total_collection += $row['total_balance'];  
                        
                        //Condition to change row color by applying class name in each loop
                        if($tr_class_alter == "type_1")   $tr_class_alter = "type_2";  
                        else                              $tr_class_alter = "type_1";
                    }
                    // output total no. of rows in MYSQL Table
                    echo "<tr class='sucess-msg-row'>
                            <td colspan ='6'>".$result->num_rows." Person</td>
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

<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require 'footer.php' ; ?>

</div>
</div>
</body>
</html>