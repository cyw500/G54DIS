<?php
    include('add_fine.php');
        $_SESSION['type'] = "incident";

    if ($user_type == "") {
        header ("Location: home.php");
    }
    include('search.php');

    if (isset($_POST['action'])) {

    //selecting incident only fine thats not been given
    $sql = "SELECT Incident.Incident_ID as IIncident_ID, Incident_Date,
       Offence_description, People_name, People_address, People_licence
       FROM Incident NATURAL JOIN People NATURAL JOIN Offence
       LEFT JOIN Fines ON Fines.Incident_ID = Incident.Incident_ID
       WHERE Fine_ID is NULL AND CONCAT_WS('|', People_name, People_licence)
       LIKE '%".$_POST['incident_search']."%' ORDER BY Incident_Date DESC;";

    $result = mysqli_query($db, $sql);

   echo "<div class='col-sm-offset-2'>";

   echo "Select incident: <br><br>";
   echo "<ul class=list-unstyled>" ;
   while($row = mysqli_fetch_assoc($result))
       {
       echo "<li> <a href = '?ref={$row["IIncident_ID"]}'>" . $row["Incident_Date"]. "</a> -
       " .$row["Offence_description"]. "<br>". $row["People_name"].", ".$row["People_address"]."
        (".$row["People_licence"].") <br><br>" ;
    }
    echo "</ul>";
    echo "</div>";
    }
?>
</div>
</body>
</html>
