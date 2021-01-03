<div class="dreapta">   <!-- imprumuturi -->
    <div class="info">

<?php

    $query = "SELECT titlu, prenume, nume, categorie, url_fisier, COUNT(DISTINCT id_imprumut)
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
                    <br><br>
<?php
                    echo 'Categorie: ' . $categorie[$i];
?>
                    <br>
<?php
                    echo 'Numarul de imprumuturi: ' . $imprumuturi[$i];
?>
                    <br>
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

<div class="dreapta"> <!-- favorite -->
    <div class="info">

<?php

    $query = "SELECT DISTINCT titlu, categorie, descriere, stoc, url_fisier, an, editura, id_carte, prenume, nota
                FROM carte 
                JOIN categorie USING (id_categorie) 
                JOIN carte_autor USING (id_carte) 
                JOIN autor USING (id_autor)
                WHERE tip='fizica' 
                GROUP BY titlu";

    $res = mysqli_query($link, $query);
    $ids = array();
    while ($row = mysqli_fetch_array($res)) {
        array_push($ids, $row[7]);
    }

    $_SESSION['books'] = $ids;
    $_SESSION['infavs'] = $ids;   

    for ($i = 0; $i < count($ids); $i++) {
        $_SESSION['infavs'][$ids[$i]] = 0;
    }


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
                    
                    $query2 = "SELECT prenume, nume 
                                FROM autor 
                                JOIN carte_autor USING (id_autor) 
                                JOIN carte USING (id_carte) 
                                WHERE id_carte=" . $ids[$i];

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
                        <br><br>
<?php
                        echo 'Categorie: ' . $categorie[$i];
?>
                        <br>
            
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

<div class="dreapta">    <!-- notificari -->
    <div class="info">
<?php
        $query = "SET lc_time_names = 'ro_RO'";
        $res = mysqli_query($link, $query);
        
        $query = "SELECT descriere, data_creere, DATE_FORMAT(data_creere, '%d %M %Y, %H:%i'), id_notificare
                  FROM notificari
                  WHERE id_client = " . $_SESSION['id'] . 
                " AND citit = 0
                  ORDER BY data_creere DESC";

        $res = mysqli_query($link, $query);

        $desc = array();
        $data = array();
        $data_format = array();
        $id_notif = array();

        while ($row = mysqli_fetch_array($res)) {
            array_push($desc, $row[0]);
            array_push($data, $row[1]);
            array_push($data_format, $row[2]);
            array_push($id_notif, $row[3]);
        }

        $_SESSION['id_notif'] = $id_notif;

        if ($_SESSION['nr_notif_client'] == 0) {
?>
            <div class="mark_as_read_header">
                Nu ai notificari!
            </div>
<?php
        }
        else {
?>
        <div class="mark_as_read_header">
            <div id="divdescriere">
                Descriere
            </div>
            <div id="divdata">
                Data
            </div>
        </div>
        <ol> 
<?php
        for ($i = 0; $i < count($desc); $i++) {
?>
        <div class="mark_as_read_div">
            <div class="notif_div">
<?php
            echo $desc[$i];
?>
            </div>
            <div class="notif_div data">
<?php
            echo $data_format[$i];
?>
            </div>
            <form action="./requirements/client/mark_as_read.php" method="post">
                <input type="submit" name="mark_as_read<?php echo $id_notif[$i]; ?>" value="Marcheaza ca citit" class="client_submit">
            </form>
        </div>
<?php
        }
?>
        </ol>
<?php
    }
?>
    </div>
</div>


<div class="dreapta centrat">  <!-- formular imprumut -->
    <div id="div_form_imprumut">
        <form method="post" action="./requirements/new_borrow_request.php" id="form_imprumut" class="form_imprumut">
            <h3>Selecteaza cartea pe care vrei sa o imprumuti:</h3>

            <input type="button" value="+" class="submit" id="adaugare_titlu">

            <select name="carte1" id="select_carte" class="select_carte">
                <option value="0">--Alege--</option>

<?php
            $query = "SELECT DISTINCT titlu, id_carte 
                      FROM carte 
                      WHERE tip='fizica' 
                      AND stoc >= 1 
                      ORDER BY titlu";

            $res = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($res)) {
?>
                <option value="<?php echo $row[1] ?>">
<?php
                echo $row[0];
?>
                </option>
<?php
            }

            if (!isset($_SESSION['captcha_err_borrow'])) {
                $_SESSION['captcha_err_borrow'] = '';
            }
            if(!isset($_SESSION['captcha_text_borrow'])) {
                $_SESSION['captcha_text_borrow'] = '';
            }
            if (!isset($_SESSION['submit_borrow_message'])) {
                $_SESSION['submit_borrow_message'] = '';
            }
?>
            </select>

            <br><br>

            <h3 id="before">Selecteaza data la care vrei sa ridici cartile:</h3>
            <input type="date" name="data_impr" id="data_impr" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' + 7 days')); ?>">
                        
            <div class="elem-group">
                <label for="captcha">Te rugam introdu textul Captcha</label> <br>
                <img src="./requirements/captcha.php" alt="CAPTCHA" class="captcha-image"><br>
                <span class="fas fa-redo refresh-captcha">Genereaza cod nou</span> <br>
                <input type="text" class="form-input" id="captcha" name="captcha_challenge"> <br><br>
<?php
                echo $_SESSION['captcha_err_borrow'];
?>
            </div>
                        
            <input type="submit" value="Trimite" class="submit submitborrow" name="borrowreq">
            <p style="color: green; font-weight: bold;">
<?php
            echo $_SESSION['submit_borrow_message'];
?>
            </p>
        </form>

        
    </div> <!-- inchid div_form_input -->
</div> <!-- inchid div dreapta -->
