<?php
   include('session.php');

   // need to add error message too!!!
   // database change Incident_ID is Unique which meant each incident can only be fine once
   $_SESSION['Incident_ID'] = "";
   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }

   if (isset($_GET['ref'])) {
       $_SESSION['Incident_ID'] = $_GET['ref'];
       }

   if (isset($_POST['save'])) {
       if ((is_numeric($_POST['fine'])) && (is_numeric($_POST['points']))){
           if (!mysqli_query($db, "INSERT INTO Fines
               (Fine_ID, Fine_Amount, Fine_Points, Incident_ID)
               VALUES
               (NULL, '".$_POST['fine']."', '".$_POST['points']."', '".$_POST['incident']."');"))
               { $message = "Error description: " . mysqli_error($db);
            } else { echo '<script>window.location="view_fines.php"</script>';
              }
        } else { $message = "Please enter number only in the Fine and Points textbox"; }
   }

   $result = mysqli_query($db, "SELECT People_name, Incident_Date, Offence_description
   FROM Incident NATURAL JOIN People NATURAL JOIN Offence WHERE Incident_ID = '{$_SESSION['Incident_ID']}' ;");
   $row = mysqli_fetch_assoc($result);

   if ($_SESSION['Incident_ID'] != "") {
   $_SESSION['Incident'] = $row["People_name"]." (".$row["Incident_Date"].") - ".$row["Offence_description"];
   }

?>


<html>
<body>
<div class="container">
<div class="col-sm-offset-1">
<h1><?php echo $_SESSION['Action']?> Fine</h1>
</div>
<form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Incident: </label>
      <div class="col-sm-5">
        <div class="form-control-static">
            <input type="hidden" name= "incident" value="<?php echo $_SESSION['Incident_ID']?>">
            <?php echo $_SESSION['Incident']?></input>
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
     <br>
     <div class="col-sm-offset-2">
     <?php echo $message ?>
      </div>
    <div class="row">
    <div class="col-sm-9">
    <br><a href="home.php" class="btn btn-default pull-right" role="button">Back to main menu</a><br><br>
    </div>
    </div>
</form>
</div>

</body>
</html>
