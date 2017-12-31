<?php
   include('vehicle_edit.php');
   $_SESSION['where'] = "assign owner";
   $type="owner"
?>
<?php
   include('search.php');
?>
<?php
if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Search $type":
            $keyword = $_POST["{$type}_search"];
            include('person_search.php');
            break;

        case "Add new $type":
            mysqli_query($db, "INSERT INTO People VALUES ('', '', '', '');");
            $_SESSION["People_ID"] = mysqli_insert_id($db);
            include('person_add.php');
            break;
        }
}
?>
