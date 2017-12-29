<?php
   include('person_edit.php');

?>

<html>
<body>
    <form action="" method="post">
        <div class="row">
        <div class="col-sm-offset-2 col-sm-5">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="car_search">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <input type="submit" name="action" value="Search Vehicle" class="btn btn-default"/>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <input type="submit" name="action" value="Add Vehicle" class="btn btn-default"/>
                </div>
            </div>
        </div>
        </div>
    </form>

</body>
</html>

<?php
include('vehicle_search.php');
?>
