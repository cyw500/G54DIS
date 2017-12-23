<?php
   include('session.php');

   $message = "";
?>
    <html>

    <body>
        <h1> User management</h1>
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
                  mysqli_query($db,"INSERT INTO officer_access (username, password)
                        VALUES ('".$_POST['username']."','".$_POST['password']."');");
                } else {
                    mysqli_query($db, "INSERT INTO officer_access (Admin, username, password)
                          VALUES ('Admin','".$_POST['username']."','".$_POST['password']."');");
                  }
                header("Location: manage_user.php");
              }
            } else {
                $message = "Please enter valid username and password"; }
          }
        }

        ?>
            <form action="" method="post">
                <label>Username : </label><input type="text" name="username"><br><br>
                <label>Password : </label><input type="password" name="password"><br><br>
                <label>Repeat Password : </label><input type="password" name="r_password"><br><br>
                <label>Admin  : </label><input type="checkbox" name="admin" value="true"> <br>
                <input type="submit" name="add" value="Add new user"> &nbsp;
                <input type="reset" value="Cancel">
            </form><br>
            <?php echo $message ?>
    </body>

    </html>
