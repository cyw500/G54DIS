<?php
   include('session.php');
   $message = "";
   $keyword = "";
   $result = "";
   $sub_result = "";

    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
           case " Search Person ":
                $keyword = mysqli_real_escape_string($db,$_POST['keyword']);
                $sql = "SELECT * FROM people WHERE CONCAT_WS('|', People_name, People_licence)
                        LIKE '%$keyword%' ORDER BY People_name";
                $result = mysqli_query($db, $sql);
                break;

           case " Search Vehicle ":
                $message = "2";
                break;

           case " Add Report ":
                $message = "3";
                break;
            }
    } if (isset($_GET['ref']))
     {
       $sql = "SELECT * FROM people WHERE People_ID = ".$_GET['ref'].";";
       $result = mysqli_query($db, $sql);
     }
?>

    <html>

    <head>
        <title> </title>
    </head>

    <body>
        <form action="home.php" method="post">
            <label>Search  : </label><input type="text" name="keyword" class="box"> &nbsp;
            <input type="submit" name="action" value=" Search Person "> &nbsp;
            <input type="submit" name="action" value=" Search Vehicle "><br><br>
            <input type="submit" name="action" value=" Add Report "> &nbsp;
            <input type="button" name="view" value=" View <?php echo $login_session?> reports">
        </form><br>
        <?php

        if ($result != "") {
            if (mysqli_num_rows($result) == 0) {

                echo "Person not found";

            } else if (mysqli_num_rows($result) == 1) {
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
//              header("Location: add_new_person.php");

            } else {

            echo mysqli_num_rows($result). " People found:" ;
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
        }
        ?>
    </body>
    </html>
