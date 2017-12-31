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
        <p class="form-control-static"><?php ?> driver</p>
      </div>
      <div class="col-sm-3">
        <input type="button" class="btn btn-default btn-block" value="Add driver"/>
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
        <p class="form-control-static"><?php ?> CarX</p>
      </div>
      <div class="col-sm-3">
        <input type="button" class="btn btn-default btn-block" name="Search Vehicle" value="Add Vehicle"/>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Offence: </label>
      <div class="col-sm-7">
        <p class="form-control-static"><?php ?> OffenceY</p>
      </div>
      <div class="col-sm-3">
        <input type="button" class="btn btn-default btn-block" value="Add Offence"/>
      </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Incident description: </label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" placeholder="Enter incident detail" required></textarea>
        </div>
    </div>


    <div class="row">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
      <div class="col-sm-offset-2 col-sm-4">
        <button type="reset" name="cancel" class="btn btn-default btn-block">Cancel</button>
      </div>
    </div>

  <br><a href="home.php" class="btn btn-default pull-right" role="button">Back</a>
  </form>
</div>

</body>
</html>
