<?php
    require_once './dbconnect.php';

    $link = connectdb();

    $message = '';

    $match = 0;
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

        $email = mysqli_escape_string($link, $_GET['email']); // Set email variable
        $hash = mysqli_escape_string($link, $_GET['hash']); // Set hash variable

        $query = "SELECT email, token, activ 
                  FROM client 
                  WHERE BINARY email = '" . $email . "' 
                  AND BINARY token = '" . $hash . "' 
                  AND activ = '0'";

        $res = mysqli_query($link, $query);

        $match  = mysqli_num_rows($res);

        if ($match > 0) {

            $query = "UPDATE client SET activ = 1 WHERE BINARY email='" . $email . "' AND BINARY token='" . $hash . "' AND activ='0'";

            $res = mysqli_query($link, $query);

            if (!$res) {
                die(mysqli_error());
            }

            $message = 'Contul tau a fost activat cu succes!';
        }
        else {
            $message = 'Invalid URL';
        }
    }
    else{
        $message = 'Invalid approach';
    }

?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <title>Inregistrare</title>
    <link rel="stylesheet" href="../css/body.css">
    <style>
        #continut, #corp {
            border: none;
        }
    </style>
</head>

<body>
    <div id="corp">
        <div id="continut">
            <div id="div_activat">
                <div id="activat">
                    <p>
                        <?php
                            echo $message;
                        ?>
                    </p>
                </div>
            </div>
            <p><a href="../paginaprincipala.php">Inapoi la pagina principala</a></p>
        </div>
    </div>

</body>
</html>