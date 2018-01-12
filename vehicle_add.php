<?php

   if (isset($_POST['save_v']))
   // saving the edit and connect to database for an update
   {
       if ($_POST['VL'] == "" && $_POST['colour'] == "" && $_POST['type'] == "" ) {
            $field_message = "Fields can not be all empty, must at least enter in one field";
        }
        else {
            // Edit or add new person
            if ($_SESSION["Vehicle_ID"] == ""){
                mysqli_query($db, "INSERT INTO Vehicle
                    (Vehicle_ID, Vehicle_type, Vehicle_colour, Vehicle_licence)
                    VALUES ('','{$_POST['type']}','{$_POST['colour']}', '{$_POST['VL']}');");
                $_SESSION["Vehicle_ID"] = mysqli_insert_id($db);
            } if ($_SESSION["Vehicle_ID"] != "") {
              // updating an edit
             mysqli_query($db, "UPDATE Vehicle SET
             Vehicle_licence = '{$_POST['VL']}',
             Vehicle_colour = '{$_POST['colour']}',
             Vehicle_type = '{$_POST['type']}'
             WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';");
             }
             if ($_SESSION['where'] == "report") {
                 $_SESSION['Vehicle'] = "{$_POST['VL']} ({$_POST['colour']} {$_POST['type']})";
                 $_SESSION['Action'] = "Continue";
                 echo '<script>window.location="add_report.php"</script>';
             }
             // going back where it come from
             if ($_SESSION["where"] == "assign vehicle"){
                 if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
                         (".$_SESSION["People_ID"].",".$_SESSION['Vehicle_ID'].");")) {
                        $message = "<font color=red>Error description: " . mysqli_error($db)."</font>" ;
                    } else {
                        $_SESSION['Action'] = "Edit Person";
                        $_SESSION["where"] = "edit person";
                        echo '<script>window.location="person_edit.php"</script>';
                    }
             } if (($_SESSION["where"] == "edit vehicle") or ($_SESSION["where"] == "add new vehicle")) {
             echo '<script>window.location="vehicle_detail.php"</script>';
             }
            }
   }

   // this is getting the People_ID form assign_owner.php (person_search.php)
   if (isset($_GET['ref_p'])) {
        $_SESSION["People_ID"] = $_GET['ref_p'];
        if ($_SESSION["Vehicle_ID"] == "") {
            $message = "<font color=red>Please save the vehicle detail first</font>" ;
        } if ($_SESSION["Vehicle_ID"] != "") {
        $_SESSION["where"] = "edit vehicle";
       if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES
       (".$_SESSION["People_ID"].",".$_SESSION['Vehicle_ID'].");")) {
//       $message = "<font color=red>Error description: " . mysqli_error($db)."</font>" ;
        $message = "<font color=red>Error: Vehicle is alreay attach to an owner</font>";
       } else {
        echo '<script>window.location="vehicle_edit.php"</script>';
            }
        }
   }

   // to remove the peron ownership to this vehicle
   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       //header("Location: vehicle_edit.php"); // have or not have mmm not sure needed
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM Vehicle WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';"));
   $sub_sql = "SELECT People_name, People_ID FROM People NATURAL join Ownership RIGHT JOIN Vehicle
               ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID WHERE Vehicle.Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';";
   $sub_result = mysqli_query($db, $sub_sql);
   $sub_row = mysqli_fetch_assoc($sub_result);

?>

<html>
<body>
<div class="container">
<h1><?php echo $_SESSION['Action'] ?></h1>
  <form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Licence: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="VL" value="<?php echo $row["Vehicle_licence"] ?>" placeholder=<?php echo "'$field_message'"?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Colour: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="colour" value="<?php echo $row["Vehicle_colour"]?>" placeholder=<?php echo "'$field_message'"?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Type: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="type" value="<?php echo $row["Vehicle_type"]?>" placeholder=<?php echo "'$field_message'"?>>
      </div>
    </div>
    <!-- show the owner -->
    <?php
    if ($_SESSION["where"] == "edit vehicle"){
    echo "<div class='form-group'>
      <label class='control-label col-sm-2'>Owner: </label>
      <label class='control-label col-sm-offset'>";

       if (isset($sub_row["People_ID"])){
          echo str_repeat('&nbsp;', 5) .$sub_row['People_name']. "
          <a href = '?del={$_SESSION["Vehicle_ID"]}'> [Remove ownership]</a>"; }
        echo "</label><br>
        <div class='text-right'> <label><a href = 'assign_person.php'> Assign owner to vehicle </a></label></div>
    </div>";}
    ?>

    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="save_v" class="btn btn-default btn-block">Save</button>
      </div>
    <div class="col-sm-offset-2 col-sm-4">
      <button type="reset" class="btn btn-default btn-block">Reset</button>
    </div>
    </div>
    <div class="col-sm-offset-2">
    <br><?php echo $message ?>
    </div>
    </form>
</div>

</body>
</html>
