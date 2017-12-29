
<?php

if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Search Vehicle":
        $sql = "SELECT * FROM Vehicle WHERE Vehicle_licence LIKE '%".$_POST["car_search"]."%'
                ORDER BY Vehicle_licence ;";
        $result = mysqli_query($db, $sql);
        $count = mysqli_num_rows($result);

        if ($result != "") {
            if ($count == 0) {

                echo "Vehicle plate ".$POST['car_search']." not found";

            } else {
            // if there is more than one return from search
            echo $count. " Vehicle found:" ;

                echo "<ul>";  // start list
                while($row = mysqli_fetch_assoc($result)) {
                    $v_id = $row["Vehicle_ID"];
                    echo "<li> <a href = '?ref=$v_id'>" . $row["Vehicle_licence"].
                        ": " . $row["Vehicle_colour"]. ", " .$row["Vehicle_type"]."</a>";
                    }
                    echo "</ul>";
            }
        }
            break;

        case "Add Vehicle":
            break;
        }
}
?>
