<?php
   $_SESSION['where'] = "report";

   if (isset($_POST['action'])) {
      switch ($_POST['action']) {
           case "Add Driver":
               $_SESSION['Incident_Report'] = $_POST['I_description'];
               $_SESSION['type'] = "driver";
               echo '<script>window.location="assign_person.php"</script>';
               break;

           case "Add Vehicle":
               $_SESSION['Incident_Report'] = $_POST['I_description'];
               $_SESSION['type'] = "vehicle";
               echo '<script>window.location="assign_vehicle.php"</script>';
               break;

           case "Add Offence":
               $_SESSION['Incident_Report'] = $_POST['I_description'];
               $_SESSION['type'] = "offence";
               echo '<script>window.location="offence_search.php"</script>';
               break;

           case "Cancel":
               $_SESSION['People_ID'] = $_SESSION['Vehicle_ID'] =
               $_SESSION['Offence_ID'] = "" ;

               $_SESSION['Driver'] = $_SESSION['Vehicle'] = $_SESSION['Offence'] =
               $_SESSION['Incident_Report'] = "";
               break;

           case "Save":
               if ($_SESSION['Incident_ID'] == "") {
                   if (!mysqli_query($db, "INSERT INTO Incident
                       (Incident_ID, Vehicle_ID, People_ID, Incident_Date,
                                   Incident_Report, Offence_ID, Officer_ID)
                       VALUES (NULL, '".$_SESSION['Vehicle_ID']."', '".$_SESSION['People_ID']."', CURRENT_TIMESTAMP,
                                   '".$_POST['I_description']."','".$_SESSION['Offence_ID']."', $login_user_id );")) {
                                       echo("Error description: " . mysqli_error($db));
                    } else { // if sussfully sumbit query
                         echo '<script>window.location="view_report.php"</script>';
                      }

                } if ($_SESSION['Incident_ID'] != "") {
                    if (!mysqli_query($db, "UPDATE Incident SET Vehicle_ID = '{$_SESSION['Vehicle_ID']}',
                    People_ID = '{$_SESSION['People_ID']}', Incident_Report = '{$_POST['I_description']}',
                    Offence_ID = '7' WHERE Incident.Incident_ID = '{$_SESSION['Incident_ID']}';")){
                    echo("Error description: " . mysqli_error($db));
                    } else {
                        echo '<script>window.location="view_report.php"</script>';
                      }
                  }
           }
       }

    // these are the attaching the driver/vehicle/offence
    if (isset($_GET['ref_o'])) {
        $_SESSION['Offence_ID'] = $_GET['ref_o'];

        $sql = "SELECT Offence_description From Offence WHERE Offence_ID = '{$_SESSION["Offence_ID"]}';";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['Offence'] = "{$row['Offence_description']}" ;

        echo '<script>window.location="add_report.php"</script>';

    } if (isset($_GET['ref_p']) || isset($_POST['save_p'])) {

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

          $sql = "SELECT * From People WHERE People_ID = '{$_SESSION["People_ID"]}' ;";
          $result = mysqli_query($db, $sql);
          $row = mysqli_fetch_assoc($result);
          $_SESSION['Driver'] = "{$row["People_name"]} ({$row["People_licence"]})" ;

        echo '<script>window.location="add_report.php"</script>';

    } if (isset($_GET['ref_v']) || isset($_POST['save_v'])) {

        if (isset($_GET['ref_v'])) {
        $_SESSION['Vehicle_ID'] = $_GET['ref_v'];

        } else if (isset($_POST['save_v'])) {
            if (!mysqli_query($db, "INSERT INTO Vehicle VALUES ('','{$_POST['type']}',
                '{$_POST['colour']}', NULLIF('{$_POST['VL']}',''));"))
            {
                echo("Error description: " . mysqli_error($db));
            } else {
                $_SESSION["Vehicle_ID"] = mysqli_insert_id($db); }

        }
        $sql = "SELECT * From Vehicle WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}' ;";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['Vehicle'] = "{$row["Vehicle_licence"]} ({$row["Vehicle_colour"]} {$row['Vehicle_type']})" ;

        echo '<script>window.location="add_report.php"</script>';
    }

?>
<html>
<body>
<div class="container">
 <h1>Add New Report</h1>
  <form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Driver: </label>
      <div class="col-sm-7">
          <div class="form-control-static">
           <input type="hidden" name= "driver" value="<?php echo $_SESSION['People_ID']?>">
              <?php echo $_SESSION['Driver']?></input>
          </div>
        </div>
      <div class="col-sm-3">
        <input type="submit" name="action" class="btn btn-default btn-block" value="Add Driver"/>
      </div>
<!--      <div class="col-sm-3">
            <a href="processor.php" class="btn btn-default btn-block" role="button">Link Button</a>
      </div>
      <div class="col-sm-2">
          <button type="button" class="btn btn-primary btn-block">Button 1</button>
      </div> -->
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Vehicle: </label>
       <div class="col-sm-7">
          <div class="form-control-static">
              <input type="hidden" name= "vehicle" value="<?php echo $_SESSION['Vehicle_ID']?>">
              <?php echo $_SESSION['Vehicle']?></input>
          </div>
       </div>
        <div class="col-sm-3">
          <input type="submit" name="action" class="btn btn-default btn-block" value="Add Vehicle"/>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Offence: </label>
          <div class="col-sm-7">
              <input type="hidden" name= "offence" value="<?php echo $_SESSION['Offence_ID']?>">
              <?php echo $_SESSION['Offence']?></input>
          </div>
          <div class="col-sm-3">
              <input type="submit" name="action" class="btn btn-default btn-block" value="Add Offence"/>
          </div>
    </div>


<!--    <div class="form-group">
      <label class="control-label col-sm-2">Datetime: </label>
      <div class="col-sm-7">
        <div class="input-group date" id="datetime" >
           <input type="text" name="datetime" class="form-control" readonly/>
           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Datetime: </label>
        <div class='col-sm-7'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
    </div> -->

    <div class="form-group">
        <label class="control-label col-sm-2">Incident description: </label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" name="I_description"
                placeholder="Enter incident detail"><?php echo $_SESSION['Incident_Report']?></textarea>
        </div>
    </div>

      <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" name="action" class="btn btn-default btn-block" value="Save" />
      </div>
      <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" name="action" class="btn btn-default btn-block" value="Cancel" />
      </div>


  <br><br><br><a href="home.php" class="btn btn-default pull-right" role="button">Back</a>
  </form><br><br>
</div>
</body>
</html>
