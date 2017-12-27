<?php
    include('home.php');
    $V_id = $_SESSION["Vehicle_ID"];
?>

<html>
<body>
    <?php

    $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM vehicle WHERE Vehicle_ID = '$V_id';"));
    $sub_sql = "SELECT * FROM people NATURAL join ownership RIGHT JOIN vehicle
                ON vehicle.Vehicle_ID = ownership.Vehicle_ID WHERE vehicle.Vehicle_ID = '$V_id';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Licence: " . $row["Vehicle_licence"]. "<br> Colour: "
        . $row["Vehicle_colour"]. "<br> Type: " . $row["Vehicle_type"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        $p_id = $sub_row["People_ID"];
        echo "Owner: <a href = '?ref=$p_id'>" . $sub_row["People_name"]. "</a><br><br>";
    }

    ?>
    <form action="" method="post">
        <input type="submit" name="action" value="Edit"> &nbsp;
        <input type="submit" name="action" value="Delete"><br><br>
        <input type="submit" name="action" value="Add new vehicle"> &nbsp;
    </form><br>
</body>
</html>
