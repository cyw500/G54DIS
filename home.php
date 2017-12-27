<?php
   include('session.php');
   print_r($_SESSION);

   $message = "";
   $result = "";
   $sub_result = "";

    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
           case " Search Person ":
                $keyword = mysqli_real_escape_string($db,$_POST['keyword']);
                $sql = "SELECT * FROM people WHERE CONCAT_WS('|', People_name, People_licence)
                        LIKE '%$keyword%' ORDER BY People_name;";
                $result = mysqli_query($db, $sql);
                $_SESSION['$var'] = "Person";
                break;

           case " Search Vehicle ":
                $keyword = mysqli_real_escape_string($db,$_POST['keyword']);
                $sql = "SELECT * FROM vehicle WHERE Vehicle_licence LIKE '%$keyword%';";
                $result = mysqli_query($db, $sql);
                $_SESSION['$var'] = "Vehicle";
                break;

           case " Add Report ":
                $message = "3";
                break;
            }
    } if (isset($_GET['ref'])) {
         if ($_SESSION['$var'] == "Person") {
           $sql = "SELECT * FROM people WHERE People_ID = ".$_GET['ref'].";";
           $result = mysqli_query($db, $sql);
         }
         if ($_SESSION['$var'] == "Vehicle") {
           $sql = "SELECT * FROM vehicle WHERE Vehicle_ID = ".$_GET['ref'].";";
           $result = mysqli_query($db, $sql);
         }
       }


?>

    <html>

    <head>
        <title> </title>
    </head>

    <body>
        <form action="home.php" method="post">
            <div class="col-lg-4">
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="keyword">
            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>

            </div>
            <input type="submit" name="action" value=" Search Person "> &nbsp;
            <input type="submit" name="action" value=" Search Vehicle "><br><br>
            <input type="submit" name="action" value=" Add Report "> &nbsp;
            <input type="button" name="view" value=" View <?php echo $login_session?> reports">
        </form><br>
        <?php

        if ($result != "") {
            if (mysqli_num_rows($result) == 0) {

                echo $_SESSION['$var']." not found";

            } else if (mysqli_num_rows($result) == 1) {
                // extract person_id
                if ($_SESSION['$var'] == "Person") {
                    $_SESSION["People_ID"] = mysqli_fetch_assoc($result)["People_ID"];
                    header("Location: person_detail.php");
                }
                if ($_SESSION['$var'] == "Vehicle") {
                    $_SESSION["Vehicle_ID"] = mysqli_fetch_assoc($result)["Vehicle_ID"];
                    header("Location: vehicle_detail.php");
                }
            } else {

            echo mysqli_num_rows($result). " " .$_SESSION['$var']." found:" ;
                if ($_SESSION['$var'] == "Person") {
                    echo "<ul>";  // start list
                    // loop through each row of the result (each tuple will
                    // be contained in the associative array $row)
                    while($row = mysqli_fetch_assoc($result))
                        {
                        $id = $row["People_ID"];
                        echo "<li> <a href = '?ref=$id'>" . $row["People_name"]. "</a> (" . $row["People_address"]. ")";
                        }
                        echo "</ul>";
                    }
                if ($_SESSION['$var'] == "Vehicle")
                {
                    echo "<ul>";  // start list
                    while($row = mysqli_fetch_assoc($result)) {
                        $id = $row["Vehicle_ID"];
                        echo "<li> <a href = '?ref=$id'>" . $row["Vehicle_licence"].
                            "</a>: " . $row["Vehicle_colour"]. ", " .$row["Vehicle_type"];
                        }
                        echo "</ul>";
                }
            }
        }
        ?>
    </body>
    </html>
