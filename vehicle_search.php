<?php
    // removing empty entry
    mysqli_query($db, "DELETE FROM Vehicle WHERE Vehicle_licence is NULL
        AND Vehicle_colour = '' AND Vehicle_type = '' ;");

    $sql = "SELECT * FROM Vehicle WHERE Vehicle_licence LIKE '%$keyword%' ORDER BY Vehicle_licence;";

    // only use in getting into view individual vehicle details for edit
    if (isset($_GET['ref_v'])) {
        $sql = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_ID = ".$_GET['ref_v'].";";
        }

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    echo "<div class='col-sm-offset-1'>";
    if ($result != "") {
        if ($count == 0) {

            echo "Vehicle plate '$keyword' not found";

        } else {

        if ($count == 1 && $_SESSION['where'] == "main search") {

            $_SESSION["Vehicle_ID"] = mysqli_fetch_assoc($result)["Vehicle_ID"];
            header ("Location: vehicle_detail.php");

        } else {
        // if there is more than one return from search
        echo $count. " Vehicles found:" ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                $id = $row["Vehicle_ID"];
                echo "<li> <a href = '?ref_v=$id'>" . $row["Vehicle_licence"].
                    ": " . $row["Vehicle_colour"]. ", " .$row["Vehicle_type"]."</a>";
                }
                echo "</ul>";
            }
        }
    }
    echo "</div>";
?>
