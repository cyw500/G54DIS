<?php
    // removing empty entry
    mysqli_query($db, "DELETE FROM People WHERE People_name = '';");

    $sql = "SELECT * FROM People WHERE CONCAT_WS('|', People_name, People_licence)
            LIKE '%$keyword%' ORDER BY People_name;";

    // only use in getting into view individual person details for edit
    if (isset($_GET['ref_p'])) {
        $sql = "SELECT People_ID FROM People WHERE People_ID = ".$_GET['ref_p'].";";
    }

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    echo "<div class='col-sm-offset-1'>";
    if ($result != "") {
        if ($count == 0) {

            echo "Person '$keyword' not found";

        } else {

        if ($count == 1 && $_SESSION['where'] == "main search") {

            $_SESSION["People_ID"] = mysqli_fetch_assoc($result)["People_ID"];
            header ("Location: person_detail.php");

        } else {
        // if there is more than one return from search
        echo $count. " Person found:" ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                $p_id = $row["People_ID"];
                echo "<li> <a href = '?ref_p=$p_id'>" . $row["People_name"]. "</a> " ;
                if ($row["People_address"] != ""){
                    echo "(" . $row["People_address"]. ")"; }
                }
                echo "</ul>";
            }
        }
    }
 echo "</div>";
?>
