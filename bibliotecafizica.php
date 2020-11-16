<?php
    require_once './requirements/dbconnect.php';
    $link = connectdb();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/bibliotecafizica.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">


    <title>Biblioteca fizica</title>
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
    <div id="div_filtre">
        <div class="filtru">
            <form method="post" action="./requirements/filter.php">
            <div class="header">
                <h3>Autor</h3>
                <input type="submit" name="sautor" value="Cauta" class="cauta">
            </div>
            </form>
            <div class="options">
            <?php
                $query = "SELECT prenume, nume FROM autor";
                $res = mysqli_query($link, $query);

                $checkbox = array();
                while ($row = mysqli_fetch_array($res)) {
                    array_push($checkbox, $row[0] . ' ' . $row[1]);
                }

                for ($i = 0; $i < count($checkbox); $i++) {
            ?>
                <input type="checkbox" name="autor<?php echo $i+1; ?>">
                <label for="autor<?php echo $i+1; ?>">
                <?php echo $checkbox[$i];
                ?>
                </label>  <br>
            <?php
                }
            ?>
            </div>      <!-- end options -->
        </div><!-- end filtru -->
                <br>
        <div class="filtru">
            <form method="post" action="./requirements/filter.php">
            <div class="header">
                <h3>Categorie</h3>
                <input type="submit" name="scategorie" value="Cauta" class="cauta">
            </div>
            </form>
            <div class="options">
<?php
    $query = "SELECT categorie FROM categorie";
    $res = mysqli_query($link, $query);

    $checkbox = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="categorie<?php echo $i+1; ?>">
        <label for="categorie<?php echo $i+1; ?>">
        <?php echo $checkbox[$i];
        ?>
        </label>  <br>
    <?php
        }
    ?>
            </div><!-- end options -->
        </div><!-- end filtru -->

        <br>
    <div class="filtru">
        <form method="post" action="./requirements/filter.php">
        <div class="header">
            <h3>Anul publicarii</h3>
            <input type="submit" name="san" value="Cauta" class="cauta">
        </div>
        </form>

        <div class="options">
<?php
    $query = "SELECT DISTINCT an FROM carte WHERE tip='fizica' ORDER BY an";
    $res = mysqli_query($link, $query);

    $checkbox = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="an<?php echo $i+1; ?>">
        <label for="an<?php echo $i+1; ?>">
        <?php echo $checkbox[$i];
        ?>
        </label>  <br>
    <?php
        }
    ?>
        
        </div><!-- end options -->
    </div><!-- end filtru -->
        <br>

    <div class="filtru">
        <form method="post" action="./requirements/filter.php">
        <div class="header">
            <h3>Editura</h3>
            <input type="submit" name="seditura" value="Cauta" class="cauta">
        </div>
        </form>

        <div class="options">
<?php
    $query = "SELECT DISTINCT editura FROM carte WHERE tip='fizica' ORDER BY editura";
    $res = mysqli_query($link, $query);

    $checkbox = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="editura<?php echo $i+1; ?>">
        <label for="editura<?php echo $i+1; ?>">
        <?php echo $checkbox[$i];
        ?>
        </label>  <br>
    <?php
        }
    ?>
        
        </div><!-- end options -->
    </div><!-- end filtru -->
        <br>

    </div> <!-- end div_filtre -->

    <div id="div_carti">
<?php
        $query = "SELECT titlu, categorie, prenume, nume, descriere, stoc, url_fisier, an, editura, id_carte
                   FROM carte JOIN categorie USING (id_categorie) 
                   JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
                   WHERE tip='fizica'";
        
        $titlu = array();
        $autor = array();
        $categorie = array();
        $descriere = array();
        $stoc = array();
        $url = array();
        $an = array();
        $editura = array();
        $ids = array();
        $favs = array();

        $res = mysqli_query($link, $query);

        while($row = mysqli_fetch_array($res)) {
            array_push($titlu, $row[0]);
            array_push($categorie, $row[1]);
            array_push($autor, $row[2] . ' ' . $row[3]);
            array_push($descriere, $row[4]);
            array_push($stoc, $row[5]);
            array_push($url, $row[6]);
            array_push($an, $row[7]);
            array_push($editura, $row[8]);
            array_push($ids, $row[9]);
        }

        $query = "SELECT id_carte FROM user_favourites WHERE id_client=" . $_SESSION['id'];

        $res = mysqli_query($link, $query);

        while($row = mysqli_fetch_array($res)) {
            array_push($favs, $row[0]);
        }
?>
        
        <table>
        <div id="carti" style="overflow-x:auto;"> 
            <table>
            <?php
                $_SESSION['books'] = $ids;
                $_SESSION['infavs'] = $ids;
                //if (!isset($_SESSION['errfavs'])) {
                    $_SESSION['errfavs'] = '';
                //}
                for ($i = 0; $i < count($titlu); $i++) {

                    if ($i % 2 == 0) {
                        if ($i != 0) {
            ?>  
                    </tr>
            <?php 
                        }
            ?>
                    <tr>
            <?php
                    }
            ?>
                    <td>
                    <div class="div_imagine">
                        <img src="./pics/<?php echo $url[$i]; ?>" class="carti">
                        <form method="post" action="./requirements/add_to_favs.php">
                            <input type="submit" name="favs<?php echo $ids[$i];?>" value="<?php
                                if (in_array($ids[$i], $favs)) {
                                    echo 'Elimina de la favorite ' . $_SESSION['errfavs'];
                                    $_SESSION['infavs'][$ids[$i]] = 1;    // este in favorite
                                }
                                else {
                                    echo 'Adauga la favorite '. $_SESSION['errfavs'];
                                    $_SESSION['infavs'][$ids[$i]] = 0;    // nu este in favorite
                                }
                            ?>" class="favs" id="favs<?php echo $ids[$i]; ?>">
                        </form>
                    </div>
                    <br><br>
            <?php
                    echo '"'.$titlu[$i] . '" - ' . $autor[$i];
            ?>
                    <br><br>
            <?php
                    echo 'Categorie: ' . $categorie[$i];
            ?>
                    <br><br>
            <?php
                    echo 'Anul publicarii: ' . $an[$i];
            ?>
                    <br><br>
            <?php
                    echo 'Editura: ' . $editura[$i];
            ?>
                    <br><br>
            <?php
                    echo $descriere[$i];
            ?>
                    <br><br>
            <?php
                echo 'Stoc: ' . $stoc[$i];
            ?>
                    </td>
            <?php                
                }
            ?>
            
            </table>
        </div>

</div>
</div>


    <?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
    ?>

<script src="./js/common.js"> </script>
</body>

</html>