<?php

$message = "";

if (isset($_POST['calculate'])) // check contents of $_POST supervariables
     {
// branch on the basis of 'calculate' value
    switch ($_POST['calculate']) {
          // if calculate => add
          case 'add':
                $message =  $_POST['number_1'] . " + " . $_POST['number_2'] . " = " . ($_POST['number_1']+$_POST['number_2']);
                break;

          // if calculate => subtract
          case 'subtract':
                $message =  $_POST['number_1'] . " - " . $_POST['number_2'] . " = " . ($_POST['number_1']-$_POST['number_2']);
                break;

          // if calculate => multiply
          case 'multiply':
                $message =  $_POST['number_1'] . " x " . $_POST['number_2'] . " = " . ($_POST['number_1']*$_POST['number_2']);
                break;

            }
        }
        else // if query result is empty
          {
            echo "Database is empty";
          }

?>

<html><head>Multi-button from with switch/case</head>
<body>

<form action="processor.php" method="post">
Enter a number: <input type="text" name="number_1" size="3"> <br>
Enter another number: <input type="text" name="number_2" size="3"> <br>
<input type="submit" name="calculate" value="add">
<input type="submit" name="calculate" value="subtract">
<input type="submit" name="calculate" value="multiply"> </form>
<?php echo $message ?>

</body>
</html>
