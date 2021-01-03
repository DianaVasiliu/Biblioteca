<?php
    require_once '../dbconnect.php';
    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    // tax
    if (isset($_POST['tax'])) {
      $id_client = $_POST['select_client_1'];
      $motiv = $_POST['select_motiv'];
      $desc = trim(mysqli_real_escape_string($link, $_POST['descriere1']));
      $zile = trim(mysqli_real_escape_string($link, $_POST['nr_zile']));

      if ($id_client == 0) {
        $_SESSION['tax_error'] = "Nu ai selectat un client!";
        header("location: ../../contulmeu.php");
      }

      else if ($motiv == 0) {
        $_SESSION['tax_error'] = "Nu ai selectat un motiv!";
        header("location: ../../contulmeu.php");
      }
      
      else if (!is_numeric($zile) && ($motiv == 2 || $motiv == 3)) {
        $_SESSION['tax_error'] = "Numar de zile invalid!";
        header("location: ../../contulmeu.php");
      }

      else {
        $suma = 0;
        $text = '';

        if ($motiv == 1) {
          $suma = 5;
          $text = "Neprezentare la ridicare" . ($desc ? "; " : "") . $desc;
          $zile = 1;
        }
        else if ($motiv == 2) {
          $suma = 15;
          $text = "Intarziere restituire; Numar de zile: " . $zile . ($desc ? "; " : "") . $desc;
        }
        else if ($motiv == 3) {
          $suma = 20;
          $text = "Intarziere plata unei taxe; Numar de zile: " . $zile . ($desc ? "; " : "") . $desc;
        }
        else {
          $_SESSION['tax_error'] = "Motiv selectat incorect!";
          header("location: ../../contulmeu.php");
        }

        if ($zile <= 0 || $zile >= 16) {
          $_SESSION['tax_error'] = "Numar de zile invalid!";
          header("location: ../../contulmeu.php");
        }
        
        else if (!isset($_SESSION['tax_error']) || $_SESSION['tax_error'] == '') {

          $query = "INSERT INTO taxe (id_client, descriere, suma) VALUES
                    (" . $id_client . ",
                    '" . $text . "',
                    " . $suma * $zile . ")";

          $res = mysqli_query($link, $query);

          $query = "UPDATE client
                    SET taxa = taxa + " . $suma * $zile . 
                  " WHERE id_client = " . $id_client;
          
          $res = mysqli_query($link, $query);

          $_SESSION['tax_error'] = "Succes!";
          
          header("location: ../../contulmeu.php");
        }
      }
    }

    // untax
    else if (isset($_POST['untax'])) {
      $id_client = $_POST['select_client_2'];
      $suma = trim(mysqli_real_escape_string($link, $_POST['suma']));
      $desc = trim(mysqli_real_escape_string($link, $_POST['descriere2']));

      if ($id_client == 0) {
        $_SESSION['tax_error'] = "Nu ai selectat un client!";
        header("location: ../../contulmeu.php");
      }

      else if (!is_numeric($suma)) {
        $_SESSION['tax_error'] = "Suma invalida!";
        header("location: ../../contulmeu.php");
      }

      else {
        $query = "SELECT taxa
                  FROM client
                  WHERE id_client = " . $id_client;

        $res = mysqli_query($link, $query);

        $suma = intval($suma);
        $s = mysqli_fetch_array($res)[0];

        if ($suma < 0) {
          $_SESSION['tax_error'] = "Suma invalida! Pentru taxare foloseste primul formular.";
          header("location: ../../contulmeu.php");
        }
        else if ($s < $suma) {
          $_SESSION['tax_error'] = "Suma invalida!";
          header("location: ../../contulmeu.php");
        }
      }

      if (!isset($_SESSION['tax_error']) || $_SESSION['tax_error'] == '') {
        $query = "INSERT INTO taxe (id_client, descriere, suma) VALUES
                  (" . $id_client . ",
                  '" . $desc . "',
                  " . -$suma . ")";

        $res = mysqli_query($link, $query);

        $query = "UPDATE client
                  SET taxa = taxa - " . $suma . "
                  WHERE id_client = " . $id_client;
        
        $res = mysqli_query($link, $query);

        $_SESSION['tax_error'] = "Succes!";

        header("location: ../../contulmeu.php");
      }
    }


?>