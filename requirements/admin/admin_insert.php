<?php
require_once '../dbconnect.php';

$link = connectdb();
session_start();
$_SESSION['admin_insert_err'] = '';
$_SESSION['admin_insert'] = '';

if (isset($_POST['admin_insert'])) {
    if ($_POST['table_select'] == "0") {
        // NOTHING TO DO HERE
        // ERROR - NO ACTION SELECTED
        $_SESSION['admin_insert_err'] = 'Nicio actiune selectata!';
    }
    elseif($_POST['table_select'] == "Autor") {
        $nume = mysqli_real_escape_string($link, trim($_POST['nume_autor']));
        $prenume = mysqli_real_escape_string($link, trim($_POST['prenume_autor']));

        if (empty($nume) || empty($prenume)) {
            $_SESSION['admin_insert_err'] = 'Nume sau prenume necompletat!';
        }
        else if (!ctype_alpha($nume) || !ctype_alpha($prenume)){ 
            $_SESSION['admin_insert_err'] = 'Nume sau prenume invalid!';            
        }
        else {
            $query = "SELECT nume, prenume, id_autor
                      FROM autor
                      WHERE BINARY lower(nume) = '" . strtolower($nume) . "' AND BINARY lower(prenume) = '" . strtolower($prenume) . "'";
            
            $res = mysqli_query($link, $query);

            if (mysqli_num_rows($res) != 0) {
                $id = mysqli_fetch_array($res)[2];
                
                $_SESSION['admin_insert_err'] = 'Autor deja existent! Codul lui: ' . $id;
            }
            else {
                $query = "INSERT INTO autor (prenume, nume) VALUES
                    ('" . $prenume . "', '" . $nume . "')";
                
                $res = mysqli_query($link, $query);

                $_SESSION['admin_insert'] = 'Autor adaugat cu succes!';
            }
        }
    }
    elseif($_POST['table_select'] == "Carte") {

        // PRELUAREA DATELOR INTRODUSE IN FORMULAR
        $titlu = mysqli_real_escape_string($link, trim($_POST['titlu_carte']));
        $autori = explode(',',trim($_POST['autori']));
        $id = mysqli_real_escape_string($link, trim($_POST['id_categorie']));
        $an = mysqli_real_escape_string($link, trim($_POST['an']));
        $editura = mysqli_real_escape_string($link, trim($_POST['editura']));
        $tip = '';

        if (isset($_POST['radio_tip_carte'])) {
            $tip = $_POST['radio_tip_carte'];
        }

        $stoc = mysqli_real_escape_string($link, trim($_POST['stoc']));
        $descriere = mysqli_real_escape_string($link, trim($_POST['descriere']));
        $url = mysqli_real_escape_string($link, trim($_POST['url_fisier']));

        // DACA ID-UL INTRODUS NU E VALID SAU ANUL NU E NUMERIV, NU FAC NICIO INSERARE & NU MAI FAC NIMIC ALTCEVA + EROARE
        $query = "SELECT 1
                  FROM categorie
                  WHERE id_categorie = " . $id;

        $res = mysqli_query($link, $query);

        if (mysqli_num_rows($res) == 0) {
            $_SESSION['admin_insert_err'] = 'Categorie inexistenta!';
        }
        else if (!is_numeric($an)) {
            $_SESSION['admin_insert_err'] = 'An invalid!';
        }
        else if (!is_numeric($stoc)) {
            $_SESSION['admin_insert_err'] = 'Stoc invalid!';
        }
        else {
            // VERIFICARE URL
            if ($tip == 'fizica') {
                if (!strpos(".jpg", $url) || !strpos(".jpeg", $url) || !strpos(".png", $url)) {
                    $_SESSION['admin_insert_err'] = 'URL invalid!';
                }
            }
            else if ($tip == 'digitala') {
                if (!strpos("https://drive.google.com/file", $url)) {
                    $_SESSION['admin_insert_err'] = 'URL invalid!';
                }
            }

            if ($_SESSION['admin_insert_err'] === '') {
                // INSERARE CARTE
                $query = "INSERT INTO carte (titlu, id_categorie, an, editura, tip, stoc, descriere, url_fisier) VALUES (
                            '" . $titlu . "', 
                            " . $id . ", 
                            " . $an . ", 
                            '" . $editura . "',
                            '" . $tip . "',
                            " . $stoc . ",
                            '" . $descriere . "',
                            '" . $url . "'
                            )";

                $res = mysqli_query($link, $query);

                $query = "SELECT id_carte
                            FROM carte 
                            WHERE BINARY lower(titlu) = '" . strtolower($titlu) . "'";

                $res = mysqli_query($link, $query);

                $id_carte = mysqli_fetch_array($res)[0];

                // INSERARE IN TABELUL ASOCIATIV
                for ($i = 0; $i < count($autori); $i++) {
                    $query = "INSERT INTO carte_autor VALUES
                                (" . $id_carte . ", " . $autori[$i] . ")";

                    $res = mysqli_query($link, $query);
                }
            }
            else {
                // TRANSFORMAREA AUTORILOR INTRODUSI IN FORMULAR
                $firstname = array();
                $lastname = array();
                foreach ($autori as $autor){
                    $names = explode(' ', $autor);
                    $fn = '';
                    for ($i = 0; $i < count($names) - 1; $i++) {
                        $fn = $fn .  $names[$i];
                    }
                    array_push($firstname, ucfirst(strtolower($fn)));
                    array_push($lastname, ucfirst(strtolower($names[$i])));
                }

                // PROCESARE
                $autori = array();
                for ($i = 0; $i < count($firstname); $i++) {
                    $query = "SELECT id_autor 
                            FROM autor 
                            WHERE BINARY lower(prenume) = '" . strtolower($firstname[$i]) . "' 
                            AND BINARY lower(nume) = '" . strtolower($lastname[$i]) . "'";

                    $res = mysqli_query($link, $query);

                    // DACA NU AM GASIT AUTORUL IN BAZA DE DATE, ATUNCI IL ADAUG
                    if (mysqli_num_rows($res) == 0) {
                        // INSERT AUTOR
                        $query = "INSERT INTO autor (prenume, nume) VALUES 
                                ('" . $firstname[$i] . "', '" . $lastname[$i] . "')";

                        $res = mysqli_query($link, $query);

                        // SALVEZ ID-UL AUTORULUI INSERAT PENTRU A-L PUTEA ADAUGA IN TABELUL ASOCIATIV carte_autor
                        $query = "SELECT id_autor 
                                FROM autor 
                                WHERE BINARY lower(prenume) LIKE '" . strtolower($firstname[$i]) . "' 
                                AND BINARY lower(nume) LIKE '" . strtolower($lastname[$i]) . "'";

                        $res = mysqli_query($link, $query);

                        array_push($autori, mysqli_fetch_array($res)[0]);
                    }
                    // DACA AM GASIT AUTORUL, II SALVEZ ID-UL
                    else {
                        array_push($autori, mysqli_fetch_array($res)[0]);
                    }
                }
            }

        }
    }
    elseif($_POST['table_select'] == "Coduri_utilizatori") {
      
        $cod = trim($_POST['cod_utilizator']);

        if (strlen($cod) != 14) {
            $_SESSION['admin_insert_err'] = "Cod invalid!";
        }
        else {
            $cod = mysqli_real_escape_string($link, $cod);

            $query = "SELECT cod
                      FROM coduri_utilizatori
                      WHERE BINARY cod = '" . $cod . "'";

            $res = mysqli_query($link, $query);

            if (mysqli_num_rows($res) != 0) {
                $_SESSION['admin_insert_err'] = "Cod deja existent!";
            }
            else {

                $tip = 0;

                if (isset($_POST['radio_tip']) && $_POST['radio_tip'] == "2") {
                    $tip = 2;
                }
                else if (isset($_POST['radio_tip']) && $_POST['radio_tip'] == "3") {
                    $tip = 3;
                }

                if ($tip == 0) {
                    $_SESSION['admin_insert_err'] = 'Tipul de utilizator nu a fost ales!';
                }
                else {
                    $query = "INSERT INTO coduri_utilizatori (cod, tip) VALUES
                              ('" . $cod . "', " . $tip . ")";

                    $res = mysqli_query($link, $query);

                    $_SESSION['admin_insert'] = 'Cod adaugat cu succes!';

                }
            }
        }
      
    }
}

header("Location: ../../contulmeu.php");
?>