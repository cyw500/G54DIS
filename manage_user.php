<?php
   include('session.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }
?>

<html>
<body>
    <script>
        // A JavaScript function to confirm delete
        function confirmDelete(ID)
        {
           var act = confirm("Are you sure?");
           if (act == true) // if OK pressed
           {
              delParam="?del="+ID; // add del parameter to URL
              this.document.location.href=delParam; // reload document
           }
        }
    </script>
    <div class="container">
    <div class="col-sm-offset-3">
    <h1> User management</h1>
    <?php
    if (isset($_GET['del']))
     {
       // construct the DELETE query
       $sql="DELETE FROM Officer_access WHERE Officer_ID = ".$_GET['del'].";" ;
       // send query to database
       $result = mysqli_query($db, $sql);

       echo '<script>window.location="manage_user.php"</script>';
     }

        // construct the SELECT query
        $sql = "SELECT * FROM Officer_access ORDER BY username;";
        // send query to database
        $result = mysqli_query($db, $sql);
        // if deleting yourself..... logout and warning????

        // check that something has been returned
       if (mysqli_num_rows($result) > 0)
       {
           echo "<table id='user' cellspacing='0'>
                   <tr>
                       <th>Username</th>
                       <th>User type</th>
                       <th></th>
                   </tr>";
           // loop through each row of the result (each tuple will
           // be contained in the associative array $row)
           while($row = mysqli_fetch_assoc($result))
           {
             // output name and usertype as list item
             echo "<tr>
                        <td>". $row["username"]. "</td>
                        <td>". $row["Admin"]."</td>";

             echo "<td><button type=button class='btn btn-warning btn-xs'
             onclick=confirmDelete(".$row["Officer_ID"].")>Delete</button></td></tr>";
           }
           echo "</table><br>"; // end of list
      }
    ?>

    <div class="col-xs-8 col-sm-6 col-lg-4">
        <a href="add_new_user.php" class="btn btn-default btn-block" style='white-space: normal'>Add new user</a>
    </div>
    <br><br>
        <div class="col-xs-8 col-sm-6 col-lg-4">
        <a href="home.php" class="btn btn-default pull-right">Back to main menu</a>
        </div>
    </div>
</div>
</body>
</html>
