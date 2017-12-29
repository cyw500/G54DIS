<?php
   include('session.php');
   $V_id = $_SESSION["Vehicle_ID"];

   if (isset($_POST['save']))
   // saving the edit and connect to database for an update
   {
     $VL = $_POST['VL'];
     $colour = $_POST['colour'];
     $type = $_POST['type'];

     mysqli_query($db, "UPDATE Vehicle SET Vehicle_licence = '$VL', Vehicle_colour = '$colour',
     Vehicle_type = '$type' WHERE Vehicle_ID = '$V_id';");

     if ($VL == "" && $colour == "" && $type == "" ) {
          $message = "Fields can not be all empty, must at least enter in one field"; }
   }

   // this is getting the $v_id form assign_vehicle.php (sub_page)
   if (isset($_GET['ref'])) {
       // if error ** need to do more work
       if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
       (".$_GET['ref'].",".$_SESSION['Vehicle_ID'].");"))
       {
       echo("Error description: " . mysqli_error($db));
       } else {
       // if sucessfully insert into databse
       mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
       (".$_GET['ref'].",".$_SESSION['Vehicle_ID'].");");
       header ("Location: vehicle_edit.php");
       } }

   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       header("Location: vehicle_edit.php");
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM Vehicle WHERE Vehicle_ID = '$V_id';"));
   $sub_sql = "SELECT People_name, People_ID FROM People NATURAL join Ownership RIGHT JOIN Vehicle
               ON vehicle.Vehicle_ID = ownership.Vehicle_ID WHERE vehicle.Vehicle_ID = '$V_id';";
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
              echo str_repeat('&nbsp;', 5) .$sub_row['People_name']. " <a href = '?del=$V_id'>
              [Remove ownership]</a>"; }
           ?></label><br>
      <div class="text-right"> <label><a href = 'assign_owner.php'> Assign owner to vehicle </a></label></div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-5">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
    </div>
    <a href="vehicle_detail.php" class="btn btn-default pull-right" role="button">Back</a><br><br>
    </form>
    </form>
</div>

</body>
</html>
