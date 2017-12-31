<?php
   include('home.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }
?>

<div class="col-sm-offset-1">
<?php
   // shouldnt use select * , select whatever needed only
   $result = mysqli_query($db, "SELECT * FROM Fines NATURAL JOIN People
       NATURAL JOIN Incident NATURAL JOIN Offence ORDER BY Incident_Date DESC");

   echo "Fines: <br><br>";
   echo "<ul class=list-unstyled>" ;  // start list
   while($row = mysqli_fetch_assoc($result))
       {
       echo "<li>" . $row["People_name"]. " (" .$row["People_licence"]. ")<br>"
       . $row["Incident_Date"]." (incident #".$row["Incident_ID"].") - ".$row["Offence_description"].
       "<br> Fine: £". $row["Fine_Amount"]. " (". $row["Fine_Points"]." points)<br><br><br>" ;
    }
    echo "</ul>";
?>
</div>
