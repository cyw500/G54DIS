<?php
   include('vehicle_edit.php');
   $_SESSION['where'] = "assign owner";
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
                    <input type="submit" name="action" value="Add new owner"
                           class="btn btn-default" style='white-space: normal'/>
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
        $keyword = $_POST["owner_search"];
        include('person_search.php');
            break;

        case "Add new owner":
            mysqli_query($db, "INSERT INTO People VALUES ('', '', '', '');");
            $_SESSION["People_ID"] = mysqli_insert_id($db);
            include('person_add.php');
            break;
        }
}
?>
