<?php
    require_once './requirements/dbconnect.php';
    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();
    $_SESSION['captcha_location'] = 'borrow';

?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <link rel="stylesheet" href="./css/contulmeu.css">
    <link rel="stylesheet" href="./css/contul_meu_client.css">
    <link rel="stylesheet" href="./css/contul_meu_admin.css">
    <link rel="stylesheet" href="./css/contul_meu_bibl.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">

    <title>Contul meu</title>

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

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
<?php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
?>
            <h3 align="center">Trebuie sa fii logat ca sa accesezi aceasta pagina!</h3>
<?php
        }
        else if ($_SESSION['loggedin'] == true) {
            if (!isset($_SESSION['erroremail'])) {
                $_SESSION['erroremail'] = '';
            }
            if (!isset($_SESSION['errorname'])) {
                $_SESSION['errorname'] = '';
            }
            if (!isset($_SESSION['errorpw'])) {
                $_SESSION['errorpw'] = '';
            }
            if (!isset($_SESSION['erroraddress'])) {
                $_SESSION['erroraddress'] = '';
            }
            if (!isset($_SESSION['street'])) {
                $_SESSION['street'] = '';
            }
            if (!isset($_SESSION['number'])) {
                $_SESSION['number'] = '';
            }
            if (!isset($_SESSION['city'])) {
                $_SESSION['city'] = '';
            }
            
            if ($_SESSION['tip'] == 1) {
                $query = "SELECT COUNT(*)
                          FROM notificari
                          WHERE id_client = " . $_SESSION['id'] . 
                        " AND citit = 0";

                $res = mysqli_query($link, $query);

                $nr_notif = mysqli_fetch_array($res)[0];
            
                $_SESSION['nr_notif_client'] = $nr_notif;
            }
            else if ($_SESSION['tip'] == 2) {
                $nr_notif = 0;

                $query = "SELECT DISTINCT id_imprumut
                          FROM imprumut
                          WHERE restituit = 0
                          AND data_retur >= NOW() 
                          AND data_retur <= DATE_ADD(NOW(), INTERVAL 7 DAY)
                          GROUP BY id_client";

                $res = mysqli_query($link, $query);
                $nr_notif += mysqli_num_rows($res);

                $query = "SELECT 1
                          FROM client
                          WHERE tip = 1
                          AND taxa > 0.00";

                $res = mysqli_query($link, $query);
                $nr_notif += mysqli_num_rows($res);

                $_SESSION['nr_notif_bibl'] = $nr_notif;
            }
?>
            <div id="contulmeu_header">
                <h1 id="contulmeu">CONTUL MEU</h1>
<?php 
                if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {
?>
                    <button id="btn_imprumut"><h3>Imprumut nou</h3></button>
<?php
                }
?>
            </div> <!-- inchid contulmeu_header -->

            <div class="div_contulmeu">
                <div class="stanga">
                    <button class="setare"><h3>Date personale</h3> <img src="./pics/rarrow.png"></button>
<?php
                if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {
?>
                    <button class="setare"><h3>Imprumuturile mele</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Favorite</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Notificari (<?php echo $_SESSION['nr_notif_client']; ?>)</h3> <img src="./pics/rarrow.png"></button>
<?php 
                }
                else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 2) {
?>
                    <button class="setare"><h3>Notificari (<?php echo $_SESSION['nr_notif_bibl']; ?>)</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Cereri de imprumut</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Taxare clienti</h3> <img src="./pics/rarrow.png"></button>
<?php
                }
                else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 3) {
?>
                    <button class="setare"><h3>Introducere date in BD</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Actualizare BD</h3> <img src="./pics/rarrow.png"></button>
                    <button class="setare"><h3>Stergere date din BD</h3> <img src="./pics/rarrow.png"></button>
<?php
                }

