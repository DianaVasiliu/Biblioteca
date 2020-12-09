<?php
require_once '../dbconnect.php';

$link = connectdb();
session_start();
$_SESSION['admin_insert_err'] = '';
$_SESSION['admin_insert'] = '';

if (isset($_POST['admin_insert'])) {
    if ($_POST['table_select_insert'] == "0") {
        // NOTHING TO DO HERE
        // ERROR - NO ACTION SELECTED
        $_SESSION['admin_insert_err'] = 'Nicio actiune selectata!';
    }
    elseif($_POST['table_select_insert'] == "Autor") {
        $nume = mysqli_real_escape_string($link, trim($_POST['nume_autor_insert']));
        $prenume = mysqli_real_escape_string($link, trim($_POST['prenume_autor_insert']));

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
    elseif($_POST['table_select_insert'] == "Carte") {

        // PRELUAREA DATELOR INTRODUSE IN FORMULAR
        $titlu = mysqli_real_escape_string($link, trim($_POST['titlu_carte_insert']));
        $autori = explode(',',trim($_POST['autori_insert']));
        $id = mysqli_real_escape_string($link, trim($_POST['id_categorie_insert']));
        $an = mysqli_real_escape_string($link, trim($_POST['an_insert']));
        $editura = mysqli_real_escape_string($link, trim($_POST['editura_insert']));
        $tip = '';

        if (isset($_POST['radio_tip_carte_insert'])) {
            $tip = $_POST['radio_tip_carte_insert'];
        }

        $stoc = mysqli_real_escape_string($link, trim($_POST['stoc_insert']));
        $descriere = mysqli_real_escape_string($link, trim($_POST['descriere_insert']));
        $url = mysqli_real_escape_string($link, trim($_POST['url_fisier_insert']));

        // DACA ID-UL INTRODUS NU E VALID SAU ANUL NU E NUMERIC, NU FAC NICIO INSERARE & NU MAI FAC NIMIC ALTCEVA + EROARE
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
        else if ($tip === '') {
            $_SESSION['admin_insert_err'] = 'Tip neales!';
        }
        else {
            // VERIFICARE URL
            if ($tip == 'fizica') {
                if ((strpos($url, ".jpg") === false || strpos($url, ".jpg") === 0) && 
                    (strpos($url, ".jpeg") === false || strpos($url, ".jpeg") === 0) && 
                    (strpos($url, ".png") === false || strpos($url, ".png") === 0)) {
                    $_SESSION['admin_insert_err'] = 'URL invalid!';
                }
            }
            else if ($tip == 'digitala') {
                if (strpos($url, "https://drive.google.com/file") === false || 
                    strpos($url, "https://drive.google.com/file") !== 0) {
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

                // TRANSFORMAREA AUTORILOR INTRODUSI IN FORMULAR
                $firstname = array();
                $lastname = array();
                foreach ($autori as $autor) {
                    $autor = trim($autor);
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
                                  WHERE BINARY lower(prenume) = '" . strtolower($firstname[$i]) . "' 
                                  AND BINARY lower(nume) = '" . strtolower($lastname[$i]) . "'";

                        $res = mysqli_query($link, $query);

                        array_push($autori, mysqli_fetch_array($res)[0]);
                    }
                    // DACA AM GASIT AUTORUL, II SALVEZ ID-UL
                    else {
                        array_push($autori, mysqli_fetch_array($res)[0]);
                    }
                }

                // INSERARE IN TABELUL ASOCIATIV
                $query = "INSERT INTO carte_autor VALUES ";
                for ($i = 0; $i < count($autori); $i++) {
                    $query = $query . "(" . $id_carte . ", " . $autori[$i] . ")";
                    if ($i < count($autori) - 1) {
                        $query .= ", ";
                    }
                }
                $res = mysqli_query($link, $query);
                
                $_SESSION['admin_insert'] = 'Carte adaugata cu succes!';
            }
        }
    }
    elseif($_POST['table_select_insert'] == "Coduri_utilizatori") {
      
        $cod = trim($_POST['cod_utilizator_insert']);

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

                if (isset($_POST['radio_tip_insert']) && $_POST['radio_tip_insert'] == "2") {
                    $tip = 2;
                }
                else if (isset($_POST['radio_tip_insert']) && $_POST['radio_tip_insert'] == "3") {
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