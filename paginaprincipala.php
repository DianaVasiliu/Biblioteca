<?php
    session_start();
    $_SESSION['changed_page'] = '';
?>

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
		include ($IPATH."requirements/header.php"); 
		?>
	</header>
    <?php
        $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
        include ($IPATH."requirements/mobile_menu.php"); 
    ?>

	<div id="corp">
		<div id="continut">
			<div class="section">
				<div class="images">
					<img class="myPhotos" src="./pics/bibnat.jpg">
				</div>
				<div class="info">	
				<p>Biblioteca Nationala este cea mai mare biblioteca din Bucuresti, gazduind o multitudine de volume de carti din diverse categorii.</p>
				<p>Biblioteca Nationala a Romaniei are doua locatii in Bucuresti:
					<ul>
						<li><b>Cladirea principala:</b> Colectiile bibliotecii cuprind circa 9.000.000 de unitati bibliografice cu caracter enciclopedic, organizate in fonduri curente - publicatii romanesti si straine (carti, ziare si reviste) - si fonduri ale colectiilor speciale (bibliofilie, manuscrise, arhiva istorica, periodice romanesti vechi, stampe, fotografii, cartografie, audio-vizual). </li>
						<br>
						<li><b>Sectia de colectii speciale:</b> Serviciul Colectii Speciale este structurat conform continutului specific al fiecarei colectii pe sapte compartimente distincte, astfel: Bibliofilie, Manuscrise, Arhiva istorica, Periodice romanesti vechi, Stampe, Fotografii, Cartografie. Acestora li se adauga Compartimentul audio-video, care are o colectie de tiparituri muzicale, de inregistrari pe suporturi diverse, de la discuri de patefon, pana la CD-uri si DVD-uri.</li>
					</ul>
				</p>
				<p>Mai multe informatii despre locatia celor doua se gasesc in sectiunea "Despre noi".</p>
				</div>
			</div>

			<div class="section">
				<div class="info">	
					<p>Biblioteca Nationala dispune de numeroase spatii deschise, la parter, mezanin si etajele 1-3. Spatiile deschise sunt dotate cu lampi si prize individuale, iar o parte din ele sunt dotate cu calculatoare conectate la internet.</p>
					<p>Exista si sali de lectura la mezanin si la etajul 1.</p>
					<p>La mezanin, se gasesc urmatoarele sali de lectura:
						<ul>
							<li>Ludoteca "Apolodor din Labrador"</li>
						</ul>
					</p>
					<p>La etajul 1, sunt urmatoarele sali de lectura:
						<ul>
							<li>Sala de Stiinte filologice „Mihai Eminescu”</li>
							<li>Sala de stiinte Economice „Virgil Madgearu”</li>
							<li>Sala de stiinte Juridice „Mircea Djuvara”</li>
							<li>Sala de copii si tineret „Ionel Teodoreanu”</li>
							<li>Sala multimedia „George Enescu”</li>
							<li>Centrul de Resurse si Informare „American Corner Bucuresti”</li>
						</ul>
					</p>
					<p>Programul spatiilor deschise se regaseste in partea de jos a paginii.</p>
					</div>

					<div class="images">
						<img class="myPhotos" src="./pics/interior2.jpg">
					</div>
				</div>
			</div>

			<div class="section mini">
				<div class="child_section">
					<img src="./pics/wifi.png">
					<div class="child_info">
						<p>Biblioteca noastra este echipata cu calculatoare pentru public si cu retea WiFi accesibila gratuit.</p>
					</div>
				</div>
				<div class="child_section">
					<img src="./pics/book.jpg">
					<div class="child_info">
						<p>Poti gasi la noi peste 1.000.000 de carti din peste 10 categorii. Le poti citi in oricare dintre locatiile noastre sau o poti imprumuta chiar la tine acasa!</p>
					</div>
				</div>
				<div class="child_section">
					<img src="./pics/house.png">
					<div class="child_info">
						<p>Biblioteca Nationala are 2 filiale in Bucuresti. Poti avea acces in oricare dintre ele folosind Cardul de acces gratuit sau completand un formular fizic la intrare.</p>
					</div>
				</div>
				<div class="child_section">
					<img src="./pics/info.jpg">
					<div class="child_info">
						<p>La noi poti imprumuta gratis carti, le poti consulta in salile de lectura si activitati, poti participa la evenimentele, cursurile si atelierele pe care le organizam. Toate serviciile pe care le oferim sunt gratis.</p>
					</div>
				</div>
				<div class="child_section">
					<img src="./pics/email.png">
					<div class="child_info">
						<p>Pentru noi e foarte important sa stim cum sa iti fim de folos. Ne poti scrie la exemplu@gmail.com sau poti completa formularul din pagina "Despre noi". Iti multumim pentru feedback!</p>
					</div>
				</div>
			</div>
			<br>
		</div>
	</div>

    <?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
	?>

<script src="./js/paginaprincipala.js"> </script>
<script src="./js/common.js"> </script>
</body>

</html>