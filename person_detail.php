<?php
    include('home.php');

    $sql = "SELECT * FROM People WHERE People_ID = '{$_SESSION["People_ID"]}';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    $sub_sql = "SELECT * FROM People NATURAL JOIN Ownership NATURAL JOIN Vehicle
                WHERE People.People_ID = '{$_SESSION["People_ID"]}';";
    $sub_result = mysqli_query($db, $sub_sql);

    echo "<div class='col-sm-offset-1'>";
    echo "Name: " . $row["People_name"]. "<br> Licence: "
        . $row["People_licence"]. "<br> Address: " . $row["People_address"].
        "<br><br>";

    while($sub_row = mysqli_fetch_assoc($sub_result)){
        // ref_v bring you to the $_GET['ref_v'] to the "vehicle_detail.php"
        echo "Vehicle: <a href = '?ref_v={$sub_row["Vehicle_ID"]}'>" . $sub_row["Vehicle_colour"]. ", " . $sub_row["Vehicle_type"].
        " (". $sub_row["Vehicle_licence"].") </a><br>";
    }
    echo "</div>";

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "Delete":
                if (!mysqli_query($db, "DELETE FROM People WHERE People_ID = '{$_SESSION["People_ID"]}';")) {
                    $message = "Error: Vehicle or a fine is attached to ". $row["People_name"]."
                    unless these are remove {$row["People_name"]} cannot be remove from the database";
                } else { echo " <script>
                                    var timer = setTimeout(function() {
                                            window.location='person.php'
                                        }, 2000);
                           </script>" ;
                $message = "Person sucessfully remove from database";}
                break;

            case "Add new person";
                  $_SESSION["People_ID"] = "";
                  $_SESSION["where"] = "add new person";
                  $_SESSION['Action'] = "Add New Person";
                  echo '<script>window.location="person_edit.php"</script>';
                  break;

            case "Edit":
                $_SESSION["where"] = "edit person";
                $_SESSION['Action'] = "Edit Person";
                echo '<script>window.location="person_edit.php"</script>';
    } }

    if (isset($_GET['ref_v'])) {
        $_SESSION["Vehicle_ID"] = $_GET['ref_v'];
        echo '<script>window.location="vehicle_detail.php"</script>';
        }
?>

<html>
<body>
    <br>
    <div class='col-sm-offset-1'>
    <form action="" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Edit"> &nbsp;
        <input type="submit" class="btn btn-default" name="action" value="Delete"><br><br>
        <input type="submit" class="btn btn-default" name="action" value="Add new person"> &nbsp;
    </form>
    <?php echo $message ?>
    </div>
</body>
</html>
