<!DOCTYPE html>
<html lang="ro">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./css/paginaprincipala.css">
	<link rel="stylesheet" href="./css/header.css">
	<link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">

	<script src="paginaprincipala.js"></script>


	<title>Bine ai venit la Biblioteca!</title>
</head>

<script src="paginaprincipala.js"></script>

<body>
	<header id="header">
		<?php 
		$IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
		include ($IPATH."includes/header.php"); 
		?>
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