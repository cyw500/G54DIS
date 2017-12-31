<?php
   include('session.php');
   // need to add error message too!!! (ie fine is already completed)
   // database change Incident_ID is Unique which meant each incident can only be fine once
   $I_id = "";
   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }

   if (isset($_GET['ref'])) {
       $I_id = $_GET['ref'];
       }

   if (isset($_POST['save'])) {
       $I = $_POST['incident'];
       $fine = $_POST['fine'];
       $points = $_POST['points'];

       mysqli_query($db, "INSERT INTO Fines VALUES ('', '$fine', '$points', '$I');");

       header ("Location: add_fine.php");
   }


   $result = mysqli_query($db, "SELECT People_name, Incident_Date, Offence_description
       FROM Incident NATURAL JOIN People NATURAL JOIN Offence WHERE Incident_ID = '$I_id' ;");
   $row = mysqli_fetch_assoc($result);

   if ($I_id != "") {
   $message = $row["People_name"]." (".$row["Incident_Date"].") - ".$row["Offence_description"];
   } else { $message = ""; }


?>


<html>
<body>
<div class="container">
<div class="col-sm-offset-1">
<h1>Add Fine</h1>
</div>
<form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Incident: </label>
      <div class="col-sm-5">
        <div class="form-control-static">
            <input type="hidden" name= "incident" value="<?php echo $I_id?>">
            <?php echo $message?></input>
        </div>
      </div>
      <div class="col-sm-2">
        <a href="search_incident.php" class="btn btn-default btn-block"
            style='white-space: normal'>Select incident</a>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2"> Fine: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="fine">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2"> Points: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="points">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
      <!-- cheating using redirect instead of reset -->
      <div class="col-sm-offset-3 col-sm-2">
        <a href="add_fine.php" class="btn btn-default btn-block">Cancel</a>
      </div>
     </div>
    <div class="row">
    <div class="col-sm-9">
    <br><a href="home.php" class="btn btn-default pull-right" role="button">Back</a><br><br>
    </div>
    </div>
</form>
</div>

</body>
</html>
