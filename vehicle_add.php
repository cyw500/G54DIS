<?php
//   echo $_SESSION["Vehicle_ID"]." ".$_SESSION["People_ID"]."<br>";

   if (isset($_POST['save_v']))
   // saving the edit and connect to database for an update
   {
   if ($_POST['VL'] == "" && $_POST['colour'] == "" && $_POST['type'] == "" ) {
        $message = "Fields can not be all empty, must at least enter in one field";
    } else {
        if ($_SESSION["Vehicle_ID"] == ""){
            mysqli_query($db, "INSERT INTO Vehicle VALUES ('','{$_POST['type']}',
                '{$_POST['colour']}', NULLIF('{$_POST['VL']}',''));");
            $_SESSION["Vehicle_ID"] = mysqli_insert_id($db);
         } else {
          // updating an edit
         mysqli_query($db, "UPDATE Vehicle SET Vehicle_licence = NULLIF('{$_POST['VL']}',''),
         Vehicle_colour = '{$_POST['colour']}', Vehicle_type = '{$_POST['type']}'
         WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';");
         }
         echo '<script>window.location="vehicle_detail.php"</script>';

     }
   }

   // this is getting the $p_id form assign_owner.php (person_search.php)
   if (isset($_GET['ref_p']) || isset($_POST['save_p'])) {

       if (isset($_GET['ref_p'])) {
           $_SESSION["People_ID"] = $_GET['ref_p'];

       } else if (isset($_POST['save_p'])) {
           if (!mysqli_query($db, "INSERT INTO People VALUES
               ('', '{$_POST['name']}', '{$_POST['address']}',
                   '{$_POST['DL']}');"))
            {
               echo("Error description: " . mysqli_error($db));
           } else {
               $_SESSION["People_ID"] = mysqli_insert_id($db); }
         }
       // if error ** need to do more work
           if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
           (".$_SESSION["People_ID"].",".$_SESSION['Vehicle_ID'].");")) {
           echo "Error description: " . mysqli_error($db) ;
           } else {
            echo '<script>window.location="vehicle_edit.php"</script>';
       } // it gives Undefined index: error if attempts to search again
    }

   // to remove the peron ownership to this vehicle
   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       //header("Location: vehicle_edit.php"); // have or not have mmm not sure needed
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM Vehicle WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';"));
   $sub_sql = "SELECT People_name, People_ID FROM People NATURAL join Ownership RIGHT JOIN Vehicle
               ON vehicle.Vehicle_ID = ownership.Vehicle_ID WHERE vehicle.Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';";
   $sub_result = mysqli_query($db, $sub_sql);
   $sub_row = mysqli_fetch_assoc($sub_result);

?>

<html>
<body>
<div class="container">
  <form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Licence: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="VL" value="<?php echo $row["Vehicle_licence"] ?>" placeholder=<?php echo "'$message'"?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Colour: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="colour" value="<?php echo $row["Vehicle_colour"]?>" placeholder=<?php echo "'$message'"?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Type: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="type" value="<?php echo $row["Vehicle_type"]?>" placeholder=<?php echo "'$message'"?>>
      </div>
    </div>
    <!-- show the owner -->
    <div class="form-group">
      <label class="control-label col-sm-2">Owner: </label>
      <label class="control-label col-sm-offset">
          <?php
          if (isset($sub_row["People_ID"])){
              echo str_repeat('&nbsp;', 5) .$sub_row['People_name']. "
              <a href = '?del={$_SESSION["Vehicle_ID"]}'> [Remove ownership]</a>"; }
           ?></label><br>
      <div class="text-right"> <label><a href = 'assign_person.php'> Assign owner to vehicle </a></label></div>
    </div>
    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="save_v" class="btn btn-default btn-block">Save</button>
      </div>
    <div class="col-sm-offset-2 col-sm-4">
      <button type="reset" class="btn btn-default btn-block">Cancel</button>
    </div>
    </div>
    <br><a href="home.php" class="btn btn-default pull-right">Back</a>
    </form>
</div><br>

</body>
</html>
