<?php

    $sql = "SELECT * FROM People WHERE CONCAT_WS('|', People_name, People_licence)
            LIKE '%{$_SESSION['keyword']}%' ORDER BY People_name;";

    // only use in getting into view individual person details for edit
    if (isset($_GET['ref_p'])) {
        if ($_SESSION['where'] == "main search"){
        $sql = "SELECT People_ID FROM People WHERE People_ID = ".$_GET['ref_p'].";";
    }}

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    echo "<div class='col-sm-offset-1'>";
    if ($result != "") {
        if ($count == 0) {

            echo "Person '{$_SESSION['keyword']}' not found<br><br>";

        } else {

        if ($count == 1 && $_SESSION['where'] == "main search") {

            $_SESSION["People_ID"] = mysqli_fetch_assoc($result)["People_ID"];
            echo '<script>window.location="person_detail.php"</script>';

        } else {
        // if there is more than one return from search
        echo $count. " Person found:" ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                echo "<li> <a href = '?ref_p=".$row['People_ID']."'>" . $row["People_name"]. "</a> " ;
                if ($row["People_address"] != ""){
                    echo "(" . $row["People_address"]. ")"; }
                }
                echo "</ul>";
            }
        }
    }
 echo "</div>";
?>
