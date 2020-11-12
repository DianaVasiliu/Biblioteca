<?php
    require_once './dbconnect.php';

    $link = connectdb();

    $message = '';

    $match = 0;
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

        $email = mysqli_escape_string($link, $_GET['email']); // Set email variable
        $hash = mysqli_escape_string($link, $_GET['hash']); // Set hash variable

        $query = mysqli_query($link, "SELECT email, token, activ FROM client WHERE email='" . $email . "' AND token='" . $hash . "' AND activ='0'") or die(mysql_error()); 
        $match  = mysqli_num_rows($query);

        // echo $match;
        if ($match > 0) {
            // echo 'We have a match! ' . $email;
            $updateq = "UPDATE client SET activ = 1 WHERE email='" . $email . "' AND token='" . $hash . "' AND activ=0";

            $result = mysqli_query($link, $updateq);
            if (!$result) {
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inregistrare</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/mobile_menu.css">
    
</head>
<body>
    <header id="header">    
        <?php 
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."includes/header.php"); 
        ?>
        <div id="bottom">
        </div>
	</header>
    <?php
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."includes/mobile_menu.php"); 
    ?>

    <div id="corp">
        <div id="continut">
            <div id="div_activat">
                <div id="activat">
                    <p>
                        <?php
                            print $message;
                        ?>
                    </p>
                </div>
            </div>
            <p><a href="../paginaprincipala.php">Inapoi la pagina principala</a></p>
        </div>
    </div>

    <?php 
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."includes/footer.php"); 
    ?>
</body>
</html>