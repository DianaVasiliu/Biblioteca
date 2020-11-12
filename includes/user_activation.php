<?php
    require_once './dbconnect.php';

    $match = 0;
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

        $email = mysqli_escape_string($link, $_GET['email']); // Set email variable
        $hash = mysqli_escape_string($link, $_GET['hash']); // Set hash variable

        $query = mysqli_query($link, "SELECT email, token, activ FROM client WHERE email='" . $email . "' AND token='" . $hash . "' AND activ='0'") or die(mysql_error()); 
        $match  = mysqli_num_rows($query);

        echo $match;
        if ($match > 0) {
            echo 'We have a match! ' . $email;
        }
        else {
            echo 'Invalid URL';
        }
    }
    else{
        echo 'Invalid approach';
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inregistrare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: auto;}
    </style>
</head>
<body>
    <!-- <div class="wrapper">
    </div>     -->
</body>
</html>