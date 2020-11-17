<?php
    require_once './requirements/dbconnect.php';
    require './requirements/functions.php';
    $link = connectdb();

    session_start();
    $_SESSION['filters'] = array();
    
    if (isset($_POST['resetfitlers'])) {
        $_SESSION['filters'] = array();
    }

    if (isset($_POST['cauta'])) {
        // echo $_SESSION['nrautorfiltru'] . '<br>';
        // echo $_SESSION['nrcategoriefiltru'] . '<br>';
        // echo $_SESSION['nranfiltru'] . '<br>';
        // echo $_SESSION['nrediturafiltru'] . '<br>';
        

        $autorfilter = verify_filter("autor");
        $catfilter = verify_filter("categorie");
        $anfilter = verify_filter("an");
        $editurafilter = verify_filter("editura");

        // echo $autorfilter . "<br>";
        // echo $catfilter . "<br>";
        // echo $anfilter . "<br>";
        // echo $editurafilter . "<br>";

        $query1 = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte
                    FROM carte JOIN categorie USING (id_categorie) 
                    JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
                    WHERE tip='fizica'";
        if (!empty($autorfilter)) {
            $query1 = $query1 . " AND CONCAT(prenume, ' ', nume) IN " . $autorfilter;
        }
        if (!empty($catfilter)) {
            $query1 = $query1 . " AND categorie IN " . $catfilter;
        }
        if (!empty($anfilter)) {
            $query1 = $query1 . " AND an IN " . $anfilter;
        }
        if (!empty($editurafilter)) {
            $query1 = $query1 . " AND editura IN " . $editurafilter;
        }
        
        $query1 = $query1 . " GROUP BY titlu ORDER BY id_carte";

        // echo $query1;
        $_SESSION['query'] = $query1;

        // echo "<br><br>" . $_SESSION['query'];
    }
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="resetfilters" value="Sterge filtrele" class="cauta" style="width: auto;">
    </form>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="filtru">
            <div class="header">
                <h3>Autor</h3>
            </div>
            <div class="options">
            <?php
                $query = "SELECT prenume, nume FROM autor";
                $res = mysqli_query($link, $query);

                $checkbox = array();
                while ($row = mysqli_fetch_array($res)) {
                    array_push($checkbox, $row[0] . ' ' . $row[1]);
                }

                //$_SESSION['nrautorfiltru'] = count($checkbox);

                for ($i = 0; $i < count($checkbox); $i++) {
            ?>
                <input type="checkbox" name="autor[]" value="<?php echo $checkbox[$i]; ?>"
            <?php
                echo check_filters($checkbox[$i]);
            ?>     
                >
                <label for="autor[]">
                <?php echo $checkbox[$i]; ?>
                </label>  <br>
            <?php
                }
            ?>
            </div>      <!-- end options -->
        </div><!-- end filtru -->
        
                <br>
        <div class="filtru">
            <div class="header">
                <h3>Categorie</h3>
            </div>
            <div class="options">
<?php
    $query = "SELECT categorie FROM categorie";
    $res = mysqli_query($link, $query);

    $checkbox = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }

    //$_SESSION['nrcategoriefiltru'] = count($checkbox);

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="categorie[]" value="<?php echo $checkbox[$i]; ?>"
            <?php
                echo check_filters($checkbox[$i]);
            ?> >
        <label for="categorie[]">
        <?php echo $checkbox[$i]; ?>
        </label>  <br>
    <?php
        }
    ?>
            </div><!-- end options -->
        </div><!-- end filtru -->

        <br>
    <div class="filtru">
        <div class="header">
            <h3>Anul publicarii</h3>
        </div>

        <div class="options">
<?php
    $query = "SELECT DISTINCT an FROM carte WHERE tip='fizica' ORDER BY an";
    $res = mysqli_query($link, $query);

    $checkbox = array();
    
    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }

    $_SESSION['nranfiltru'] = count($checkbox);

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="an[]" value="<?php echo $checkbox[$i];?>"
        <?php
            echo check_filters($checkbox[$i]);
        ?> >
        <label for="an[]">
        <?php echo $checkbox[$i];?>
        </label>  <br>
    <?php
        }
    ?>
        
        </div><!-- end options -->
    </div><!-- end filtru -->
        <br>

    <div class="filtru">
        <div class="header">
            <h3>Editura</h3>
        </div>

        <div class="options">
