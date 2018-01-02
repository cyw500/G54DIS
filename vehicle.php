<?php
    include('home.php');
    include('vehicle_search.php');
?>

<html>
<body>
    <div class='col-sm-offset-1'>
    <form action="vehicle_detail.php" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Add new vehicle"> &nbsp;
    </form><br>
    </div>
</body>
</html>
