 <?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "g54dis2";
 /*
  $servername = "mysql.cs.nott.ac.uk";
  $username = "psxcyw";
  $password = "adv6125h";
  $dbname = "psxcyw";
 */
 $db = mysqli_connect($servername, $username, $password, $dbname);;

 if($db == false){
	 die("Network error, fail to connect to police traffic database".mysqli_connect_error());
 }

 ?>

    <html>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .navbar {
            background-color: #eeffff;
            border: 0;
            font-size: 18px;
            letter-spacing: 2px;
            font-family: Montserrat, sans-serif;
        }

        .jumbotron {
            background-color: #eeffff;
            margin-bottom: 0;
        }
        {
            font-size: 14px;
            letter-spacing: 2px;
            font-family: Montserrat, sans-serif;
        }
        label.col-sm-2 {
        text-align: right !important;
        }

        label.col-sm-offset {
        text-align: left !important;

        }

    </style>
    <div class="jumbotron text-center">
        <h1>Police Traffic Records</h1>
    </div>
    </html>
