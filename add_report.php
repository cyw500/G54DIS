<?php
   include('session.php');

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
              <?php echo $_SESSION['People_ID']?></input>
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
              <?php echo $_SESSION['Vehicle_ID']?></input>
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
              <?php echo $_SESSION['Offence_ID']?></input>
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
            <textarea class="form-control" rows="3" name="I_description" placeholder="Enter incident detail"></textarea>
        </div>
    </div>

      <div class="col-sm-offset-2 col-sm-4">
        <input type="submit" name="action" class="btn btn-default btn-block" value="Save" />
      </div>
      <div class="col-sm-offset-2 col-sm-4">
        <input type="reset" name="cancel" class="btn btn-default btn-block" value="Cancel" />
      </div>


  <br><a href="home.php" class="btn btn-default pull-right" role="button">Back</a>
  </form><br><br>
</div>
</body>
</html>

<?php

if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Add Driver":
            $type = "driver";
            include('search.php');
            break;

        case "Add Vehicle":
            $type = "vehicle";
            include('search.php');
            break;

        case "Add Offence":
            $type = "offence";
            include('search.php');
            break;

        case "Save":
            if (!mysqli_query($db, "INSERT INTO Incident
                (Incident_ID, Vehicle_ID, People_ID, Incident_Date,
                            Incident_Report, Offence_ID, Officer_ID)
                VALUES (NULL, '".$_SESSION['Vehicle_ID']."', '".$_SESSION['People_ID']."', CURRENT_TIMESTAMP,
                            '".$_POST['I_description']."','".$_SESSION['Offence_ID']."', $login_user_id );")) {
                                echo("Error description: " . mysqli_error($db)); }
        }
}
?>