<?php
    $query = "SELECT DISTINCT editura FROM carte WHERE tip='fizica' ORDER BY editura";
    $res = mysqli_query($link, $query);

    $checkbox = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($checkbox, $row[0]);
    }
    
    $_SESSION['nrediturafiltru'] = count($checkbox);

    for ($i = 0; $i < count($checkbox); $i++) {
        ?>
        <input type="checkbox" name="editura[]" value="<?php echo $checkbox[$i]; ?>"
        <?php
            echo check_filters($checkbox[$i]);
        ?> 
        >
        <label for="editura[]">
        <?php echo $checkbox[$i]; ?>
        </label>  <br>
    <?php
        }
    ?>
        
        </div><!-- end options -->
    </div><!-- end filtru -->
        <br>
        <input type="submit" name="cauta" value="Cauta" class="cauta">
    </form>
    </div> <!-- end div_filtre -->

    <div id="div_carti">
<?php

        if (!isset($_POST['cauta'])) {
            $query = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte
                    FROM carte JOIN categorie USING (id_categorie) 
                    JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
                    WHERE tip='fizica' GROUP BY titlu ORDER BY id_carte";
        }
        else {
            $query = $_SESSION['query'];
        }        

        $res = mysqli_query($link, $query);
        if (mysqli_num_rows($res) == 0) {
    ?>
            <h3 style="text-align: center;"> Ne pare rau, nu exista rezultate! </h3>
    <?php
        }
        else {
        
        $titlu = array();
        $categorie = array();
        $descriere = array();
        $stoc = array();
        $url = array();
        $an = array();
        $editura = array();
        $ids = array();
        $favs = array();

        if ($res) {

            while($row = mysqli_fetch_array($res)) {
                array_push($titlu, $row[0]);
                array_push($categorie, $row[1]);
                array_push($descriere, $row[2]);
                array_push($stoc, $row[3]);
                array_push($url, $row[4]);
                array_push($an, $row[5]);
                array_push($editura, $row[6]);
                array_push($ids, $row[7]);
            }
        }
        else {
            echo 'Error: ' . mysqli_error($link);
        }

        if (isset($_SESSION['id'])) {
            $query = "SELECT id_carte FROM user_favourites WHERE id_client=" . $_SESSION['id'];

            $res = mysqli_query($link, $query);

            while($row = mysqli_fetch_array($res)) {
                array_push($favs, $row[0]);
            }
        }

        
?>
        
        <table>
        <div id="carti" style="overflow-x:auto;"> 
            <table>
            <?php
                $_SESSION['books'] = $ids;
                $_SESSION['infavs'] = $ids;
                for ($i = 0; $i < count($titlu); $i++) {
                    $autor = array();
                    
                    $query2 = "SELECT nume, prenume
                                FROM autor JOIN carte_autor USING (id_autor)
                                JOIN carte USING (id_carte)
                                WHERE id_carte =" . $ids[$i];
                    
                    if ($res = mysqli_query($link, $query2)) {
                        while ($row = mysqli_fetch_array($res)) {
                            array_push($autor, $row[1] . ' ' . $row[0]);
                        }
                    }
                    if (isset($_SESSION['id'])) {
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
                    }
                    else {
                        if ($i % 4 == 0) {
                            if ($i != 0) {
            ?>  
                    </tr>
            <?php 
                            }
            ?>
                    <tr>
            <?php
                        }
                    }
            ?>
                    <td>
                    <div class="div_imagine">
                        <img src="./pics/<?php echo $url[$i]; ?>" class="carti">
                    <?php
                        if (isset($_SESSION['id'])) {
                    ?>
                        <form method="post" action="./requirements/add_to_favs.php">
                            <input type="submit" name="favs<?php echo $ids[$i];?>" value="<?php
                                if (in_array($ids[$i], $favs)) {
                                    echo 'Elimina de la favorite';
                                    $_SESSION['infavs'][$ids[$i]] = 1;    // este in favorite
                                    $_SESSION['favslocation'] = "biblioteca";
                                }
                                else {
                                    echo 'Adauga la favorite';
                                    $_SESSION['infavs'][$ids[$i]] = 0;    // nu este in favorite
                                    $_SESSION['favslocation'] = "biblitoeca";
                                }
                            ?>" class="favs" id="favs<?php echo $ids[$i]; ?>">
                        </form>
                    <?php } ?>
                    </div>
                    <br><br>
            <?php
                    echo '"'.$titlu[$i] . '" - ';
                    for ($j = 0; $j < count($autor); $j++) {
                        echo $autor[$j];
                        if ($j < count($autor) - 1) {
                            echo ', ';
                        }
                    }
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
                    if (isset($_SESSION['id'])) { 
                        echo $descriere[$i];
            ?>
                    <br><br>
            <?php
                    
                echo 'Stoc: ' . $stoc[$i];}
            ?>
                    </td>
            <?php                
                }
            ?>
            
            </table>

    <?php 
        }
    ?>
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