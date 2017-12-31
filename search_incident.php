<?php
include('add_fine.php');

if ($user_type == "") {
    header ("Location: home.php");
}

?>

<html>
<body>
<form action="" method="post">
<div class="row">
<div class="col-sm-offset-3 col-sm-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search with driver name or licence" name="incident_search">
        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
    </div>
</div>
<div class="col-sm-2">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <input type="submit" name="action" value="Search incident" class="btn btn-default" style='white-space: normal'/>
        </div>
    </div>
</div>
</div>
</form>

<div class="col-sm-offset-3">
<?php

    if (isset($_POST['action'])) {

    //selecting only fine thats not been given
    $result = mysqli_query($db, "SELECT Incident.Incident_ID as IIncident_ID,
       Incident_Date, Offence_description, People_name, People_address, People_licence
       FROM Incident NATURAL JOIN People NATURAL JOIN Offence
       Left JOIN Fines ON Fines.Incident_ID = Incident.Incident_ID
       WHERE Fine_ID is NULL AND CONCAT_WS('|', People_name, People_licence)
       LIKE '%".$_POST['incident_search']."%' ORDER BY Incident_Date DESC");

   echo "Select incident: <br><br>";
   echo "<ul class=list-unstyled>" ;
   while($row = mysqli_fetch_assoc($result))
       {
       $i_id = $row["IIncident_ID"];
       echo "<li> <a href = '?ref=$i_id'>" . $row["Incident_Date"]. "</a> - " .$row["Offence_description"]. "<br>"
       . $row["People_name"].", ".$row["People_address"]." (".$row["People_licence"].") <br><br>" ;
    }
    echo "</ul>";

    }
?>
</div>
</body>
</html>
