<?php
require_once '../dbconnect.php';

$link = connectdb();
mysqli_set_charset($link , "utf8");

session_start();

$_SESSION['admin_update_err'] = '';
$_SESSION['admin_update'] = '';

if (isset($_POST['admin_update'])) {
  if ($_POST['table_select_update'] == "0") {
    // NOTHING TO DO HERE
    // ERROR - NO ACTION SELECTED
    $_SESSION['admin_update_err'] = 'Nicio actiune selectata!';
  }
  elseif($_POST['table_select_update'] === "Carte") {

    // PRELUAREA DATELOR INTRODUSE IN FORMULAR
    $titlu = mysqli_real_escape_string($link, trim($_POST['titlu_carte_update']));
    $titlu_nou = mysqli_real_escape_string($link, trim($_POST['titlu_nou_update']));
    $id = mysqli_real_escape_string($link, trim($_POST['id_categorie_update']));
    $an = mysqli_real_escape_string($link, trim($_POST['an_update']));
    $editura = mysqli_real_escape_string($link, trim($_POST['editura_update']));
    $tip = '';
    if (isset($_POST['radio_tip_carte_update'])) {
      $tip = $_POST['radio_tip_carte_update'];
    }
    $stoc = mysqli_real_escape_string($link, trim($_POST['stoc_update']));
    $descriere = mysqli_real_escape_string($link, trim($_POST['descriere_update']));
    $url = mysqli_real_escape_string($link, trim($_POST['url_fisier_update']));
    
    if (isset($id) && $id != '' && is_numeric($id)) {
      $query = "SELECT 1
                FROM categorie
                WHERE id_categorie = " . $id;
      $res = mysqli_query($link, $query);

      if (mysqli_num_rows($res) == 0) {
        $_SESSION['admin_update_err'] = 'Categorie inexistenta!';
        header("Location: ../../contulmeu.php");
      }
    }
    
    if (empty($titlu)) {
      $_SESSION['admin_update_err'] = 'Nu ai specificat cartea de modificat!';
    }
    else if (!empty($an) && !is_numeric($an)) {
      $_SESSION['admin_update_err'] = 'An invalid!';
    }
    else if ($tip === '') {
      $_SESSION['admin_update_err'] = 'Tip neales!';
    }
    else if (!empty($stoc) && !is_numeric($stoc)) {
      $_SESSION['admin_update_err'] = 'Stoc invalid!';
    }
    else {
      // VERIFICARE URL
      if ($tip == 'fizica' && isset($url) && $url != '') {
          if ((strpos($url, ".jpg") === false || strpos($url, ".jpg") === 0) && 
              (strpos($url, ".jpeg") === false || strpos($url, ".jpeg") === 0) && 
              (strpos($url, ".png") === false || strpos($url, ".png") === 0)) {
              $_SESSION['admin_update_err'] = 'URL invalid!';
          }
      }
      else if ($tip == 'digitala' && isset($url) && $url != '') {
          if (strpos($url, "https://drive.google.com/file") === false || 
              strpos($url, "https://drive.google.com/file") !== 0) {
              $_SESSION['admin_update_err'] = 'URL invalid!';
          }
      }

      if ($_SESSION['admin_update_err'] === '') {
        $query = "SELECT id_carte
                  FROM carte
                  WHERE BINARY lower(titlu) = '" . strtolower($titlu) . "'
                  AND tip = '" . $tip . "'";
      
        $res = mysqli_query($link, $query);
        $id_carte = mysqli_fetch_array($res)[0];

        // UPDATE CARTE
        if (!empty($titlu_nou)) {
          $query = "UPDATE carte 
                    SET titlu = '" . $titlu_nou . "'
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($id)) {
          $query = "UPDATE carte 
                    SET id_categorie = " . $id . "
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($an)) {
          $query = "UPDATE carte 
                    SET an = " . $an . "
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($editura)) {
          $query = "UPDATE carte 
                    SET editura = '" . $editura . "'
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($stoc)) {
          $query = "UPDATE carte 
                    SET stoc = " . $stoc . "
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($descriere)) {
          $query = "UPDATE carte 
                    SET descriere = '" . $descriere . "'
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        if (!empty($url)) {
          $query = "UPDATE carte 
                    SET url_fisier = '" . $url . "'
                    WHERE id_carte = " . $id_carte;
          $res = mysqli_query($link, $query);
        }

        $_SESSION['admin_update'] = 'Carte actualizata cu succes!';
      }
    }
  }
}

header("Location: ../../contulmeu.php");
?>