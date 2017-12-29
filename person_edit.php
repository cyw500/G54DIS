<?php
   include('session.php');
   $P_id = $_SESSION["People_ID"];

   // prevent use type in direct site
    if (!isset($_SESSION["People_ID"])) {
      header("Location: home.php");
    }

   if (isset($_POST['save']))
   // saving the edit(a new entry) and connect to database for an update
   {
     $name = $_POST['name'];
     $address = $_POST['address'];
     $DL = $_POST['DL'];

     mysqli_query($db, "UPDATE People SET People_name = '$name', People_address = '$address',
     People_licence = '$DL' WHERE People_ID = '$P_id';");

    if ($name == "") {
         $message = "Name can not be empty";
    }

   }
   // this is getting the $v_id form assign_vehicle.php (sub_page)
   if (isset($_GET['ref'])) {
       // if error ** need to do more work
       if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
       (".$_SESSION['People_ID']."," .$_GET['ref'].");"))
       {
       echo("Error description: " . mysqli_error($db));
       } else {
       // if sucessfully insert into databse
       mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
       (".$_SESSION['People_ID']."," .$_GET['ref'].");");
       header ("Location: person_edit.php");
       } }

   // this getting the $v_id to deleted the link between a person and a vehicle
   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       header("Location: person_edit.php");
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM People WHERE People_ID = '$P_id';"));
   $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
               WHERE people.People_ID = '$P_id';";
   $sub_result = mysqli_query($db, $sub_sql);

?>

<html>
<body>
<div class="container">
  <form class="form-horizontal" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Name: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" value="<?php echo $row["People_name"] ?>" placeholder=<?php echo "'$message'"?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Address: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="address" value="<?php echo $row["People_address"]?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Driving Licence: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="DL" value="<?php echo $row["People_licence"]?>">
      </div>
    </div>
    <!-- list the vehicle belong to the owner -->
    <div class="form-group">
      <label class="control-label col-sm-2">Vehicle: </label>
      <label class="control-label col-sm-offset">
      <?php
      while($sub_row = mysqli_fetch_assoc($sub_result)){
          $v_id = $sub_row["Vehicle_ID"];
          echo str_repeat('&nbsp;', 5) .$sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
          " (". $sub_row["Vehicle_licence"]. ") <a href = '?del=$v_id'> [Remove ownership] </a> <br>" ;
      } ?></label><br>

      <div class="text-right"> <label><a href = 'assign_vehicle.php'> Assign vehicle ownership to
          <?php echo $row["People_name"]?></a></label></div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-5">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
    </div>
    <a href="person_detail.php" class="btn btn-default pull-right" role="button">Back</a><br><br>
    </form>
</div>

</body>
</html>
