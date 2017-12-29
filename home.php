<?php
   include('session.php');

/*   echo str_repeat('&nbsp;', 20);
   print_r($_SESSION);
   echo "<br><br>";
*/
   $result = "";
   $sub_result = "";

    if (isset($_POST['action'])) {
       switch ($_POST['action']) {
            case "Search Person":
                $_SESSION['keyword'] = mysqli_real_escape_string($db,$_POST['keyword']);
                header("Location: person.php");
                break;

            case "Search Vehicles":
                $_SESSION['keyword'] = mysqli_real_escape_string($db,$_POST['keyword']);
                header("Location: vehicle.php");
                break;
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
                      <a href="add_report.php" class="btn btn-default btn-block" role="button">Add Report</a>
                </div>
                <div class="col-sm-2">
                    <a href="view_report.php" class='btn btn-default btn-block' role='button' style='white-space: normal'>
                <?php
                if ($user_type == "") {
                    echo "View $login_session reports";
                } else if ($user_type == "[Administrator]") {
                    echo "View ALL reports"; }
                ?>
                </a>
                </div>
                <div class="col-sm-offset-3 col-sm-2">
                <?php
                if ($user_type == "[Administrator]"){
                echo "<a href='add_fine.php' class='btn btn-default btn-block' role='button'>Add Fine </a>";
                }
                ?>
                </div>
                <div class="col-sm-2">
                <?php
                if ($user_type == "[Administrator]"){
                echo "<a href='view_fines.php' type=button class='btn btn-default btn-block' role='button'>View Fines</a>";
                }
                ?>
                </div>
            </div>
            </div>
        </form><br>
        <?php echo $message ?>
    </body>
    </html>
