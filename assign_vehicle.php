<?php
   include('session.php');
   if ($_SESSION['where'] == "report") {
   include('add_report_form.php');
} else  { // coming from person edit/add
    // if ($_SESSION['where'] == "assign vehicles") need to change at person_add.php
    // currently as it is a link the two $_SESSION should actually be in person_add.php
   $_SESSION['where'] = "assign vehicles";
   $_SESSION['type'] = "vehicle";
   include('person_add.php');
   }

    include('search.php');
    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
            case "Search {$_SESSION['type']}":
            $_SESSION['keyword'] = $_POST["{$_SESSION['type']}_search"];
            include('vehicle_search.php');
                break;

            case "Add new {$_SESSION['type']}":
            //    get this session person id , add new vehicle
                $_SESSION["Vehicle_ID"] = "";
                include('vehicle_add.php');
                break;
            }
    }
?>
