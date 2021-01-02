<?php
    require_once '../dbconnect.php';

    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    if ($_SESSION['send_notif_taxa_flag'] == 0) {
      $_SESSION['notificat_taxa'] = "Utilizatori deja notificati!";
    }
    else if (!isset($_SESSION['taxe']) || !isset($_SESSION['clients_to_pay'])) {
      $_SESSION['notificat_taxa'] = "Nu exista clienti de notificat";
      $_SESSION['send_notif_taxa_flag'] = 0;
    }
    else {

      $id_client = $_SESSION['clients_to_pay'];
      $id_sender = $_SESSION['id'];
      $taxa = $_SESSION['taxe'];

      $query = "INSERT INTO notificari (id_client, id_sender, descriere) VALUES ";

      for ($i = 0; $i < count($id_client); $i++) {
        $descriere = "REMINDER: plata taxei de " . $taxa[$i] . "RON";

        $values = "(" . $id_client[$i] . ", " . $id_sender . ", '" . $descriere . "')";

        if ($i < count($id_client) - 1) {
          $values .= ", ";
        }

        $query .= $values;
      }

      $res = mysqli_query($link, $query);

      if (mysqli_affected_rows($link) == 0) {
        $_SESSION['notificat_taxa'] = "Nu exista clienti de notificat";
        $_SESSION['send_notif_taxa_flag'] = 0;
      }
      else {
        $_SESSION['notificat_taxa'] = "Notificat";
        $_SESSION['send_notif_taxa_flag'] = 0;
      }

    }

    header("location: ../../contulmeu.php");
?>