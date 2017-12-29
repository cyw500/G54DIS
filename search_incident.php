<?php
include('add_fine.php');

if (isset($_GET['ref'])) {
    $incident = "".$_GET['ref']."";
    }
?>

<html>
<body>
<form action="" method="post">
<div class="row">
<div class="col-sm-offset-2 col-sm-5">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="car_search">
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
</body>
</html>

<?php

   $result = mysqli_query($db, "SELECT * FROM Incident NATURAL JOIN People
       NATURAL JOIN Offence ORDER BY Incident_Date DESC");

   echo "Select incident: <br><br>";
   echo "<ul class=list-unstyled>" ;  // start list
   while($row = mysqli_fetch_assoc($result))
       {
           $i_id = $row["Incident_ID"];
       echo "<li> <a href = '?ref=$i_id'>" . $row["Incident_Date"]. "</a> - " .$row["Offence_description"]. "<br>"
       . $row["People_name"].", ".$row["People_address"]." (".$row["People_licence"].") <br><br>" ;
    }
    echo "</ul>";

?>
