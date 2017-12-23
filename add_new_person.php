<?php
    include('home.php');
    $test = "d";
    echo "$test";
?>

<html>
<body>
    <?php

    $row = mysqli_fetch_assoc($result);
    $sub_sql = "SELECT * FROM people NATURAL join ownership natural join vehicle where people.People_ID = '{$row["People_ID"]}' ";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "Name: " . $row["People_name"]. "<br> Licence: "
        . $row["People_licence"]. "<br> Address " . $row["People_address"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        echo "Vehicle: " . $sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
        " (". $sub_row["Vehicle_licence"]. ")<br>";
    }

    ?>
    <form action="" method="post">
        <input type="submit" name="action" value="Edit"> &nbsp;
        <input type="submit" name="action" value="Delete"><br><br>
        <input type="submit" name="action" value="Add new person"> &nbsp;
    </form><br>
</body>
</html>
