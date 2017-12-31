<?php
   include('session.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }

   $message = "";
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
                  mysqli_query($db,"INSERT INTO Officer_access (username, password)
                        VALUES ('".$_POST['username']."','".$_POST['password']."');");
                } else {
                    mysqli_query($db, "INSERT INTO Officer_access (Admin, username, password)
                          VALUES ('Admin','".$_POST['username']."','".$_POST['password']."');");
                  }
                header("Location: manage_user.php");
              }
            } else {
                $message = "Please enter valid username and password"; }
          }
        }

        ?>
        <div class="container">
            <form action="" method="post">
                <h1> User management</h1> <br>
                <div class="row">
                 <div class="form-group">
                  <label class="control-label col-sm-2"> Userame: </label>
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
            </form><br>
            <?php echo $message ?>
        <div class="col-sm-7">
        <a href="home.php" class="btn btn-default pull-right">Back</a>
        </div>
        </div>
    </body>

    </html>
