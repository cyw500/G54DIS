<?php
   include('config.php');
   session_start();

   // Checking type of user and other information
   $sql = "SELECT username, Admin, Officer_ID FROM Officer_access
            WHERE username = '{$_SESSION['login_user']}';";
   $ses_sql = mysqli_query($db,$sql);
   $row = mysqli_fetch_array($ses_sql);
   $_SESSION['login_user'] = $row['username'];
   $_SESSION['Officer_ID'] = $row['Officer_ID'];

   if (isset($row['Admin'])){
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

    echo $_SESSION["where"];

    if (isset($_POST["ok"])){
        echo "are we in?";
    if ($_SESSION["where"] == "assign vehicles"){
        echo '<script>window.location="person_edit.php"</script>';}}
?>

<html>
<body>
    <div class="jumbotron text-center">
         <h1>Police Traffic Records</h1>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <p class="navbar-text"> Username :
                <?php echo "{$_SESSION['login_user']} <font color=red>{$user_type}</font>" ?> </p>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="manage_user.php"><?php echo $manage_users?></a></li>
                <li><a href="change_password.php">Change password </a></li>
                <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
    <p><?php echo "<font color=red>{$_SESSION['error']}</font>" ?> </p>
    <form>
    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="ok" class="btn btn-default btn-block">OK</button>
      </div>
  </div>
</form>

</body>
</html>
