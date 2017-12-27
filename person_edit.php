<?php
   include('home.php');
   $P_id = $_SESSION["People_ID"];

   if (isset($_POST['save']))
   // saving the edit and connect to database for an update
   {
     $name = $_POST['Name'];
     $address = $_POST['Address'];
     $DL = $_POST['DL'];

     mysqli_query($db, "UPDATE people SET People_name = '$name', People_address = '$address',
     People_licence = '$DL' WHERE people.People_ID = '$P_id';");
   }

   $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM people WHERE People_ID = '$P_id';"));
   $sub_sql = "SELECT * FROM people NATURAL JOIN ownership NATURAL JOIN vehicle
               WHERE people.People_ID = '$P_id';";
   $sub_result = mysqli_query($db, $sub_sql);


?>

<html>
<body>
<div class="container">
  <form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Name: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="Name" value="<?php echo $row["People_name"] ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Address: </label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="Address" value="<?php echo $row["People_address"]?>">
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

      <div class="text-right"> <label><a href = ''> Assign vehicle ownership to
          <?php echo $row["People_name"]?> </a></label></div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-5">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
    </div>
  </form>
      <div class="text-right">
      <input type="submit" value = "Back" onclick = 'window.history.go(-1)'>
      </div>
</div>

</body>
</html>
