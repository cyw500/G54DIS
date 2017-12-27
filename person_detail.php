<?php
    include('home.php');
    // from previous page stored the Person's ID
    $P_id = $_SESSION["People_ID"];
    $message = "";

    if (isset($_GET['ref'])) {
           $_SESSION["Vehicle_ID"] = $_GET['ref'];
           header ("Location: vehicle_detail.php");
         }

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                mysqli_query($db, "DELETE FROM people WHERE People_ID = '$P_id';");
                // need to set ownswership table delete/update on cascade
                header("refresh:2; url = home.php");
                $message = "Person sucessfully remove from database";
                break;
            case "Edit":
                header ("Location: person_edit.php");
                break;
            case "Add new person";
                mysqli_query($db, "INSERT INTO people VALUES (NULL, '', NULL, NULL);");
                $_SESSION["People_ID"] = mysqli_insert_id($db);
                header ("Location: person_edit.php");
    } }


?>

<html>
<body>
    <?php

    $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM people WHERE People_ID = '$P_id';"));
    $sub_sql = "SELECT * FROM people NATURAL JOIN ownership NATURAL JOIN vehicle
                WHERE people.People_ID = '$P_id';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Name: " . $row["People_name"]. "<br> Licence: "
        . $row["People_licence"]. "<br> Address " . $row["People_address"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        $v_id = $sub_row["Vehicle_ID"];
        echo "Vehicle: " . $sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
        " (<a href = '?ref=$v_id'>". $sub_row["Vehicle_licence"]. "</a>)<br>";
    }
    echo "<br>";

    ?>

    <form action="person_detail.php" method="post">
        <input type="submit" name="action" value="Edit"> &nbsp;
        <input type="submit" name="action" value="Delete"><br><br>
        <input type="submit" name="action" value="Add new person"> &nbsp;
    </form><br>
    <?php echo $message ?>
</body>
</html>
