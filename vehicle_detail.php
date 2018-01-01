<?php
    include('home.php');

    $sql = "SELECT * FROM Vehicle WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';";
    $row = mysqli_fetch_assoc(mysqli_query($db, $sql));
    $sub_sql = "SELECT * FROM People NATURAL join Ownership RIGHT JOIN Vehicle
                ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID
                WHERE Vehicle.Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';";
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

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                if (!mysqli_query($db, "DELETE FROM Vehicle
                    WHERE Vehicle_ID = '{$_SESSION["Vehicle_ID"]}';")) {
                    $message = "Error: Vehicle is already attached
                    to ".$sub_row["People_name"]." (and or) a fine unless these
                    are remove this vehicle cannot be remove from the database";
                // need to set ownswership table delete/update on cascade
                } else { header("refresh:2; url = vehicle.php");
                $message = "Vehicle sucessfully remove from database";}
                break;

            case "Add new vehicle";
                $_SESSION["Vehicle_ID"] = "";

            case "Edit":
                echo '<script>window.location="vehicle_edit.php"</script>';
    } }
?>

<html>
<body>
    <br><br>
    <form action="" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Edit"> &nbsp;
        <input type="submit" class="btn btn-default" name="action" value="Delete"><br><br>
        <input type="submit" class="btn btn-default" name="action" value="Add new vehicle"> &nbsp;
    </form>
    <?php echo $message ?>
</body>
</html>
