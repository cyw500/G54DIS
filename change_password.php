<?php
   include('session.php');

   if(isset($_POST["submit"]))
     {
      $old_password = mysqli_real_escape_string($db,$_POST['old_password']);
      $new_password = mysqli_real_escape_string($db,$_POST['new_password']);

      $sql = "SELECT username FROM Officer_access WHERE username = '{$_SESSION['login_user']}' AND password = '$old_password';";
      $result = mysqli_query($db,$sql);

      $count = mysqli_num_rows($result);

      if ($count == 1){
          if(($_POST['new_password'] != "") && $_POST['new_password'] == $_POST['r_new_password']) {

            if ($new_password === $old_password){
                $message = "<font color=red>Old password cannot be the same as new password</font>";
            } if ($new_password !== $old_password){
             // send update query to the database
             mysqli_query($db, "UPDATE Officer_access SET password = '$new_password'
                                WHERE username = '{$_SESSION['login_user']}';");
             // auto logout in 2 sec.
             echo "<script>
                    var timer = setTimeout(function() {
                    window.location='logout.php'  }, 2000);
                    </script>" ;

             $message = "Password successfully change, please log in again. <br/>
                        You're redirecting to the login.";
            }

         } else if ($_POST['new_password'] != $_POST['r_new_password']) {
              $message = "<font color=red>New password does not match</font>" ;

         } else if (isset($_POST['new_password'], $_POST['r_new_password'])) {
              $message = "<font color=red>Please enter new password, password cannot be empty</font>" ;
         }
     } else {
         $message = "<font color=red>Invalid entry</font>" ;
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
                        <input type="submit" name="submit" class="btn btn-default btn-block" value="OK">
                    </div>
                    <div class="col-sm-offset-1 col-sm-2">
                        <input type="reset" class="btn btn-default btn-block" value="Cancel">
                    </div>
                </div>
            </form>
        <div align="center">
        <?php echo $message ?>
    </div>
        </div>
    </body>

    </html>
