<?php
    //include all config files
    require 'config_files/db_config.php' ;
    require 'config_files/session_tracking.php' ;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<link rel="stylesheet" type="text/css" href="css/page_layout.css" />
<link rel="stylesheet" type="text/css" href="css/login_forum_layout.css" />
</head>
<body>
<div class="main-container-outer-wrapper">
<div class="main-container-inner-wrapper">



<!--***********************************
>>>>>>>> Header Section <<<<<<<<<<<
************************************-->
<div class="header-wrapper">
    <div class="header">

    <div style="display: inline-block;">
        <img width="400px" src="image/banner-logo.gif" alt="Banner" / >
    </div>

    </div>
</div>


<?php
// Action after login forum submittion
$alert_msg= "";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['password']))
{
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $password = md5($password);

    $sql = "SELECT * FROM admin WHERE username = '$username' && password = '$password' ";
    $result = $conn->query($sql);

    if ($result->num_rows == 1)  //EVERYTHING IS OK INPUT MATCHED
    {
  		$time = time() + 36400;
  		setcookie('username',$username,$time);
  		setcookie('password',$password,$time);
  		header('location:index.php');
    }
    else
    {
      $alert_msg = "<div class='failure-msg-alert'>No Match Found</div>";
    }
}
?>


<!--**********************************
>>>>>>>>> Content Area <<<<<<<<<<<
***********************************-->
<div class="content-area-wrapper" >
<div class="content-area user-login-background" >
<div class="content-holder-min-width">

    <div class="container-box-wrapper">

        <div class="container-box-header">
            Admin Login
        </div>

        <div class="container-box-body">

            <div id="alertBox"><?php echo $alert_msg; ?></div>

            <div class="login-forum-holder">
                <form method="POST" class="login-forum" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label>Username</label>
                    <input name="username" type="text" />

                    <label>Password</label>
                    <input name="password" type="password" />

                    <input type="Submit" value="login"/>
                </form>
            
                <a class="link-button-style" href="staff_login">Staff login</a>
            </div>
        </div>

    </div>

</div>
</div>
</div>



<!--**********************************
>>>>>>>>>   Footer Area  <<<<<<<<<<<
************************************-->
<?php require 'footer.php'; ?>


</div>
</div>
</body>
</html>
