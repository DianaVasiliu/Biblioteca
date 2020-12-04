<?php
    require_once './requirements/dbconnect.php';
    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();
    $_SESSION['changed_page'] = '';
    
    // if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    //     header("location: paginaprincipala.php");
    // }
    // else if ($_SESSION['loggedin'] == true) {
    //     header("location: contulmeu.php");
    // }
?>



<!DOCTYPE html>
<html lang="ro">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <link rel="stylesheet" href="./css/contulmeu.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">


    <title>Contul meu</title>
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
            <?php
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
            ?>
                <h3 align="center">Trebuie sa fii logat ca sa accesezi aceasta pagina!</h3>
            <?php
                }
                else if ($_SESSION['loggedin'] == true){
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
            ?>
            <h1>CONTUL MEU</h1>

            <div class="div_contulmeu">
                    <div class="stanga">
                        <button class="setare"><h3>Date personale</h3> <img src="./pics/rarrow.png"></button>
<?php
                if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {
?>
                        <button class="setare"><h3>Imprumuturile mele</h3> <img src="./pics/rarrow.png"></button>
                        <button class="setare"><h3>Favorite</h3> <img src="./pics/rarrow.png"></button>
                        <button class="setare"><h3>Notificari</h3> <img src="./pics/rarrow.png"></button>
<?php 
                } 

?>
                    </div>
                    <div class="dreapta vizibil">
                        <div class="info first">
<form method="post" action="./requirements/updateinfo.php">
    <h3>Email:</h3>
    <input type="email" value="<?php echo $_SESSION['email']; ?>" id="email" name="email" class="updatedinfo">
    <h3>Parola:</h3>
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

       $sql = "SELECT judet FROM judete ORDER BY judet";
       $res = mysqli_query($link, $sql);

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
                        </div>
                    </div> <!-- inchid div-ul "dreapta" -->

<?php
                if (isset($_SESSION['tip']) && $_SESSION['tip'] == 1) {
?>

                    <div class="dreapta">
                        <div class="info">
 <?php
    $query = "SELECT titlu, prenume, nume, categorie, url_fisier, COUNT(id_imprumut)
                FROM carte c JOIN carte_autor ca USING (id_carte)
                JOIN autor a USING (id_autor)
                JOIN categorie cat USING (id_categorie)
                JOIN imprumut i USING (id_carte)
                WHERE id_client = " . $_SESSION['id'] . " GROUP BY titlu;";

    if($res = mysqli_query($link, $query)) {
        $titlu = array();
        $autor = array();
        $categorie = array();
        $url = array();
        $imprumuturi = array();

        while ($row = mysqli_fetch_array($res)) {
            array_push($titlu, $row[0]);
            array_push($autor, $row[1] . ' ' . $row[2]);
            array_push($categorie, $row[3]);
            array_push($url, $row[4]);
            array_push($imprumuturi, $row[5]);
        }

?>

        <div id="imprumuturi" style="overflow:auto;"> 
            <table>
            <?php
                for ($i = 0; $i < count($titlu); $i++) {
                    if ($i % 4 == 0) {
            ?>  
                    </tr>
                    <tr>
            <?php
                    }    
            ?>
                    <td>
                        <img src="./pics/<?php echo $url[$i]; ?>" class="cartiimprumutate">
                    <br>
            <?php
                    echo '"'.$titlu[$i] . '" - ' . $autor[$i];
            ?>
                    <br>
            <?php
                    echo 'Categorie: ' . $categorie[$i];
            ?>
                    <br>
            <?php
                    echo 'Numarul de imprumuturi: ' . $imprumuturi[$i];
            ?>
                    <br>
            <?php

            ?>
                    </td>
            <?php                
                }
            ?>

            </table>
        </div>


<?php
    }
    else {
        $_SESSION['err'] = 'Something went wrong. Please try again later.';
    }


?>                           
                        </div>

                    </div>

                    <div class="dreapta">
                    <div class="info">
 <?php
    $query = "SELECT titlu, categorie, url_fisier, id_carte
                FROM carte JOIN carte_autor USING (id_carte)
                JOIN autor USING (id_autor)
                JOIN categorie USING (id_categorie)
                JOIN user_favourites USING (id_carte)
                WHERE id_client = " . $_SESSION['id'] . " GROUP BY titlu ORDER BY titlu;";

    if($res = mysqli_query($link, $query)) {
        $titlu = array();
        $categorie = array();
        $url = array();
        $imprumuturi = array();
        $ids = array();
        $favs = array();

        while ($row = mysqli_fetch_array($res)) {
            array_push($titlu, $row[0]);
            array_push($categorie, $row[1]);
            array_push($url, $row[2]);
            array_push($ids, $row[3]);
        }
        
        $query = "SELECT id_carte FROM user_favourites WHERE id_client=" . $_SESSION['id'];

        $res = mysqli_query($link, $query);

        while($row = mysqli_fetch_array($res)) {
            array_push($favs, $row[0]);
        }
        
?>

        <div id="favorite" style="overflow:auto;"> 
            <table>
            <?php
                for ($i = 0; $i < count($titlu); $i++) {
                    
                    $autor = array();
                    
                    $query2 = "SELECT prenume, nume FROM autor JOIN carte_autor USING (id_autor) JOIN carte USING (id_carte) WHERE id_carte=" . $ids[$i];

                    $res = mysqli_query($link, $query2);

                    while($row = mysqli_fetch_array($res)) {
                        array_push($autor, $row[0] . ' ' . $row[1]);
                    }

                    if ($i % 4 == 0) {
            ?>  
                    </tr>
                    <tr>
            <?php
                    }    
            ?>
                    <td>
                        <img src="./pics/<?php echo $url[$i]; ?>" class="cartiimprumutate">
                    <br>
            <?php
                    echo '"'.$titlu[$i] . '" - ';
                    for ($j = 0; $j < count($autor); $j++) {
                        echo $autor[$j];
                        if ($j < count($autor) - 1) {
                            echo ', ';
                        }
                    }
            ?>
                    <br>
            <?php
                    echo 'Categorie: ' . $categorie[$i];
            ?>
                    <br>
            <?php

            ?>
                    
                    <form method="post" action="./requirements/add_to_favs.php">
                        <input type="submit" name="favs<?php echo $ids[$i];?>" value="<?php
                            if (in_array($ids[$i], $favs)) {
                                echo 'Elimina de la favorite';
                                $_SESSION['infavs'][$ids[$i]] = 1;    // este in favorite
                                $_SESSION['favslocation'] = "contulmeu";
                            }
                            else {
                                echo 'Adauga la favorite';
                                $_SESSION['infavs'][$ids[$i]] = 0;    // nu este in favorite
                                $_SESSION['favslocation'] = "contulmeu";
                            }
                        ?>" class="accountfavs" id="accfavs<?php echo $ids[$i]; ?>">
                    </form>
                    </td>
            <?php             
                       
                }
            ?>
            
            </table>
        </div>


<?php
    }
    else {
        $_SESSION['err'] = 'Something went wrong. Please try again later.';
    }


?>                           
                        </div>
                    </div>
                    <div class="dreapta">
<?php 
    } 

?>
                    </div>
                    

            </div> <!-- inchid div-ul "div_contulmeu" -->
            
            <?php
                }
            ?>

        </div>
    </div>


    <?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
    ?>

<script src="./js/contulmeu.js"> </script>
<script src="./js/common.js"> </script>
</body>

</html>