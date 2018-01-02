<?php
   include('config.php');
   session_start();

//   if($_SERVER["REQUEST_METHOD"] == "POST") {
     if(isset($_POST["submit"])){
      // Extract username and password sent from form 
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $sql = "SELECT * FROM Officer_access WHERE username = '$myusername' and password = '$mypassword';";
      $result = mysqli_query($db,$sql);

      // If result matched $myusername and $mypassword, table row must be 1 row
      if(mysqli_num_rows($result) == 1) {
        $_SESSION['login_user'] = $myusername;

        echo '<script>window.location="home.php"</script>';
      }
	  else {
          $message = "Your Login Name or Password is invalid";
      }
   }
?>

<html>

   <head>
      <title>Login Page</title>

      <style type = "text/css">

         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }

         .box {
            border:#666666 solid 1px;
         }
      </style>

   </head>
   <div class="jumbotron text-center">
        <h1>Police Traffic Records</h1>
   </div>
   <body bgcolor = "#FFFFFF">
      <div align = "center">
         <div style = "width:350px; border: solid 1px #333333; margin:10%;" align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:15px ;"><b>Login</b></div>

            <div style = "margin:30px">

               <form action = "" method = "post" autocomplete="off">
                     <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                     </div><br>
                      <div class="input-group">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                       <input type="password" name="password" class="form-control" placeholder="Password">
                   </div><br>
                      <input type = "submit" name="submit" value = " Login " class="btn btn-default btn-block"/>
               </form>

               <div style = "font-size:14px; color:#cc0000; margin-top:10px"><b><?php echo $message ?><b></div>

            </div>

         </div>

      </div>

   </body>
</html>
