<?php
require_once '../dbconnect.php';

$link = connectdb();
mysqli_set_charset($link , "utf8");

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

        // PRELUAREA DATELOR INTRODUSE IN FORMULAR
        $titlu = mysqli_real_escape_string($link, trim($_POST['titlu_carte_delete']));
        $editura = mysqli_real_escape_string($link, trim($_POST['editura_delete']));
        $tip = '';
        if (isset($_POST['radio_tip_carte_delete'])) {
            $tip = $_POST['radio_tip_carte_delete'];
        }

        $query = "SELECT id_carte
                  FROM carte
                  WHERE titlu = '" . $titlu . "'
                  AND tip = '" . $tip . "'
                  AND editura = '" . $editura . "'";
        
        $res = mysqli_query($link, $query);

        $id_carte = mysqli_fetch_array($res)[0];

        $query = "DELETE FROM carte
                  WHERE id_carte = " . $id_carte;

        $res = mysqli_query($link, $query);
    }
}

header("Location: ../../contulmeu.php");
?>