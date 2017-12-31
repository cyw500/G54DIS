<?php
   include('home.php');
?>


<div class="col-sm-offset-1">
<?php
   if ($user_type == "") {
       $search = $login_user_id;
       echo "Incident reports submitted by $login_session : <br><br>";
   } else if ($user_type == "[Administrator]") {
       $search = "%" ;
       echo "Incidents: <br><br>";
   }

   $result = mysqli_query($db, "SELECT Incident_Date, username, People_name ,Vehicle_licence,
            Vehicle_colour, Vehicle_type, Offence_description, Incident_Report
            FROM Incident NATURAL JOIN People
            NATURAL JOIN Vehicle NATURAL JOIN Offence NATURAL JOIN Officer_access
            WHERE Officer_ID LIKE '$search' ORDER BY Incident_Date DESC;");

   echo "<ul class=list-unstyled>" ;  // start list
   while($row = mysqli_fetch_assoc($result))
       {
       echo "<li> " . $row["Incident_Date"];
       if ($user_type == "[Administrator]") {
           echo str_repeat('&nbsp;', 5)." Officer: <font color=blue>" . $row["username"]. "</font>";
       }
       echo "<br> Name: " .$row["People_name"].
       "<br> Vehicle: ". $row["Vehicle_licence"]." - ".$row["Vehicle_colour"]." ".$row["Vehicle_type"].
       "<br> Offence: ". $row["Offence_description"].
       "<br> Report: ". $row["Incident_Report"]." <br><br><br>" ;
    }
    echo "</ul>";
?>
</div>
