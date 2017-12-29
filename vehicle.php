<?php
    include('home.php');
    $keyword = $_SESSION['keyword'];

    // removing empty entry - dangerous things (need to adjust with more conditions)
    mysqli_query($db, "DELETE FROM Vehicle WHERE Vehicle_licence = ''
        AND Vehicle_colour = '' AND Vehicle_type = '' ;");

    $sql = "SELECT * FROM Vehicle WHERE Vehicle_licence LIKE '%$keyword%' ORDER BY Vehicle_licence;";

    if (isset($_GET['ref'])) {
        $sql = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_ID = ".$_GET['ref'].";";
        }

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    if ($result != "") {
        if ($count == 0) {

            echo "Vehicle plate '$keyword' not found";

        } else if ($count == 1) {

            $_SESSION["Vehicle_ID"] = mysqli_fetch_assoc($result)["Vehicle_ID"];
            header ("Location: vehicle_detail.php");

        } else {
        // if there is more than one return from search
        echo $count. " Vehicles found:" ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                $id = $row["Vehicle_ID"];
                echo "<li> <a href = '?ref=$id'>" . $row["Vehicle_licence"].
                    ": " . $row["Vehicle_colour"]. ", " .$row["Vehicle_type"]."</a>";
                }
                echo "</ul>";
        }
    }

?>

<html>
<body>
    <!-- it need to be post to work on the vehicle_detail.php page -->
    <form action="vehicle_detail.php" method="post">
        <input type="submit" name="action" value="Add new vehicle"> &nbsp;
    </form><br>
</body>
</html>
