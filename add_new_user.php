<?php
   include('session.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }

?>
    <html>
    <body>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
          {
          if (isset($_POST['add'])) {
            if ($_POST['username'] != "" && $_POST['password'] != "") {
              if ($_POST['password'] != $_POST['r_password']) {
                     $message = "Password does not match" ;
              } else {
                if (!isset($_POST['admin'])) {
                  // if checkbox not check
                    $_POST['admin'] = 0 ;
                }
                 if (!mysqli_query($db,"INSERT INTO Officer_access (Admin, username, password)
                    VALUES (NULLIF(".$_POST['admin'].", 0 ) ,'".$_POST['username']."','".$_POST['password']."');")) {
                        $message = "<b> Username : '{$_POST['username']}' already exsist <b> ";
                    } else {
                        echo '<script>window.location="manage_user.php"</script>';
                    }
              }
            } else {
                $message = "Please enter valid username and password"; }
          }
        }

        ?>
        <div class="container">
            <form action="" method="post" autocomplete="off">
                <h1> User management</h1> <br>
                <div class="row">
                 <div class="form-group">
                  <label class="control-label col-sm-2"> Username: </label>
                   <div class="col-sm-5">
                    <input type="text" class="form-control" name="username">
                   </div>
                 </div>
                </div>
                <br>
                <div class="row">
                 <div class="form-group">
                   <label class="control-label col-sm-2"> Password: </label>
                   <div class="col-sm-5">
                     <input type="password" class="form-control" name="password">
                   </div>
                  </div>
                 </div>
                 <br>
                 <div class="row">
                  <div class="form-group">
                    <label class="control-label col-sm-2"> Repeat Password: </label>
                    <div class="col-sm-5">
                      <input type="password" class="form-control" name="r_password">
                    </div>
                   </div>
                  </div>
                  <br>
                  <div class="row">
                   <div class="form-group">
                     <label class="control-label col-sm-2"> Admin: </label>
                     <div class="col-sm-1">
                       <input type="checkbox" name="admin" value="true">
                     </div>
                    </div>
                   </div>
                <br>
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-2">
                        <input type="submit" name="add" class="btn btn-default btn-block" value="Add new user" style='white-space: normal'>
                    </div>
                    <div class="col-sm-offset-1 col-sm-2">
                        <button type="reset" class="btn btn-default btn-block" value="Cancel"> Cancel </button>
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-2">
            <?php echo $message ?>
            </div>
            <br>
        <div class="col-sm-7">
        <a href="home.php" class="btn btn-default pull-right">Back to main menu</a>
        </div>
        </div>
    </body>

    </html>