?>
                </div> <!-- inchid stanga -->

                <div class="dreapta vizibil">
                    <div class="info first">
                        <form method="post" action="./requirements/updateinfo.php">
                            <h3>Email nou:</h3>
                            <input type="email" value="<?php echo $_SESSION['email']; ?>" id="email" name="email" class="updatedinfo">
                            <h3>Parola curenta:</h3>
                            <input type="password" value="" id="pw" name="pw" class="updatedpw" autocomplete="new-password">
                            
                            <input type="submit" value="Modifica" class="submit" name="upemail">
                        </form>

                        <form method="post" action="./requirements/updateinfo.php">
                            <h3>Nume:</h3>
                            <input type="text" value="<?php echo $_SESSION['lastname']; ?>" id="lastname" name="lastname" class="updatedinfo">
                            <h3>Prenume:</h3>
                            <input type="text" value="<?php echo $_SESSION['firstname']; ?>" id="firstname" name="firstname" class="updatedinfo">
                            
                            <input type="submit" value="Modifica" class="submit" name="upname">
                        </form>

                        <form method="post" action="./requirements/updateinfo.php">
                            <h3>Parola veche:</h3>
                            <input type="password" value="" id="oldpw" name="oldpw" class="updatedpw" autocomplete="new-password">
                            <h3>Parola noua:</h3>
                            <input type="password" value="" id="newpw1" name="newpw1" class="updatedpw" autocomplete="new-password">
                            <h3>Confirma parola noua:</h3>
                            <input type="password" value="" id="newpw2" name="newpw2" class="updatedpw" autocomplete="new-password">
                            
                            <input type="submit" value="Modifica" class="submit" name="uppw">
                        </form>

                        <form method="post" action="./requirements/updateinfo.php">
                            <label><h3>Adresa:</h3></label>

                            <h3>Strada:</h3>
                            <input type="text" value="<?php echo $_SESSION['street']; ?>" class="address" name="street" class="updatedaddress" required>
                            
                            <h3>Numar:</h3>
                            <input type="text" value="<?php echo $_SESSION['number']; ?>" class="address" name="number" class="updatedaddress" required>

                            <h3>Oras:</h3>
                            <input type="text" value="<?php echo $_SESSION['city']; ?>" class="address" name="city" class="updatedaddress" required>

<?php
       $query = "SELECT judet FROM judete ORDER BY judet";
       $res = mysqli_query($link, $query);
?>
    
                            <select name="county" id="judete" required>
                                <option value="0">--Alege--</option>
<?php
                            while($row = mysqli_fetch_array($res)) {
?>
                                <option value="<?php echo $row[0]; ?>"> <?php echo $row[0]; ?> </option>
<?php
                            }
?>
                            </select>
    
                            <input type="submit" value="Modifica" class="submit" name="upaddress">
                        </form>

                        <p style="color: red; margin-top: 3pc; font-weight: bolder; font-size: 120%;">
<?php 
                            echo $_SESSION['erroremail']; $_SESSION['erroremail']='';
                            echo $_SESSION['errorname']; $_SESSION['errorname']='';
                            echo $_SESSION['errorpw']; $_SESSION['errorpw']='';
                            echo $_SESSION['erroraddress']; $_SESSION['erroraddress']='';
?>
                        </p>

                        <br><br><br>

                        <form action="./requirements/updateinfo.php" method="post">
                            <div id="div_stergere">   
                                <h3>Dezactivare cont</h3>
                                <input type="button" name="delete" value="Sterge cont" class="submit" id="stergere">
                            </div>
                        </form>

                    </div> <!--inchid "info first" -->
                </div> <!-- inchid div-ul "dreapta vizibil" -->

<?php
                if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {    
                    include ('./requirements/account_types/contul_meu_1.php');
                }
                else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 2) {
                    include ('./requirements/account_types/contul_meu_2.php');
                }
                else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 3) {
                    include ('./requirements/account_types/contul_meu_3.php');
                }
?>

            </div> <!-- inchid div-ul "div_contulmeu" -->
          
<?php
        } // end if ($_SESSION['loggedin'] == true)
?>
        </div> <!--inchid "continut" -->
    </div> <!-- inchid "corp" -->

<?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
?>

<?php
    if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {
?>
        <script src="./js/contulmeu_client.js"> </script>
        <script src="./js/contulmeu.js"> </script>
<?php
    }
    else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 2) {
?>
        <script src="./js/contulmeu_bibl.js"> </script>
        <script src="./js/contulmeu.js"> </script>
<?php
    }
    else if (isset($_SESSION['tip']) && $_SESSION['tip'] == 3) {
?>
        <script src="./js/contulmeu_admin.js"> </script>
        <script src="./js/contulmeu.js"> </script>
<?php
    }
?>
    <script src="./js/common.js"> </script>

</body>
</html>