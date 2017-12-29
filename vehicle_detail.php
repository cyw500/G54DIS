<?php
    include('home.php');
    $V_id = $_SESSION["Vehicle_ID"];

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                mysqli_query($db, "DELETE FROM Vehicle WHERE Vehicle_ID = '$V_id';");
                // need to set ownswership table delete/update on cascade
                header("refresh:2; url = vehicle.php");
                $message = "Vehicle sucessfully remove from database";
                break;

            case "Add new vehicle";
                mysqli_query($db, "INSERT INTO Vehicle VALUES ('', '', '', '');");
                $_SESSION["Vehicle_ID"] = mysqli_insert_id($db);

            case "Edit":
                header ("Location: vehicle_edit.php");
    } }

    $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM Vehicle WHERE Vehicle_ID = '$V_id';"));
    $sub_sql = "SELECT * FROM People NATURAL join Ownership RIGHT JOIN Vehicle
                ON vehicle.Vehicle_ID = ownership.Vehicle_ID WHERE vehicle.Vehicle_ID = '$V_id';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Licence: " . $row["Vehicle_licence"]. "<br> Colour: "
        . $row["Vehicle_colour"]. "<br> Type: " . $row["Vehicle_type"].
        "<br><br>";

    echo "Owner: ";
        $sub_row = mysqli_fetch_assoc($sub_result);
        if (isset($sub_row["People_ID"])){
        $_SESSION["People_ID"] = $sub_row["People_ID"];
        echo "<a href = 'person_detail.php'>" . $sub_row["People_name"]. "</a> ";
        if ($sub_row["People_licence"] != ""){
            echo "(". $sub_row["People_licence"]. ")"; }
        }
    echo "<br><br>";
?>

<html>
<body>
    <form action="" method="post">
        <input type="submit" name="action" value="Edit"> &nbsp;
        <input type="submit" name="action" value="Delete"><br><br>
        <input type="submit" name="action" value="Add new vehicle"> &nbsp;
        <a href="vehicle_detail.php" class="btn btn-default pull-right" role="button">Back</a>
    </form><br>
    <?php echo $message ?>
</body>
</html>
