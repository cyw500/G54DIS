<?php
   include('home.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }
   // if (isset($_GET['ref_i'])) {
   //     $_SESSION['Action'] = "Edit";
   //     $_SESSION['Incident_ID'] = $_GET['ref_i'];
   //     echo '<script>window.location="add_fine.php"</script>';
   // }
?>

<div class="col-sm-offset-1">
<?php
   // shouldnt use select * , select whatever needed only
   $result = mysqli_query($db, "SELECT People_name, People_licence, Incident_Date,
       Incident_ID, Offence_description, Fine_Amount, Fine_Points
       FROM Fines NATURAL JOIN People NATURAL JOIN Incident NATURAL JOIN Offence
       ORDER BY Incident_Date DESC");

   echo "Fines: <br><br>";
   echo "<ul class=list-unstyled>" ;  // start list
   while($row = mysqli_fetch_assoc($result))
       {
       echo "<li>" . $row["People_name"]. " (" .$row["People_licence"]. ")<br>"
       . $row["Incident_Date"]." <a href='?ref_i={$row["Incident_ID"]}'> (incident #".$row["Incident_ID"].")</a>
        - ".$row["Offence_description"].
       "<br> Fine: £". $row["Fine_Amount"]. " (". $row["Fine_Points"]." points)<br><br><br>" ;
    }
    echo "</ul>";
?>
</div>
