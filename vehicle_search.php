<?php
    if ($_SESSION['keyword'] == ""){
    $sql = "SELECT * FROM Vehicle";
    } else {
    $sql = "SELECT * FROM Vehicle WHERE Vehicle_licence LIKE '%{$_SESSION['keyword']}%' ORDER BY Vehicle_licence;";
    }

    // Use in getting into view individual vehicle details for edit
    if (isset($_GET['ref_v'])) {
        if ($_SESSION['where'] == "main search"){
        $sql = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_ID = ".$_GET['ref_v'].";";
    }}

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    echo "<div class='col-sm-offset-1'>";
    if ($result != "") {
        if ($count == 0) {

            echo "Vehicle plate '{$_SESSION['keyword']}' not found<br><br>";

        } else {

        if ($count == 1 && $_SESSION['where'] == "main search") {

            $_SESSION["Vehicle_ID"] = mysqli_fetch_assoc($result)["Vehicle_ID"];
            echo '<script>window.location="vehicle_detail.php"</script>';


        } else {
        // if there is more than one return from search
        echo $count. " Vehicles found:" ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                echo "<li> <a href = '?ref_v=".$row['Vehicle_ID']."'>" . $row["Vehicle_licence"].
                    ": " . $row["Vehicle_colour"]. ", " .$row["Vehicle_type"]."</a>";
                }
                echo "</ul>";
            }
        }
    }
    echo "</div>";
?>
