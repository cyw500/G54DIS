<?php
    include('home.php');
    $P_id = $_SESSION["People_ID"];

    if (isset($_GET['ref'])) {
        $_SESSION["Vehicle_ID"] = $_GET['ref'];
        header ("Location: vehicle_detail.php");
        }

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                if (!mysqli_query($db, "DELETE FROM People WHERE People_ID = '$P_id';")) {
                    echo("Error description: " . mysqli_error($db));
                // need to set ownswership table delete/update on cascade
                } else { header("refresh:2; url = person.php");
                $message = "Person sucessfully remove from database";}
                break;

            case "Add new person";
                mysqli_query($db, "INSERT INTO People VALUES ('', '', '', '');");
                $_SESSION["People_ID"] = mysqli_insert_id($db);

            case "Edit":
                header ("Location: person_edit.php");
    } }

    $sql = "SELECT * FROM People WHERE People_ID = '$P_id';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
                WHERE people.People_ID = '$P_id';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Name: " . $row["People_name"]. "<br> Licence: "
        . $row["People_licence"]. "<br> Address: " . $row["People_address"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        $v_id = $sub_row["Vehicle_ID"];
        $vl = "(". $sub_row["Vehicle_licence"].")";
        echo "Vehicle: " . $sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
        " <a href = '?ref=$v_id'> $vl</a><br>";
    }
    echo "<br>";

?>

<html>
<body>
    <form action="" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Edit"> &nbsp;
        <input type="submit" class="btn btn-default" name="action" value="Delete"><br><br>
        <input type="submit" class="btn btn-default" name="action" value="Add new person"> &nbsp;
    </form><br>
    <?php echo $message ?>
</body>
</html>
