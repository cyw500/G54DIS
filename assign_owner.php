<?php
   include('vehicle_edit.php');
?>

<html>
<body>
    <form action="" method="post">
        <div class="row">
        <div class="col-sm-offset-2 col-sm-5">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="owner_search">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <input type="submit" name="action" value="Search owner" class="btn btn-default"/>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <input type="submit" name="action" value="Add Person" class="btn btn-default"/>
                </div>
            </div>
        </div>
        </div>
    </form>

</body>
</html>

<?php

if (isset($_POST['action'])) {
   switch ($_POST['action']) {
        case "Search owner":
        $sql = "SELECT * FROM People WHERE CONCAT_WS('|', People_name, People_licence)
                LIKE '%".$_POST["owner_search"]."%' ORDER BY People_name;";
        $result = mysqli_query($db, $sql);
        $count = mysqli_num_rows($result);

        if ($result != "") {
            if ($count == 0) {

                echo "Person ".$_POST["owner_search"]." not found";

            } else {
            // if there is more than one return from search
            echo $count. " Person found:" ;

                echo "<ul>";  // start list
                while($row = mysqli_fetch_assoc($result))
                    {
                    $p_id = $row["People_ID"];
                    echo "<li> <a href = '?ref=$p_id'>" . $row["People_name"]. "</a> " ;
                    if ($row["People_address"] != ""){
                        echo "(" . $row["People_address"]. ")"; }
                    }
                    echo "</ul>";
            }
        }
            break;

        case "Add Person":
            break;
        }
}
?>
