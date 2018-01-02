<?php
   include('session.php');

   if($_SERVER["REQUEST_METHOD"] == "POST")
     {
      $old_password = mysqli_real_escape_string($db,$_POST['old_password']);
      $new_password = mysqli_real_escape_string($db,$_POST['new_password']);

      $sql = "SELECT * FROM Officer_access WHERE username = '{$_SESSION['login_user']}' AND password = '$old_password';";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result);

      $count = mysqli_num_rows($result);

      if ($count == 1){
          if(($_POST['new_password'] != "" and $_POST['r_new_password'] != "") && $_POST['new_password'] == $_POST['r_new_password']) {
             // send update query to the database
             mysqli_query($db, "UPDATE Officer_access SET password = '$new_password'
                                WHERE username = '{$_SESSION['login_user']}';");
             // auto logout in 2 sec
             echo "<script>
                    var timer = setTimeout(function() {
                    window.location=logout.php'  }, 2000);
                    </script>" ;

             $message = "Password successfully change, please log in again. <br/>
                        You're redirecting to the login.";

         } else if ($_POST['new_password'] != $_POST['r_new_password']) {
              $message = "New password does not match." ;

         } else if (isset($_POST['new_password'], $_POST['r_new_password'])) {
              $message = "Please enter new password, password cannot be empty." ;
         }
     } else {
         $message = "Invalid entry" ;
        }
      }

?>

    <html>

    <head>
        <title> </title>
    </head>

    <body>
        <div class="container">
            <form action="" method="post" autocomplete="off">
                <div class="row">
                 <div class="form-group">
                  <label class="control-label col-sm-offset-2 col-sm-2"> Old password: </label>
                   <div class="col-sm-5">
                    <input type="text" class="form-control" name="old_password">
                   </div>
                 </div>
                </div>
                <br>
                <div class="row">
                 <div class="form-group">
                   <label class="control-label col-sm-offset-2 col-sm-2"> New password: </label>
                   <div class="col-sm-5">
                     <input type="password" class="form-control" name="new_password">
                   </div>
                  </div>
                 </div>
                 <br>
                 <div class="row">
                  <div class="form-group">
                    <label class="control-label col-sm-offset-2 col-sm-2"> Repeat new password: </label>
                    <div class="col-sm-5">
                      <input type="password" class="form-control" name="r_new_password">
                    </div>
                   </div>
                  </div>
                <br>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-2">
                        <input type="submit" class="btn btn-default btn-block" value="OK">
                    </div>
                    <div class="col-sm-offset-1 col-sm-2">
                        <input type="reset" class="btn btn-default btn-block" value="Cancel">
                    </div>
                </div>
            </form>
        <div align="center">
        <?php echo $message ?>
        </div>
        <div class="col-sm-9">
        <a href="home.php" class="btn btn-default pull-right">Back to main menu</a>
        </div>
        </div>
    </body>

    </html>
