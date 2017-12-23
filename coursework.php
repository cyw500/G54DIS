<html>
<head><title>Addition php</title></head>
<body>

<form method="POST">
 username: <input type="text" name="username"><br>
 password: <input type="text" name="password"><br>
 <input type="submit" value = "Add Record">
 </form>
 <hr>


<?php
/*
 // MySQL database information
 $servername = "mysql.cs.nott.ac.uk";
 $username = "psxcyw";
 $password = "adv6125h";
 $dbname = "psxcyw";
 */
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "g54dis2";

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 if(mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL:".mysqli_connect_error();
 die();
 }

 else echo "MySQL connection OK<br>";


 if ($_POST['username']!="" && $_POST['password']!="")
 // if a form has been submitted, insert a new record
 {
 // construct the INSERT query
 $sql="INSERT INTO officer_access(username, password) VALUES ('".$_POST['username']."',".$_POST['password'].");";

 // send query to the database
 $result = mysqli_query($conn, $sql);

 echo "Invalid login"."<br>";
 }



  // construct the SELECT query
 $sql = "SELECT * FROM officer_access ORDER BY username;";

 // send query to database
 $result = mysqli_query($conn, $sql);

 // display the number of rows returned
 echo mysqli_num_rows($result)." rows<br>";

 while($row = mysqli_fetch_assoc($result))
 {
 echo $row["username"];
 echo " (password: ".$row["password"].")<br>";

 }


 mysqli_close($conn);
 ?>


</body>
</html>
