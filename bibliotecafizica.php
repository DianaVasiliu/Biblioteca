<?php
    require_once './requirements/dbconnect.php';
    require './requirements/functions.php';

    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    // trebuie sa fac sa tina minte filtrele
    if (!isset($_SESSION['filters'])) {
        $_SESSION['filters'] = array();
    }
    if (!isset($_SESSION['order_by'])) {
        $_SESSION['order_by'] = 8;
    }

    if (!isset($_POST['sort'])) {
        // $_SESSION['order_by'] = 8;
    }
    else {
        switch($_POST['sortselect']) {
            case 'titlu':
                $_SESSION['order_by'] = 1;
                break;
            case 'categorie':
                $_SESSION['order_by'] = 2;
                break;
            case 'an':
                $_SESSION['order_by'] = 6;
                break;
            case 'editura':
                $_SESSION['order_by'] = 7;
                break;
            case 'autor':
                $_SESSION['order_by'] = 9;
                break;
            case 'rating':
                $_SESSION['order_by'] = 10;
                break;
            default:
                $_SESSION['order_by'] = 8;
        }
    }

    if (!isset($_SESSION['order_by'])) {
        $_SESSION['order_by'] = 8;
    }
    
    if (isset($_POST['resetfilters'])) {
        $_SESSION['filters'] = array();
    }

    if (isset($_POST['cauta'])) {

        $autorfilter = verify_filter("autor");
        $catfilter = verify_filter("categorie");
        $anfilter = verify_filter("an");
        $editurafilter = verify_filter("editura");

        $query = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte, nume
                  FROM carte 
                  JOIN categorie USING (id_categorie) 
                  JOIN carte_autor USING (id_carte) 
                  JOIN autor USING (id_autor)
                  WHERE tip='fizica'";

        if (!empty($autorfilter)) {
            $query = $query . " AND BINARY CONCAT(prenume, ' ', nume) IN " . $autorfilter;
        }
        if (!empty($catfilter)) {
            $query = $query . " AND BINARY categorie IN " . $catfilter;
        }
        if (!empty($anfilter)) {
            $query = $query . " AND an IN " . $anfilter;
        }
        if (!empty($editurafilter)) {
            $query = $query . " AND BINARY editura IN " . $editurafilter;
        }
        
        $query = $query . " GROUP BY titlu ORDER BY " . $_SESSION['order_by'];

        $_SESSION['query'] = $query;
    }
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
    <link rel="stylesheet" href="./css/bibliotecafizica.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/mobile_menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <div id="search">
        
        <input type="text" id="searchbooks" placeholder="Cauta o carte">

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Sorteaza rezultatele dupa:
            <select name="sortselect" id="sortselect" class="sort">
                <option value="original">Original</option>
                <option value="titlu">Titlu</option>
                <option value="autor">Autor</option>
                <option value="categorie">Categorie</option>
                <option value="an">Anul publicarii</option>
                <option value="editura">Editura</option>
                <option value="rating">Rating</option>
            </select>
            <input type="submit" name="sort" value="Sorteaza" class="sort" id="sort">
        </form>
    </div>

    <div id="continut">

        <div id="div_filtre">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="submit" name="resetfilters" value="Sterge filtrele" class="cauta" style="width: auto;">
            </form>
<?php
            include ('./requirements/filtre_bibl_fizica.php');
?>
        </div> <!-- end div_filtre -->

        <div id="div_carti">
