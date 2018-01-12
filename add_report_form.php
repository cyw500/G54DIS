<?php
   $_SESSION['where'] = "report";

   if (isset($_POST['report_action'])) {
       $_SESSION['datetime'] = $_POST['datetime'];
       $_SESSION['Incident_Report'] = $_POST['I_description'];
      switch ($_POST['report_action']) {
           case "Add Driver":
               echo '<script>window.location="assign_person.php"</script>';
               break;

           case "Add Vehicle":
               echo '<script>window.location="assign_vehicle.php"</script>';
               break;

           case "Add Offence":
               echo '<script>window.location="offence_search.php"</script>';
               break;

           case "Reset":
               $_SESSION['People_ID'] = $_SESSION['Vehicle_ID'] =
               $_SESSION['Offence_ID'] = "" ;

               $_SESSION['Driver'] = $_SESSION['Vehicle'] = $_SESSION['Offence'] =
               $_SESSION['Incident_Report'] = "";
               break;

           case "Save":
               if (($_SESSION['Vehicle_ID'] == "") && ($_SESSION['People_ID'] == "")
               && ($_SESSION['Offence_ID'] == "") && ($_POST['I_description'] == "")) {
                   $field_message = "please enter details in at least one field";
               } else {
                    $field_message = "";
               if ($_SESSION['Incident_ID'] == "") {
                   if (!mysqli_query($db, "INSERT INTO Incident
                       (Incident_ID, Vehicle_ID, People_ID, Incident_Date,
                                   Incident_Report, Offence_ID, Officer)
                       VALUES
                       (NULL, NULLIF('{$_SESSION['Vehicle_ID']}',''), NULLIF('{$_SESSION['People_ID']}','')
                       , '{$_SESSION['datetime']}', '{$_POST['I_description']}',
                       NULLIF('{$_SESSION['Offence_ID']}',''), '{$_SESSION['login_user']}' );")) {
                        //    echo("Error description: " . mysqli_error($db));
                            $message = "<br><br><font color=red>Submission Error</font>". mysqli_error($db) ;
                    } else { // if sussfully sumbit query redirect to
                         echo '<script>window.location="view_report.php"</script>';
                      }

                } if ($_SESSION['Incident_ID'] != "") {
                    if (!mysqli_query($db, "UPDATE Incident SET
                    Vehicle_ID = NULLIF('{$_SESSION['Vehicle_ID']}',''),
                    People_ID = NULLIF('{$_SESSION['People_ID']}',''),
                    Incident_Report = '{$_POST['I_description']}',
                    Offence_ID = NULLIF('{$_SESSION['Offence_ID']}', '')
                    WHERE Incident.Incident_ID = '{$_SESSION['Incident_ID']}';")){
                    $message = "<br><br><font color=red>Submission Error</font>". mysqli_error($db) ;
                    } else {
                        echo '<script>window.location="view_report.php"</script>';
                      }
                  }
              }
       }
       }

    // attaching the driver/vehicle/offence
    // getting the offence infomations
    if (isset($_GET['ref_o'])) {
        $_SESSION['Offence_ID'] = $_GET['ref_o'];

        $sql = "SELECT Offence_description From Offence
                WHERE Offence_ID = '{$_SESSION["Offence_ID"]}';";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['Offence'] = "{$row['Offence_description']}" ;

        echo '<script>window.location="add_report.php"</script>';

    // getting/assigning the person/driver informations
    } if (isset($_GET['ref_p'])) {
          $_SESSION["People_ID"] = $_GET['ref_p'];

          $sql = "SELECT * From People WHERE People_ID = '{$_SESSION["People_ID"]}' ;";
          $result = mysqli_query($db, $sql);
          $row = mysqli_fetch_assoc($result);
          $_SESSION['Driver'] = "{$row["People_name"]} ({$row["People_licence"]})" ;

        echo '<script>window.location="add_report.php"</script>';

    // getting/assigning the vehicle informations
    } if (isset($_GET['ref_v'])) {
        $_SESSION['Vehicle_ID'] = $_GET['ref_v'];

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
 <h1><?php echo $_SESSION['Action'] ?> Report</h1>
  <form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Driver: </label>
      <div class="col-sm-7">
          <div class="form-control-static">
           <input type="hidden" name= "driver" value="<?php echo $_SESSION['People_ID']?>">
              <?php echo "{$_SESSION['Driver']}{$field_message}"?></input>
          </div>
        </div>
      <div class="col-sm-3">
        <input type="submit" name="report_action" class="btn btn-default btn-block" value="Add Driver"/>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Vehicle: </label>
       <div class="col-sm-7">
          <div class="form-control-static">
              <input type="hidden" name= "vehicle" value="<?php echo $_SESSION['Vehicle_ID']?>">
              <?php echo "{$_SESSION['Vehicle']}{$field_message}"?></input>
          </div>
       </div>
        <div class="col-sm-3">
          <input type="submit" name="report_action" class="btn btn-default btn-block" value="Add Vehicle"/>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Offence: </label>
          <div class="col-sm-7">
              <input type="hidden" name= "offence" value="<?php echo $_SESSION['Offence_ID']?>">
              <?php echo "{$_SESSION['Offence']}{$field_message}"?></input>
          </div>
          <div class="col-sm-3">
              <input type="submit" name="report_action" class="btn btn-default btn-block" value="Add Offence"/>
          </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Incident datetime: </label>
          <div class="col-sm-7">
              <input type="datetime-local" name="datetime"
                min="<?php echo date("Y-m-d\TH:i",strtotime($_SESSION['datetime']."-14days"))?>"
                max="<?php echo $_SESSION['datetime']?>" class='form-control'
                value="<?php echo $_SESSION['datetime'] ?>">
          </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Incident description: </label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" name="I_description"
                placeholder='<?php echo $field_message?>'" Enter incident detail" ><?php echo $_SESSION['Incident_Report']?></textarea>
        </div>
    </div>

      <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" name="report_action" class="btn btn-default btn-block" value="Save" />
      </div>
      <div class='col-sm-offset-2 col-sm-4'>
        <input type='submit' name='report_action' class='btn btn-default btn-block' value='Reset' />
      </div>
      <div class='col-sm-offset-3'><?php echo $message ?></div>
  <br>
  </form><br>
</div>
</body>
</html>
