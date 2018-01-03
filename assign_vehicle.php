<?php
   include('session.php');
   if ($_SESSION['where'] == "report") {
   include('add_report_form.php');
   } if (($_SESSION["where"] == "edit person") or ($_SESSION["where"] == "add new person"))  { // coming from person edit/add
    // if ($_SESSION['where'] == "assign vehicles") need to change at person_add.php
    // currently as it is a link the two $_SESSION should actually be in person_add.php
   $_SESSION['type'] = "vehicle";
   include('person_add.php');
   }

    include('search.php');
    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
            case "Search {$_SESSION['type']}":
            $_SESSION['keyword'] = $_POST["{$_SESSION['type']}_search"];
            include('vehicle_search.php');
// after error
// Notice: Undefined index: Vehicle_licence in C:\xampp\htdocs\G54DIS\psxcyw\vehicle_search.php on line 36
// Notice: Undefined index: Vehicle_colour in C:\xampp\htdocs\G54DIS\psxcyw\vehicle_search.php on line 37
// Notice: Undefined index: Vehicle_type in C:\xampp\htdocs\G54DIS\psxcyw\vehicle_search.php on line 37
                break;

            case "Add new {$_SESSION['type']}":
            //    get this session person id , add new vehicle
                $_SESSION["Vehicle_ID"] = "";
                if ($_SESSION['where'] == "report") {
                $_SESSION['Action'] = "Assigning new vehicle to a report";
                } if (($_SESSION["where"] == "edit person") or ($_SESSION["where"] == "add new person")) {
                $_SESSION["where"] = "assign vehicle";
                $_SESSION['Action'] = "Assign new vehicle to a person";
                }
                echo '<script>window.location="vehicle_edit.php"</script>';
                break;
            }
    }
?>
