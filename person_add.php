<?php
    // echo $_SESSION["Vehicle_ID"]." ".$_SESSION["People_ID"]."<br>";
    //echo $_SESSION['type'] ." <br>". $_SESSION['keyword'];

   if (isset($_POST['save_p'])) {

   if ($_POST['name'] == "") {
        $message = "Name can not be empty";
    } else { // if name field is not empty then it can either update or sumbit a new entry
      // saving new entry
       if ($_SESSION["People_ID"] == ""){
        mysqli_query($db, "INSERT INTO People VALUES
            ('', '{$_POST['name']}', '{$_POST['address']}', '{$_POST['DL']}');");
            $_SESSION["People_ID"] = mysqli_insert_id($db);
       } else {
        // updating an edit
        mysqli_query($db, "UPDATE People SET People_name = '{$_POST['name']}',
         People_address = '{$_POST['address']}', People_licence = '{$_POST['DL']}'
         WHERE People_ID = '{$_SESSION['People_ID']}';");
       }
    echo '<script>window.location="person_detail.php"</script>';
    }
   }
   // this is getting the $v_id form assign_vehicle.php (sub_page)
   if (isset($_GET['ref_v']) || isset($_POST['save_v'])) {

       if (isset($_GET['ref_v'])) {
           $_SESSION["Vehicle_ID"] = $_GET['ref_v'];

       } else if (isset($_POST['save_v'])) {
           if (!mysqli_query($db, "INSERT INTO Vehicle VALUES ('','{$_POST['type']}',
               '{$_POST['colour']}', NULLIF('{$_POST['VL']}',''));"))
           {
               echo("Error description: " . mysqli_error($db));
           } else {
               $_SESSION["Vehicle_ID"] = mysqli_insert_id($db); }

        // this will make the error message not able to show
        // echo '<script>window.location="person_edit.php"</script>';
       }

       if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID)
       VALUES (".$_SESSION['People_ID']."," .$_SESSION["Vehicle_ID"].");"))
       {
       // echo("Error description: " . mysqli_error($db));
       echo "Vehicle is alreay attach to another owner";
       } else {
       echo '<script>window.location="person_edit.php"</script>';
       } }

   // this getting the $v_id to deleted the link between a person and a vehicle
   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       //header("Location: person_edit.php");
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM People WHERE People_ID = '{$_SESSION['People_ID']}';"));
   $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
               WHERE people.People_ID = '{$_SESSION['People_ID']}';";
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
          echo str_repeat('&nbsp;', 5) .$sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
          " (". $sub_row["Vehicle_licence"]. ") <a href = '?del={$sub_row["Vehicle_ID"]}'> [Remove ownership] </a> <br>" ;
      } ?></label><br>

      <div class="text-right"> <label><a href = 'assign_vehicle.php'> Assign vehicle ownership to
          <?php echo $row["People_name"]?></a></label></div>
    </div>
    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="save_p" class="btn btn-default btn-block">Save</button>
      </div>
      <div class="col-sm-offset-2 col-sm-4">
        <button type="reset" class="btn btn-default btn-block">Cancel</button>
      </div>
    </div>
    </form>
    <a href="home.php" class="btn btn-default pull-right" role="button">Back</a><br><br>
</div><br>
</body>
</html>
