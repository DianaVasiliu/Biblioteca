<?php
  require_once '../dbconnect.php';
  $link = connectdb();

  session_start();

  $date = $_SESSION['cereri'];
  $id_notificare = $_SESSION['cereri_id_notificari'];

  $text = "";
  for ($i = 0; $i < count($id_notificare); $i++) {
    $text .= $id_notificare[$i];
    if ($i < count($id_notificare) - 1) {
      $text .= ",";
    }
  }

  $query = "SELECT DISTINCT id_sender
            FROM notificari
            WHERE id_notificare IN (" . $text . ")";
  
  $res = mysqli_query($link, $query);

  $id_client = array();
  while ($row = mysqli_fetch_array($res)) {
    array_push($id_client, $row[0]);
  }

  $ok = 1;
  // caut data si clientul pentru care a fost apasat buton
  for ($i = 0; $i < count($date) && $ok; $i++) {
    for ($j = 0; $j < count($id_client) && $ok; $j++) {

      // pentru acceptare de cerere de imprumut
      if (isset($_POST['accept' . str_replace("-", "", $date[$i]) . $id_client[$j]])) {

        $query = "SELECT descriere, id_notificare
                  FROM notificari
                  WHERE id_sender = " . $id_client[$j] . "
                  AND descriere LIKE 'CERERE%' 
                  AND descriere LIKE '%" . $date[$i] . "'";
        
        $res = mysqli_query($link, $query);

        $titluri = array();
        $id_notificare = array();
        while ($row = mysqli_fetch_array($res)) {
          $temp = $row[0];
          $poz1 = strpos($temp, '"');
          $poz2 = strpos($temp, '"', $poz1 + 1);
          $titlu = substr($temp, $poz1 + 1, $poz2 - $poz1 - 1);

          array_push($titluri, $titlu);
          array_push($id_notificare, $row[1]);
        }

        $id_carte = array();

        $descriere = "IMPRUMUT: acceptat - titluri: ";

        for ($k = 0; $k < count($titluri); $k++) {
          $descriere .= $titluri[$k];

          if ($k < count($titluri) - 1) {
            $descriere .= "; ";
          }

          $query = "SELECT id_carte
                    FROM carte
                    WHERE BINARY titlu = '" . $titluri[$k] . "'
                    AND tip = 'fizica'";
          
          $res = mysqli_query($link, $query);

          $id = mysqli_fetch_array($res)[0];

          array_push($id_carte, $id);
        }

        $data_retur = date('Y-m-d', strtotime($date[$i] . ' + 15 days'));

        $descriere .= " - data ridicarii: " . $date[$i] . 
                      "; data returului: " . $data_retur; 

        $query = "SELECT id_imprumut
                  FROM imprumut
                  ORDER BY id_imprumut DESC";

        $res = mysqli_query($link, $query);

        $id_imprumut = mysqli_fetch_array($res)[0] + 1;

        $values = "";
        for ($k = 0; $k < count($id_carte); $k++) {
          $values .= "(" . $id_imprumut . ", "
                         . $id_client[$j] . ", "
                         . $id_carte[$k] . ", "
                         . "CURRENT_TIMESTAMP(), '"
                         . $date[$i] . "', '"
                         . $data_retur . "', "
                         . "0)"; 
          
          if ($k < count($id_carte) - 1) {
            $values .= ", ";
          }
        }

        $query = "INSERT INTO imprumut VALUES " . $values;

        $res = mysqli_query($link, $query);
        
        $ok = 0;
      }
      // pentru refuz de cerere de imprumut
      else if (isset($_POST['refuz' . str_replace("-", "", $date[$i]) . $id_client[$j]])) {

        $query = "SELECT descriere, id_notificare
                  FROM notificari
                  WHERE id_sender = " . $id_client[$j] . "
                  AND descriere LIKE 'CERERE%' 
                  AND descriere LIKE '%" . $date[$i] . "'";
        
        $res = mysqli_query($link, $query);

        $titluri = array();
        $id_notificare = array();
        while ($row = mysqli_fetch_array($res)) {
          $temp = $row[0];
          $poz1 = strpos($temp, '"');
          $poz2 = strpos($temp, '"', $poz1 + 1);
          $titlu = substr($temp, $poz1 + 1, $poz2 - $poz1 - 1);

          array_push($titluri, $titlu);
          array_push($id_notificare, $row[1]);
        }

        $descriere = "IMPRUMUT: refuzat - titluri: ";

        for ($k = 0; $k < count($titluri); $k++) {
          $descriere .= $titluri[$k];

          if ($k< count($titluri) - 1) {
            $descriere .= "; ";
          }
        }

        $ok = 0;
      }

      if ($ok == 0) {

        $query = "INSERT INTO notificari (id_client, id_sender, descriere) VALUES 
                  (" . $id_client[$j] . ",
                  " . $_SESSION['id'] . ",
                  '" . $descriere . "')
                  ";
      
        $res = mysqli_query($link, $query);

        $values = "(";
        for ($k = 0; $k < count($id_notificare); $k++) {
          $values .= $id_notificare[$k];
          if ($k < count($id_notificare) - 1) {
            $values .= ", ";
          }
        }
        $values .= ")";

        $query = "UPDATE notificari
                  SET citit = 1
                  WHERE id_notificare IN " . $values;
        
        $res = mysqli_query($link, $query);
      }
    }
  }

  header("Location: ../../contulmeu.php");

?>