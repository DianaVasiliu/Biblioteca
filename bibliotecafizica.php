<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/paginaprincipala.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">


    <title>Informatii publice</title>
</head>

<script src="paginaprincipala.js"></script>

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
        </div>
    </div>


    <?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."includes/footer.php"); 
    ?>

<script src="./js/common.js"> </script>
</body>

</html>