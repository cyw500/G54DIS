<?php
    include('home.php');
    // from previous page stored the Person's ID
    $keyword = $_SESSION['keyword'];
    $_SESSION['where'] = "main search";
    include('person_search.php');

?>
<html>
<body>
    <div class='col-sm-offset-1'>
    <form action="person_detail.php" method="post">
        <input type="submit" class="btn btn-default" name="action" value="Add new person">
    </form><br>
    </div>
</body>
</html>
