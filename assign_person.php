<?php
   include('session.php');

   if ($_SESSION['where'] == "report") {
   include('add_report_form.php');
   } else { // coming from vehicle edit/add
   $_SESSION['where'] = "assign owner";
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
                include('person_add.php');
                break;
            }
    }
?>
