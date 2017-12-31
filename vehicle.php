<?php
    include('home.php');
    $keyword = $_SESSION['keyword'];
    $_SESSION['where'] = "main search";
    include('vehicle_search.php');
?>

<html>
<body>
    <div class='col-sm-offset-1'>
    <!-- it need to be post to work on the vehicle_detail.php page -->
    <form action="vehicle_detail.php" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Add new vehicle"> &nbsp;
    </form><br>
    </div>
</body>
</html>
