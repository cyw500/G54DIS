<?php
   include('home.php');
?>
<div class="col-sm-offset-1">
<?php
   if ($user_type == "") {
       $search = $_SESSION['Officer_ID'];
       echo "Incident reports submitted by {$_SESSION['login_user']} : <br><br>";
   } else if ($user_type == "[Administrator]") {
       $search = "'%' or Incident.Officer_ID is null" ;
       echo "Incidents: <br><br>";
   }

   // $sql =   "SELECT Incident_ID, Incident_Date, username, People_name ,Vehicle_licence,
   //          Vehicle_colour, Vehicle_type, Offence_description, Incident_Report
   //          FROM Incident NATURAL JOIN People
   //          NATURAL JOIN Vehicle NATURAL JOIN Offence NATURAL JOIN Officer_access
   //          WHERE Officer_ID LIKE $search ORDER BY Incident_Date DESC;";

   $sql = "SELECT * FROM Incident
           LEFT JOIN People ON People.People_ID = Incident.People_ID
           LEFT JOIN Vehicle ON Vehicle.Vehicle_ID = Incident.Vehicle_ID
           LEFT JOIN Offence ON Offence.Offence_ID = Incident.Offence_ID
           LEFT JOIN Officer_access ON Officer_access.Officer_ID = Incident.Officer_ID
           WHERE Incident.Officer_ID LIKE $search ORDER BY Incident_Date DESC;";

   $result = mysqli_query($db, $sql);

   if (isset($_GET['ref_r'])) {
       $_SESSION['Incident_ID'] = $_GET['ref_r'];

       $sql = "SELECT * FROM Incident
               LEFT JOIN People ON People.People_ID = Incident.People_ID
               LEFT JOIN Vehicle ON Vehicle.Vehicle_ID = Incident.Vehicle_ID
               LEFT JOIN Offence ON Offence.Offence_ID = Incident.Offence_ID
               LEFT JOIN Officer_access ON Officer_access.Officer_ID = Incident.Officer_ID
               WHERE Incident_ID = '{$_SESSION['Incident_ID']}' ORDER BY Incident_Date DESC;";

       $result = mysqli_query($db, $sql);
       $row = mysqli_fetch_assoc($result);

       $_SESSION['Action'] = "Edit";

       $_SESSION['People_ID'] = $row["People_ID"];
       $_SESSION['Vehicle_ID'] = $row["Vehicle_ID"];
       $_SESSION['Offence_ID'] = $row["Offence_ID"];

       $_SESSION['Driver'] = "{$row["People_name"]} ({$row["People_licence"]})" ;
       $_SESSION['Vehicle'] = "{$row["Vehicle_licence"]} ({$row["Vehicle_colour"]} {$row['Vehicle_type']})" ;
       $_SESSION['Offence'] = "{$row['Offence_description']}" ;
       $_SESSION['Incident_Report'] = $row['Incident_Report'] ;
       echo '<script>window.location="add_report.php"</script>';
       }

   echo "<ul class=list-unstyled>" ;  // start list
   while($row = mysqli_fetch_assoc($result))
       {
       echo "<li> <a href = '?ref_r=".$row['Incident_ID']."'>". $row["Incident_Date"]. "</a>";
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
