<?php
   include('session.php');

    $_SESSION['where'] = "main search";
    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
            case "Search Person":
                $_SESSION['keyword'] = mysqli_real_escape_string($db,$_POST['keyword']);
                $_SESSION['search_type'] = "person";
                echo '<script>window.location="person.php"</script>';
                break;

            case "Search Vehicles":
                $_SESSION['keyword'] = mysqli_real_escape_string($db,$_POST['keyword']);
                $_SESSION['search_type'] = "vehicle";
                echo '<script>window.location="vehicle.php"</script>';
                break;

            case "Add Report":
                $_SESSION['Action'] = "Add New";
                $_SESSION['People_ID'] = $_SESSION['Vehicle_ID'] =
                $_SESSION['Offence_ID'] = $_SESSION['Incident_ID'] = "";

                $_SESSION['Driver'] = $_SESSION['Vehicle'] = $_SESSION['Offence'] =
                $_SESSION['Incident_Report'] = "";
                echo '<script>window.location="add_report.php"</script>';
                break;

            case "Add Fine":
                $_SESSION['Action'] = "Add";
                $_SESSION['Incident'] = "";
                echo '<script>window.location="add_fine.php"</script>';
    }
}
?>

    <html>

    <head>
        <title> </title>
    </head>

    <body>
        <form action="home.php" method="post">
            <div class="row">
            <div class="col-sm-offset-1 col-sm-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="keyword">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                    <input type="submit" name="action" value="Search Person" class="btn btn-default"/>
                    </div>
                    <div class="btn-group">
                    <input type="submit" name="action" value="Search Vehicles" class="btn btn-default"/>
                    </div>
                </div>
            </div>
            </div>
            <br>
            <div class="row">
            <div class="col-sm-offset-1">
                <div class="col-sm-2">
                      <input type="submit" name="action" value="Add Report" class="btn btn-default btn-block"/>
                </div>
                <div class="col-sm-2">
                    <a href="view_report.php" class='btn btn-default btn-block' style='white-space: normal'>
                <?php
                if ($user_type == "") {
                    echo "View {$_SESSION['login_user']} reports";
                } else if ($user_type == "[Administrator]") {
                    echo "View ALL reports"; }
                ?>
                </a>

                </div>
                <div class="col-sm-offset-3 col-sm-2">
                <?php
                if ($user_type == "[Administrator]"){
                echo "<input type='submit' name='action' value='Add Fine' class='btn btn-default btn-block'></a>";
                }
                ?>
                </div>
                <div class="col-sm-2">
                <?php
                if ($user_type == "[Administrator]"){
                echo "<a href='view_fines.php' type=button class='btn btn-default btn-block'>View Fines</a>";
                }
                ?>
                </div>
            </div>
            </div>
        </form><br>
    </body>
    </html>
