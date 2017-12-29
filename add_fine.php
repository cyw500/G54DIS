<?php
   include('session.php');

   // if user arent admin redirect page
   if ($user_type == "") {
       header ("Location: home.php");
   }
?>


<html>
<body>
<div class="container">
<form class="form-horizontal" action="" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2"> Incident: </label>
      <div class="col-sm-5">
        <p class="form-control-static"><?php ?> incident </p>
      </div>
      <div class="col-sm-2">
        <a href="search_incident.php" class="btn btn-default btn-block" role="button" style='white-space: normal'>Select incident</a>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2"> Fine: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="fine">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2"> Points: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="points">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" name="save" class="btn btn-default btn-block">Save</button>
      </div>
    </div>
    <div class="col-sm-9">
    <a href="home.php" class="btn btn-default pull-right" role="button">Back</a><br><br>
    </div>
</form>
</div>

</body>
</html>