<?php

            if (!isset($_POST['cauta'])) {
                $query = "SELECT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte, prenume, nota
                          FROM carte 
                          JOIN categorie USING (id_categorie) 
                          JOIN carte_autor USING (id_carte) 
                          JOIN autor USING (id_autor)
                          WHERE tip='fizica' 
                          GROUP BY titlu 
                          ORDER BY " . $_SESSION['order_by'];
                
                if ($_SESSION['order_by'] == 10) {
                    $query = $query . " DESC";
                }
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

                if (isset($_SESSION['id']) && $_SESSION['tip'] == 1) {
                    $query = "SELECT id_carte 
                              FROM user_favourites 
                              WHERE id_client=" . $_SESSION['id'];

                    $res = mysqli_query($link, $query);

                    while($row = mysqli_fetch_array($res)) {
                        array_push($favs, $row[0]);
                    }
                }
?>
            <div id="carti"> 
                <table>
<?php
                    $_SESSION['books'] = $ids;
                    $_SESSION['infavs'] = $ids;

                    for ($i = 0; $i < count($titlu); $i++) {
                        $autor = array();
                        
                        $query = "SELECT nume, prenume
                                  FROM autor 
                                  JOIN carte_autor USING (id_autor)
                                  JOIN carte USING (id_carte)
                                  WHERE id_carte = " . $ids[$i];
                        
                        if ($res = mysqli_query($link, $query)) {
                            while ($row = mysqli_fetch_array($res)) {
                                array_push($autor, $row[1] . ' ' . $row[0]);
                            }
                        }
                        if (isset($_SESSION['id'])) {
                            if ($i % 3 == 0) {
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
                        <td class="tabledata">
                            <div class="div_imagine">
                                <img src="./pics/<?php echo $url[$i]; ?>" class="carti">
                            </div>
                            <br>
<?php
                        if (isset($_SESSION['id'])) {
?>
                            <div class="favsform">
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
                            </div> <!-- inchid "favsform" -->

                            <br>

                            <div class="rating" id="rating_div">
                                <div class="star-rating">
                                    <form class="ratingform" action="./requirements/rating.php" method="post">
                                        <span class="fa fa-star starno1<?php echo $ids[$i]; ?>" data-rating="1" style="font-size:20px;"></span>
                                        <span class="fa fa-star starno2<?php echo $ids[$i]; ?>" data-rating="2" style="font-size:20px;"></span>
                                        <span class="fa fa-star starno3<?php echo $ids[$i]; ?>" data-rating="3" style="font-size:20px;"></span>
                                        <span class="fa fa-star starno4<?php echo $ids[$i]; ?>" data-rating="4" style="font-size:20px;"></span>
                                        <span class="fa fa-star starno5<?php echo $ids[$i]; ?>" data-rating="5" style="font-size:20px;"></span>
                                        <br>
                                        <input type="hidden" name="rating<?php echo $ids[$i]; ?>" class="rating-value">
                                        <input type="submit" class="rate" value="Trimite nota">
                                        
                                    </form>
                                </div> <!-- inchid "star-rating" -->
                                <div>
                                    <span class="title">Rating:</span>
<?php
                                    $query = "SELECT nota
                                            FROM carte
                                            WHERE id_carte = " . $ids[$i];
                                    
                                    $nota = 0;
                                    $res = mysqli_query($link, $query);
                                    while ($row = mysqli_fetch_array($res)) {
                                        $nota = $row[0];
                                    }

                                    echo $nota ? $nota : "unknown";
?>
                                </div> <!-- inchid "noname" -->
                                <div>
                                    <span class="title">Numar de rating-uri:</span>
<?php
                                    $query = "SELECT COUNT(*)
                                                FROM reviews
                                                WHERE id_carte = " . $ids[$i];
                                    
                                    $nr = 0;
                                    $res = mysqli_query($link, $query);
                                    while ($row = mysqli_fetch_array($res)) {
                                        $nr = $row[0];
                                    }

                                    echo $nr;
?>                        
                                </div> <!-- inchid "noname" -->
                                <div>
                                    <span class="title">Rating-ul tau:</span>
<?php
                                    $query = "SELECT nota
                                                FROM reviews
                                                WHERE id_carte = " . $ids[$i] .
                                            " AND id_client = " . $_SESSION['id'];
                                    
                                    $nr = 0;
                                    $res = mysqli_query($link, $query);
                                    while ($row = mysqli_fetch_array($res)) {
                                        $nr = $row[0];
                                    }

                                    if ($nr == 0) {
                                        echo 'Nu ai oferit inca un rating!';
                                    }
                                    else {
                                        echo $nr;
                                    }
?>                        
                                </div> <!-- inchid "noname" -->

                            </div> <!-- inchid "rating" -->
<?php 
                        }
?>
                            <br><br>
                            <div class="pcenter">
                                <p class="paragraphs center booktitle">
<?php
                                    echo '"'.$titlu[$i] . '" - ';
                                    for ($j = 0; $j < count($autor); $j++) {
                                        echo $autor[$j];
                                        if ($j < count($autor) - 1) {
                                            echo ', ';
                                        }
                                    }
?>
                                </p>
                                <p></p>
                                <p class="paragraphs center"><span class="title">Categorie:</span>
<?php
                                    echo $categorie[$i];
?>
                                </p>
                                <p class="paragraphs center"><span class="title">Anul publicarii:</span>
<?php
                                    echo $an[$i];
?>
                                </p>
                                <p class="paragraphs center"><span class="title">Editura:</span>
<?php
                                    echo $editura[$i];
?>
                                </p>
                            </div> <!-- inchid "pcenter" -->
                            <br><br>
<?php
                            if (isset($_SESSION['id'])) {
?>
                            <p class="paragraphs">
<?php
                                echo $descriere[$i];
?>
                            </p>
                            <p class="paragraphs center"><span class="title">Stoc:</span>
<?php
                                echo $stoc[$i];
?>
                            </p>
<?php
                            }
?>  
                        </td>
<?php                
                    }
?>
                </table>

<?php 
            }
?>
            </div> <!-- inchid "carti" -->

        </div> <!-- inchid "div_carti" -->
    </div> <!-- inchid "continut" -->
</div> <!-- inchid "corp" -->


<?php 
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/Proiect/"; 
    include ($IPATH."requirements/footer.php"); 
?>

    <script src="./js/rating.js"></script>
    <script src="./js/bibliotecafizica.js"></script>
    <script src="./js/common.js"></script>

</body>
</html>