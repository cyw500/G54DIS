<?php
   include('person_edit.php');
   $_SESSION['where'] = "assign vehicles";
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
                    <input type="submit" name="action" value="Search Vehicle" class="btn btn-default" style='white-space: normal'/>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <input type="submit" name="action" value="Add new vehicle" class="btn btn-default" style='white-space: normal'/>
                </div>
            </div>
        </div>
        </div>
    </form>

</body>
</html>

<?php

if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Search Vehicle":
        $keyword = $_POST["car_search"];
        include('vehicle_search.php');
            break;

        case "Add new vehicle":
        //    get this session person id , add new vehicle
            mysqli_query($db, "INSERT INTO Vehicle VALUES ('', '', '', NULL);");
            $_SESSION["Vehicle_ID"] = mysqli_insert_id($db);
            include('vehicle_add.php');
            break;
        }
}
?>
