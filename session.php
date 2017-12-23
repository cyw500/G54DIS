<?php
   include('config.php');
   session_start();

   $manage_users = $user_type = "";

   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"SELECT username, Admin FROM officer_access WHERE username = '$user_check'");
   $row = mysqli_fetch_array($ses_sql);
   $login_session = $row['username'];

   $_SESSION['Admin'] = $row['Admin'];

   if (isset($_SESSION['Admin'])){
       // if $user_type is not Null / = Admin set variable to string for disply
      $manage_users = "Manage users";
      $user_type = "[Administrator]";
   }

   if(!isset($_SESSION['login_user'])){
      header("Location: logout.php");
   }

   if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // if last request was more than 60 minutes ago, sent to logout and destroy session
    header("Location: logout.php");
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>

<html>
<body>
    <div class="jumbotron text-center">
        <h1>Police Traffic Records</h1>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <p class="navbar-text"> Username :
                <?php echo "{$login_session} <font color=red>{$user_type}</font>" ?> </p>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="manage_user.php"><?php echo $manage_users?></a></li>
                <li><a href="change_password.php">Change password </a></li>
                <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>
