<?php
   include('session.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }
?>
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

<html>
<body>
    <h1> User management</h1>
    <?php
    if (isset($_GET['del']))
     {
       // construct the DELETE query
       $sql="DELETE FROM Officer_access WHERE Officer_ID = ".$_GET['del'].";" ;
       // send query to database
       $result = mysqli_query($db, $sql);
     }

        // construct the SELECT query
        $sql = "SELECT * FROM Officer_access ORDER BY username;";
        // send query to database
        $result = mysqli_query($db, $sql);
        // if deleting yourself..... logout and warning????

        // check that something has been returned
       if (mysqli_num_rows($result) > 0)
       {
           echo "<ul>";  // start list
           // loop through each row of the result (each tuple will
           // be contained in the associative array $row)
           while($row = mysqli_fetch_assoc($result))
           {
             // output name and usertype as list item
             echo "<li>". $row["username"]. " ". $row["Admin"];
             $id = $row["Officer_ID"];
             // echo " ID:".$id;
             echo "<a href = '?del=$id'> Delete </a>";
             echo "<button type=button class='btn btn-warning btn-xs' onclick=confirmDelete(".$row["Officer_ID"].")>Delete</button>";
           }
           echo "</ul>"; // end of list
      }
    ?>
    <form action="add_new_user.php" method="post">
        <input type="submit" value=" Add new user ">
        <a href="home.php" class="btn btn-default pull-right" role="button">Back</a>
    </form><br>
</body>
</html>
