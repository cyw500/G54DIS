<?php
   include('session.php');

   $message = "";

   if($_SERVER["REQUEST_METHOD"] == "POST")
     {
      $old_password = mysqli_real_escape_string($db,$_POST['old_password']);
      $new_password = mysqli_real_escape_string($db,$_POST['new_password']);

      $sql = "SELECT * FROM officer_access WHERE username = '$login_session' AND password = '$old_password';";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result);

      $count = mysqli_num_rows($result);

      if ($count == 1){
          if(($_POST['new_password'] != "" and $_POST['r_new_password'] != "") && $_POST['new_password'] == $_POST['r_new_password']) {
             // send update query to the database
             mysqli_query($db, "UPDATE `officer_access` SET `password` = '$new_password'
                                WHERE `officer_access`.`username` = '$login_session';");
             // auto logout in 10 sec
             header("refresh:10; url = logout.php");
             $message = "Password successfully change, You'll be logout in about 10 secs.";

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

        <form action="" method="post">
            <div align="center">
                <label>Old password : </label><input type="password" name="old_password" class="box"><br><br>
                <label>New Password : </label><input type="password" name="new_password" class="box"><br><br>
                <label>Repeat new Password : </label><input type="password" name="r_new_password" class="box"><br><br>
                <input type="submit" value=" OK "/> &nbsp;&nbsp;&nbsp;&nbsp; <input type="reset" value=" Cancel "><br><br>
                <?php echo $message ?>
            </div>
            <!-- <div id="button"><a href= "welcome.php" style="float: right">Back</a></div>
           <a href="welcome.php" class="btn btn-default">back</a>
       https://stackoverflow.com/questions/2906582/how-to-create-an-html-button-that-acts-like-a-link -->
        </form>
        <form action="home.php">
            <input type="submit" value = "Back" style = "float: right" />
            <!--https://www.w3schools.com/tags/att_button_formaction.asp
            http://www.hyperlinkcode.com/button-links.php-->
        </form>
    </body>

    </html>
