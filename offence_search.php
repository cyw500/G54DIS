<?php
    include('add_report.php');
    include('search.php');

    if (isset($_POST["{$_SESSION['type']}_search"])){
    $_SESSION['keyword'] = $_POST["{$_SESSION['type']}_search"];

    $sql = "SELECT * FROM Offence WHERE Offence_description LIKE '%{$_SESSION['keyword']}%'
            ORDER BY Offence_description DESC;";

    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    echo "<div class='col-sm-offset-1'>";
    if ($result != "") {
        if ($count == 0) {

            echo "Offence '{$_SESSION['keyword']}' not found";

        } else {

        // if there is more than one return from search
        echo "Select offence: " ;

            echo "<ul>";  // start list
            while($row = mysqli_fetch_assoc($result)) {
                echo "<li> <a href = '?ref_o=".$row['Offence_ID']."'>" . $row["Offence_description"].
                    "</a>";
                }
                echo "</ul>";
            }
        }
    echo "</div>";
    }
?>
