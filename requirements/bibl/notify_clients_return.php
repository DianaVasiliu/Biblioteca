<?php
    require_once '../dbconnect.php';

    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    if ($_SESSION['send_notif_retur_flag'] == 0) {
      $_SESSION['notificat_retur'] = "Utilizatori deja notificati!";
    }
    else if (!isset($_SESSION['titluri']) || !isset($_SESSION['clients_to_return'])) {
      $_SESSION['notificat_retur'] = "Nu exista clienti de notificat";
      $_SESSION['send_notif_retur_flag'] = 0;
    }
    else {

      $id_client = $_SESSION['clients_to_return'];
      $id_sender = $_SESSION['id'];
      $titluri = $_SESSION['titluri'];

      $query = "INSERT INTO notificari (id_client, id_sender, descriere) VALUES ";

      for ($i = 0; $i < count($id_client); $i++) {
        $descriere = "REMINDER: returul unui imprumut; Titluri de returnat: ";
        
        for ($j = 0; $j < count($titluri[$i]); $j++) {
            $descriere .= $titluri[$i][$j] . "; ";
        }

        $values = "(" . $id_client[$i] . ", " . $id_sender . ", '" . $descriere . "')";

        if ($i < count($id_client) - 1) {
          $values .= ", ";
        }

        $query .= $values;
      }

      $res = mysqli_query($link, $query);
      echo $query ? $query : 'undef';

      if (mysqli_affected_rows($link) == 0) {
        $_SESSION['notificat_retur'] = "Nu exista clienti de notificat";
        $_SESSION['send_notif_retur_flag'] = 0;
      }
      else {
        $_SESSION['notificat_retur'] = "Notificat";
        $_SESSION['send_notif_retur_flag'] = 0;
      }
    }

    header("location: ../../contulmeu.php");
?>