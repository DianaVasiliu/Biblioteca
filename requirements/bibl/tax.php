<?php
    require_once '../dbconnect.php';
    $link = connectdb();

    session_start();

    // tax
    if (isset($_POST['tax'])) {
      $id_client = $_POST['select_client_1'];
      $motiv = $_POST['select_motiv'];
      $desc = trim(mysqli_real_escape_string($link, $_POST['descriere1']));

      if ($id_client == 0) {
        $_SESSION['tax_error'] = "Nu ai selectat un client!";
        header("location: ../../contulmeu.php");
      }

      else if ($motiv == 0) {
        $_SESSION['tax_error'] = "Nu ai selectat un motiv!";
        header("location: ../../contulmeu.php");
      }

      else {
        $suma = 0;
        $text = '';

        if ($motiv == 1) {
          $suma = 5;
          $text = "Neprezentare la ridicare; " . $desc;
        }
        else if ($motiv == 2) {
          $suma = 15;
          $text = "Intarziere restituire; " . $desc;
        }
        else if ($motiv == 3) {
          $suma = 20;
          $text = "Intarziere plata unei taxe; " . $desc;
        }
        else {
          $_SESSION['tax_error'] = "Motiv selectat incorect!";
          header("location: ../../contulmeu.php");
        }
        
        if (!isset($_SESSION['tax_error']) || $_SESSION['tax_error'] == '') {
          $query = "INSERT INTO taxe (id_client, descriere, suma) VALUES
                    (" . $id_client . ",
                    '" . $text . "',
                    " . $suma . ")";

          $res = mysqli_query($link, $query);

          $query = "UPDATE client
                    SET taxa = taxa + " . $suma . 
                  " WHERE id_client = " . $id_client;
          
          $res = mysqli_query($link, $query);
          
          header("location: ../../contulmeu.php");
        }
      }
    }

    // untax
    else if (isset($_POST['untax'])) {
      $id_client = $_POST['select_client_2'];
      $suma = trim(mysqli_real_escape_string($_POST['suma']));
      $desc = trim(mysqli_real_escape_string($_POST['descriere2']));

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

        $s = mysqli_fetch_array($res)[0];

        if ($s < $suma) {
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

        header("location: ../../contulmeu.php");
      }
    }


?>