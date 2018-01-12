<?php

   if (isset($_POST['save_p'])) {

   if ($_POST['name'] == "") {
        $field_message = "Name can not be empty";
    } else { // if name field is not empty then it can either update or sumbit a new entry
      // saving new entry
       if ($_SESSION["People_ID"] == ""){
           if (isset($_POST['name'])) {
            mysqli_query($db, "INSERT INTO People VALUES
                ('', '{$_POST['name']}', '{$_POST['address']}', '{$_POST['DL']}');");
                $_SESSION["People_ID"] = mysqli_insert_id($db);
            }
       } if ($_SESSION["People_ID"] != "") {
        // updating an edit
        mysqli_query($db, "UPDATE People SET People_name = '{$_POST['name']}',
         People_address = '{$_POST['address']}', People_licence = '{$_POST['DL']}'
         WHERE People_ID = '{$_SESSION['People_ID']}';");
       }
       if ($_SESSION['where'] == "report") {
           $_SESSION['Driver'] = "{$_POST['name']} ({$_POST['DL']})";
           $_SESSION['Action'] = "Continue";
           echo '<script>window.location="add_report.php"</script>';
       }
        // going back where it come from
        if ($_SESSION["where"] == "assign owner"){
            if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID)
            VALUES (".$_SESSION['People_ID']."," .$_SESSION["Vehicle_ID"].");")) {
            $message = "<font color=red>The vehicle is already attach to an owner</font>";
//            $message = "Error description: " . mysqli_error($db) ;
            } else {
            $_SESSION['Action'] = "Edit Vehicle";
            $_SESSION["where"] = "edit vehicle";
            echo '<script>window.location="vehicle_edit.php"</script>';
            }
        } if (($_SESSION["where"] == "edit person") or ($_SESSION["where"] == "add new person")) {
            echo '<script>window.location="person_detail.php"</script>';
        }
    }
    }
   // this is getting the Vehicle_ID form assign_vehicle.php (sub_page)
   if (isset($_GET['ref_v'])) {
       $_SESSION["Vehicle_ID"] = $_GET['ref_v'];
       if ($_SESSION["People_ID"] == "") {
           $message = "<font color=red>Please save the person detail first</font>" ;
       } if ($_SESSION["People_ID"] != "") {
       $_SESSION["Vehicle_ID"] = $_GET['ref_v'];
       $_SESSION["where"] = "edit person";
       if (!mysqli_query($db, "INSERT INTO Ownership (People_ID, Vehicle_ID)
       VALUES (".$_SESSION['People_ID']."," .$_SESSION["Vehicle_ID"].");"))
       {
//        $message = "<font color=red>Error description: " . mysqli_error($db)."</font>";
       $message = "<font color=red>Error: Vehicle is alreay attach to another owner</font>";
       } else {
       echo '<script>window.location="person_edit.php"</script>';
        }
       }
   }

   // this getting the $v_id to deleted the link between a person and a vehicle
   if (isset($_GET['del'])){
       mysqli_query($db, "DELETE FROM Ownership WHERE Vehicle_ID = ".$_GET['del'].";");
       //echo '<script>window.location="person_edit.php"</script>';
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM People WHERE People_ID = '{$_SESSION['People_ID']}';"));
   $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
               WHERE People.People_ID = '{$_SESSION['People_ID']}';";
   $sub_result = mysqli_query($db, $sub_sql);
?>

<html>
<body>
<div class="container">
  <h1><?php echo $_SESSION['Action'] ?></h1>
  <form class="form-horizontal" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Name: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" value="<?php echo $row["People_name"] ?>" placeholder=<?php echo "'$field_message'"?>>
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
    <?php
    if ($_SESSION["where"] == "edit person"){
     echo "<div class='form-group'>
      <label class='control-label col-sm-2'>Vehicle: </label>
      <label class='control-label col-sm-offset'>";

      while($sub_row = mysqli_fetch_assoc($sub_result)){
          echo str_repeat('&nbsp;', 5) .$sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
          " (". $sub_row["Vehicle_licence"]. ") <a href = '?del={$sub_row["Vehicle_ID"]}'> [Remove ownership] </a> <br>" ;
      }
      echo "</label><br><div class='text-right'> <label><a href = 'assign_vehicle.php'> Assign vehicle ownership to
            {$row["People_name"]}</a></label></div>
    </div>";}
    ?>
    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="save_p" class="btn btn-default btn-block">Save</button>
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
