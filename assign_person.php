<?php
   include('session.php');

   if ($_SESSION['where'] == "report") {
   $_SESSION['type'] = "driver";
   include('add_report_form.php');
   } if ($_SESSION["where"] == "edit vehicle") { // coming from vehicle edit/add
   $_SESSION['type'] = "owner";
   include('vehicle_add.php');
   }

    include('search.php');

    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
            case "Search ".$_SESSION['type']."":
                $_SESSION['keyword'] = $_POST["{$_SESSION['type']}_search"];
                include('person_search.php');
                break;

            case "Add new ".$_SESSION['type']."":
                $_SESSION["People_ID"] = "";
                if ($_SESSION['where'] == "report") {
                $_SESSION['Action'] = "Assigning new driver to a report";
                } if ($_SESSION["where"] == "edit vehicle") {
                $_SESSION["where"] = "assign owner";
                $_SESSION['Action'] = "Assigning new owner to the vehicle";
                }
                echo '<script>window.location="person_edit.php"</script>';
                break;
            }
    }
?>
