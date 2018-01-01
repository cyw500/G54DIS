<?php
    include('home.php');

    if (isset($_GET['ref'])) {
        $_SESSION["Vehicle_ID"] = $_GET['ref'];
        echo '<script>window.location="vehicle_detail.php"</script>';
        }

    $sql = "SELECT * FROM People WHERE People_ID = '{$_SESSION["People_ID"]}';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
                WHERE People.People_ID = '{$_SESSION["People_ID"]}';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Name: " . $row["People_name"]. "<br> Licence: "
        . $row["People_licence"]. "<br> Address: " . $row["People_address"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        $vl = "(". $sub_row["Vehicle_licence"].")";
        // ref bring you to the top $_GET['ref'] to the "vehicle_detail.php"
        echo "Vehicle: " . $sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
        " <a href = '?ref={$sub_row["Vehicle_ID"]}'> $vl</a><br>";
    }

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                if (!mysqli_query($db, "DELETE FROM People WHERE People_ID = '{$_SESSION["People_ID"]}';")) {
                    $message = "Error: ". $row["People_name"]." attached
                    to a vehicle or a fine unless these are remove {$row["People_name"]}
                    cannot be remove from the database";
                //    echo("Error description: " . mysqli_error($db));
                // need to set ownswership table delete/update on cascade
                } else { header("refresh:2; url = person.php");
                $message = "Person sucessfully remove from database";}
                break;

            case "Add new person";
//                mysqli_query($db, "INSERT INTO People VALUES ('', '', '', '');");
//                $_SESSION["People_ID"] = mysqli_insert_id($db);
                  $_SESSION["People_ID"] = "";

            case "Edit":
                echo '<script>window.location="person_edit.php"</script>';
    } }
?>

<html>
<body>
    <br>
    <form action="" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Edit"> &nbsp;
        <input type="submit" class="btn btn-default" name="action" value="Delete"><br><br>
        <input type="submit" class="btn btn-default" name="action" value="Add new person"> &nbsp;
    </form>
    <?php echo $message ?>
</body>
</html>
