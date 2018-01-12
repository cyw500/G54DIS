<?php
   include('session.php');
   $_SESSION['type'] = "vehicle";
   if ($_SESSION['where'] == "report") {
   include('add_report_form.php');
   } if ($_SESSION["where"] == "edit person") { // coming from person edit/add
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
                if ($_SESSION['where'] == "report") {
                $_SESSION['Action'] = "Assigning new vehicle to a report";
                } if ($_SESSION["where"] == "edit person") {
                $_SESSION["where"] = "assign vehicle";
                $_SESSION['Action'] = "Assign new vehicle to a person";
                }
                echo '<script>window.location="vehicle_edit.php"</script>';
                break;
            }
    }
?>
