<?php
   include('session.php');
?>
<html>
<body>
    <h1> User management</h1>
    <?php
    if (isset($_GET['del']))
     {
       // construct the DELETE query
       $sql="DELETE FROM officer_access WHERE Officer_id = ".$_GET['del'].";" ;
       // send query to database
       $result = mysqli_query($db, $sql);
     }

        // construct the SELECT query
        $sql = "SELECT * FROM officer_access ORDER BY username;";
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
             $id = $row["Officer_id"];
             // echo " ID:".$id;
             echo "<a href = '?del=$id'> Delete </a>";
           }
           echo "</ul>"; // end of list
      }
    ?>
    <form action="add_new_user.php" method="post">
        <input type="submit" value=" Add new user "> &nbsp;
        <input type="reset" value="Cancel">
    </form><br>
</body>
</html>
