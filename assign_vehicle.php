<?php
   include('person_edit.php');
   $_SESSION['where'] = "assign vehicles";
   $type="vehicle"
?>
<?php
   include('search.php');
?>
<?php

if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Search $type":
        $keyword = $_POST["{$type}_search"];
        include('vehicle_search.php');
            break;

        case "Add new $type":
        //    get this session person id , add new vehicle
            mysqli_query($db, "INSERT INTO Vehicle VALUES ('', '', '', NULL);");
            $_SESSION["Vehicle_ID"] = mysqli_insert_id($db);
            include('vehicle_add.php');
            break;
        }
}
?>
