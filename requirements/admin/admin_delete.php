<?php
require_once '../dbconnect.php';

$link = connectdb();
session_start();
$_SESSION['admin_delete_err'] = '';
$_SESSION['admin_delete'] = '';

if (isset($_POST['admin_delete'])) {
    if ($_POST['table_select_delete'] == "0") {
        // NOTHING TO DO HERE
        // ERROR - NO ACTION SELECTED
        $_SESSION['admin_delete_err'] = 'Nicio actiune selectata!';
    }
    elseif($_POST['table_select_delete'] == "Autor") {
      
        $nume = mysqli_real_escape_string($link, trim($_POST['nume_autor_delete']));
        $prenume = mysqli_real_escape_string($link, trim($_POST['prenume_autor_delete']));

        if (empty($nume) || empty($prenume)) {
            $_SESSION['admin_delete_err'] = 'Nume sau prenume necompletat!';
        }
        else if (!ctype_alpha($nume) || !ctype_alpha($prenume)){ 
            $_SESSION['admin_delete_err'] = 'Nume sau prenume invalid!';            
        }
        else {
            $query = "DELETE
                      FROM autor
                      WHERE BINARY lower(nume) = '" . strtolower($nume) . "' 
                      AND BINARY lower(prenume) = '" . strtolower($prenume) . "'";
            
            $res = mysqli_query($link, $query);

            if (mysqli_affected_rows($link) == 0) {                
                $_SESSION['admin_delete_err'] = 'Autor inexistent!';
            }
            else {
                $_SESSION['admin_delete'] = 'Autor sters cu succes!';
            }
        }
    }
    elseif($_POST['table_select_delete'] == "Carte") {

        // trebuie sa sterg si din carte_autor
        // cred ca o sa adaug o coloana in tabelul "carte" - coloana 'existenta' sau ceva

        // PRELUAREA DATELOR INTRODUSE IN FORMULAR
        $titlu = mysqli_real_escape_string($link, trim($_POST['titlu_carte_delete']));
        $autori = explode(',',trim($_POST['autori_delete']));
        $id = mysqli_real_escape_string($link, trim($_POST['id_categorie_delete']));
        $an = mysqli_real_escape_string($link, trim($_POST['an_delete']));
        $editura = mysqli_real_escape_string($link, trim($_POST['editura_delete']));
        $tip = '';
        if (isset($_POST['radio_tip_carte_delete'])) {
            $tip = $_POST['radio_tip_carte_delete'];
        }
        $stoc = mysqli_real_escape_string($link, trim($_POST['stoc_delete']));
        $descriere = mysqli_real_escape_string($link, trim($_POST['descriere_delete']));
        $url = mysqli_real_escape_string($link, trim($_POST['url_fisier_delete']));

        // // DACA ID-UL INTRODUS NU E VALID SAU ANUL NU E NUMERIC, NU FAC NICIO INSERARE & NU MAI FAC NIMIC ALTCEVA + EROARE
        // $query = "SELECT 1
        //           FROM categorie
        //           WHERE id_categorie = " . $id;

        // $res = mysqli_query($link, $query);

        // if (mysqli_num_rows($res) == 0) {
        //     $_SESSION['admin_delete_err'] = 'Categorie inexistenta!';
        // }
        // else if (!is_numeric($an)) {
        //     $_SESSION['admin_delete_err'] = 'An invalid!';
        // }
        // else if (!is_numeric($stoc)) {
        //     $_SESSION['admin_delete_err'] = 'Stoc invalid!';
        // }
        // else if ($tip === '') {
        //     $_SESSION['admin_delete_err'] = 'Tip neales!';
        // }
        // else {
        //     // VERIFICARE URL
        //     if ($tip == 'fizica') {
        //         if (!strpos(".jpg", $url) || strpos(".jpg", $url) == 0 || 
        //             !strpos(".jpeg", $url) || strpos(".jpeg", $url) == 0 || 
        //             !strpos(".png", $url) || strpos(".png", $url) == 0) {
        //             $_SESSION['admin_delete_err'] = 'URL invalid!';
        //         }
        //     }
        //     else if ($tip == 'digitala') {
        //         if (!strpos("https://drive.google.com/file", $url) || 
        //             strpos("https://drive.google.com/file", $url) != 0) {
        //             $_SESSION['admin_delete_err'] = 'URL invalid!';
        //         }
        //     }

        //     if ($_SESSION['admin_delete_err'] === '') {
        //         // INSERARE CARTE
        //         $query = "delete INTO carte (titlu, id_categorie, an, editura, tip, stoc, descriere, url_fisier) VALUES (
        //                     '" . $titlu . "', 
        //                     " . $id . ", 
        //                     " . $an . ", 
        //                     '" . $editura . "',
        //                     '" . $tip . "',
        //                     " . $stoc . ",
        //                     '" . $descriere . "',
        //                     '" . $url . "'
        //                     )";

        //         $res = mysqli_query($link, $query);

        //         $query = "SELECT id_carte
        //                     FROM carte 
        //                     WHERE BINARY lower(titlu) = '" . strtolower($titlu) . "'";

        //         $res = mysqli_query($link, $query);

        //         $id_carte = mysqli_fetch_array($res)[0];

        //         // INSERARE IN TABELUL ASOCIATIV
        //         for ($i = 0; $i < count($autori); $i++) {
        //             $query = "INSERT INTO carte_autor VALUES
        //                         (" . $id_carte . ", " . $autori[$i] . ")";

        //             $res = mysqli_query($link, $query);
        //         }
        //     }
        //     else {
        //         // TRANSFORMAREA AUTORILOR INTRODUSI IN FORMULAR
        //         $firstname = array();
        //         $lastname = array();
        //         foreach ($autori as $autor){
        //             $names = explode(' ', $autor);
        //             $fn = '';
        //             for ($i = 0; $i < count($names) - 1; $i++) {
        //                 $fn = $fn .  $names[$i];
        //             }
        //             array_push($firstname, ucfirst(strtolower($fn)));
        //             array_push($lastname, ucfirst(strtolower($names[$i])));
        //         }

        //         // PROCESARE
        //         $autori = array();
        //         for ($i = 0; $i < count($firstname); $i++) {
        //             $query = "SELECT id_autor 
        //                     FROM autor 
        //                     WHERE BINARY lower(prenume) = '" . strtolower($firstname[$i]) . "' 
        //                     AND BINARY lower(nume) = '" . strtolower($lastname[$i]) . "'";

        //             $res = mysqli_query($link, $query);

        //             // DACA NU AM GASIT AUTORUL IN BAZA DE DATE, ATUNCI IL ADAUG
        //             if (mysqli_num_rows($res) == 0) {
        //                 // INSERT AUTOR
        //                 $query = "INSERT INTO autor (prenume, nume) VALUES 
        //                         ('" . $firstname[$i] . "', '" . $lastname[$i] . "')";

        //                 $res = mysqli_query($link, $query);

        //                 // SALVEZ ID-UL AUTORULUI INSERAT PENTRU A-L PUTEA ADAUGA IN TABELUL ASOCIATIV carte_autor
        //                 $query = "SELECT id_autor 
        //                         FROM autor 
        //                         WHERE BINARY lower(prenume) LIKE '" . strtolower($firstname[$i]) . "' 
        //                         AND BINARY lower(nume) LIKE '" . strtolower($lastname[$i]) . "'";

        //                 $res = mysqli_query($link, $query);

        //                 array_push($autori, mysqli_fetch_array($res)[0]);
        //             }
        //             // DACA AM GASIT AUTORUL, II SALVEZ ID-UL
        //             else {
        //                 array_push($autori, mysqli_fetch_array($res)[0]);
        //             }
        //         }
        //     }

        // }
    }
}

header("Location: ../../contulmeu.php");
?>