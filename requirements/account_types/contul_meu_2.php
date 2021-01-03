<?php    
    if (!isset($_SESSION['notificat_retur'])) {
      $_SESSION['notificat_retur'] = "";
    }
    if (!isset($_SESSION['notificat_taxa'])) {
      $_SESSION['notificat_taxa'] = "";
    }
?>

<div class="dreapta"> <!-- notificari -->
  <div class="info_bibl">

    <h2 class="h2_bibl">Utilizatorii care trebuie sa restituie imprumuturi in urmatoarele 7 zile:</h2>
    <form action="./requirements/bibl/notify_clients_return.php" method="post" class="bibl_form">
      <input type="submit" name="notify_return" id="notify_return" value="Notifica pe toata lumea" class="bibl_submit">
<?php
      if ($_SESSION['notificat_retur'] !== "") {
        echo " - " . $_SESSION['notificat_retur'];
      }
?>
    </form>

<?php

  $query = "SELECT DISTINCT id_client
            FROM imprumut
            WHERE restituit = 0
            AND data_retur >= DATE(NOW()) 
            AND data_retur <= DATE_ADD(NOW(), INTERVAL 7 DAY)
            ORDER BY id_client";

  $res = mysqli_query($link, $query);

  $id_client = array();
  while ($row = mysqli_fetch_array($res)) {
    array_push($id_client, $row[0]);
  }

  $_SESSION['clients_to_return'] = $id_client;

  $clients = "(";
  for ($i = 0; $i < count($id_client); $i++) {
    $clients .= $id_client[$i];

    if ($i < count($id_client) - 1) {
      $clients .= ",";
    }
  }

  if (strlen($clients) == 1) {
    $clients .= "-1";
  }

  $clients .= ")";

  $query = "SELECT DISTINCT nume, prenume, id_client
            FROM client
            WHERE id_client IN " . $clients . " ORDER BY id_client";
  
  $nume = array();
  $prenume = array();

  $res = mysqli_query($link, $query);

  while ($row = mysqli_fetch_array($res)) {
    array_push($nume, $row[0]);
    array_push($prenume, $row[1]);
  }

  $query = "SET lc_time_names = 'ro_RO'";
  $res = mysqli_query($link, $query);
?>

  <table>

<?php
  for ($i = 0; $i < count($id_client); $i++) {

    if ($i % 3 == 0) {
?>
      <tr>
<?php
    }
?>

    <td>
      <h3 class="h3_bibl">
<?php
      echo $nume[$i] . " " . $prenume[$i];      
?>    
      </h3>      
    
<?php
    
    $id_imprumut = array();
    $termen = array();
    $data_retur = array();

    $query = "SELECT DISTINCT id_imprumut, DATEDIFF(date_add(now(), interval 7 day), data_retur) + 1, DATE_FORMAT(data_retur, '%d %M %Y'), id_client
              FROM imprumut
              WHERE id_client = " . $id_client[$i] . 
            " AND restituit = 0
              AND data_retur >= DATE(NOW())
              AND data_retur <= DATE_ADD(NOW(), INTERVAL 7 DAY)
              ORDER BY id_client";

    $res = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($res)) {
      array_push($id_imprumut, $row[0]);
      array_push($termen, $row[1]);
      array_push($data_retur, $row[2]);
    }
    
    $_SESSION['termen'] = $termen;
    $_SESSION['data_retur'] = $data_retur;

    $_SESSION['titluri'] = array();

    for ($j = 0; $j < count($id_imprumut); $j++) {
?>
      <h4 style="text-decoration: underline;">
<?php
      echo "Imprumutul cu id-ul " . $id_imprumut[$j];
?>
      </h4>
      <span class="termen">
<?php
      echo "TERMEN LIMITA:";
?>
      </span>
      <span class="termen_data">
<?php
      
      echo "peste " . $termen[$i] . " zile (" . $data_retur[$i] . ")";
?>
      </span>
      <h4>Titluri: </h4>
<?php
      $query = "SELECT DISTINCT carte.titlu
                FROM imprumut
                JOIN carte_imprumut ON (imprumut.id_imprumut = carte_imprumut.id_imprumut)
                JOIN carte ON (carte.id_carte = carte_imprumut.id_carte)
                WHERE imprumut.id_imprumut = " . $id_imprumut[$j];
      
      $titlu = array();
      $res = mysqli_query($link, $query);
      while ($row = mysqli_fetch_array($res)) {
        array_push($titlu, $row[0]);
        echo $row[0] . "<br>";
      }
      
      array_push($_SESSION['titluri'], $titlu);

      if ($j < count($id_imprumut) - 1) {
?>
        <br><br>
<?php
      }
    }
?>
      <br><br>
    </td>
<?php
    if ($i % 3 == 2) {
?>
      </tr>
<?php
    }
?>
    <br><br>
<?php
  }
?>
  </tr>

</table>


    <h2 class="h2_bibl h2_margin_top">Utilizatorii care trebuie sa plateasca taxa:</h2>
    <form action="./requirements/bibl/notify_clients_taxes.php" method="post" class="bibl_form">
      <input type="submit" name="notify_taxes" id="notify_taxes" value="Notifica pe toata lumea" class="bibl_submit">
<?php
      if ($_SESSION['notificat_taxa'] !== "") {
        echo " - " . $_SESSION['notificat_taxa'];
      }
?>
    </form>

<?php
    
    $query = "SELECT id_client, prenume, nume, email, taxa
              FROM client
              WHERE tip = 1
              AND taxa > 0.00";
    
    $id_client = array();
    $prenume = array();
    $nume = array();
    $email = array();
    $taxa = array();
    
    $res = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($res)) {
      array_push($id_client, $row[0]);
      array_push($prenume, $row[1]);
      array_push($nume, $row[2]);
      array_push($email, $row[3]);
      array_push($taxa, $row[4]);
    }
    
    $_SESSION['clients_to_pay'] = $id_client;
    $_SESSION['taxe'] = $taxa;
?>  

    <table>
<?php
    for ($i = 0; $i < count($id_client); $i++) {
      if ($i % 3 == 0) {
?>
        <tr>
<?php
      }
?>
      <td>
        <h3 class="h3_bibl">
<?php
        echo $nume[$i] . " " . $prenume[$i];      
?>    
       </h3> 
          
<?php
        echo "Taxa de platit: " . $taxa[$i] . " RON";
?>
      </td>
<?php
      if ($i % 3 == 2) {
?>
        </tr>
<?php
      }
    }

?>
    </tr>

    </table>

  </div>
</div>


<div class="dreapta"> <!-- cereri de imprumut -->
    <div class="info_bibl">
<?php
    // selectez notificarile cererilor pentru bibliotecar
    // ca sa aflu datele cerute de utilizatori pentru ridicari

    $query = "SELECT id_notificare, descriere, id_sender
              FROM notificari
              WHERE id_client = " . $_SESSION['id'] . 
            " AND citit = 0
              AND descriere LIKE BINARY 'CERERE%'
              ORDER BY 1 ";

    $res = mysqli_query($link, $query);

    $id_notificare = array();
    $descriere = array();

    while ($row = mysqli_fetch_array($res)) {
      array_push($id_notificare, $row[0]);
      array_push($descriere, $row[1]);
    }

    $nr = 0;
    $data_array = array();
    $temp = '';
    
    // aflu datele cerute de utilizatori

    for ($i = 0; $i < count($id_notificare); $i++) {
      $substr = substr($descriere[$i], strlen($descriere[$i]) - 10, 10);
      if ($substr != $temp) {
        if (!in_array($substr, $data_array)) {
          array_push($data_array, $substr);
        }
        $temp = $substr;
      }
    }

    $_SESSION['cereri'] = $data_array;
    $_SESSION['cereri_id_notificari'] = $id_notificare;

    $ok = 0;

    // pentru fiecare data, 
    // iau clientii care au cereri de ridicare in acea zi

    for ($i = 0; $i < count($data_array); $i++) {
      
      $query = "SELECT DISTINCT id_sender
                FROM notificari
                WHERE descriere LIKE '%" . $data_array[$i] . "'
                AND citit = 0";

      $res = mysqli_query($link, $query);

      $id_client = array();

      while ($row = mysqli_fetch_array($res)) {
        array_push($id_client, $row[0]);
      }

      // pentru fiecare client din ziua data,
      // iau descrierile notificarilor
      for ($k = 0; $k < count($id_client); $k++) {

        $query = "SELECT descriere
                  FROM notificari
                  WHERE id_sender = " . $id_client[$k] . "
                  AND descriere LIKE 'CERERE%'
                  AND descriere LIKE '%" . $data_array[$i] . "'
                  AND citit = 0";
        
        $res = mysqli_query($link, $query);

        $descriere = array();
        while ($row = mysqli_fetch_array($res)) {
          array_push($descriere, $row[0]);
        }
?>
      <div class="div_cerere">
        <div class="text_cerere">
<?php
        // pentru fiecare client, daca stocul unei carti cerute e 0, atunci ok se face 0
        $ok = 1;

        for ($j = 0; $j < count($descriere); $j++) {
          if (strpos($descriere[$j], $data_array[$i])) {
            echo $descriere[$j];

            $poz1 = strpos($descriere[$j], '"');
            $poz2 = strpos($descriere[$j], '"', $poz1 + 1);
            $titlu = substr($descriere[$j], $poz1 + 1, $poz2 - $poz1 - 1);

            // stocul curent
            $query = "SELECT id_carte, stoc
                      FROM carte
                      WHERE titlu = '" . $titlu . "'
                      AND tip = 'fizica'";

            $res = mysqli_query($link, $query);

            $row = mysqli_fetch_array($res);
            $id_carte = $row[0];
            $stoc = $row[1];
?>
            <br>
<?php
            echo "Clientul cu id-ul: " . $id_client[$k];
?>
            <br>
<?php
          // numarul de carti restituite pana la data de ridicare din cerere
            $query = "SELECT COUNT(*)
                      FROM imprumut
                      WHERE id_carte = " . $id_carte . "
                      AND data_retur < '" . $data_array[$i] . "'
                      AND restituit = 0";
                      
            $res = mysqli_query($link, $query);

            $nr = mysqli_fetch_array($res)[0];

            echo "Stoc disponibil la data ridicarii: " . ($nr + $stoc);

            if ($nr + $stoc == 0) {
              $ok = 0;
            }
?>
          <br>
<?php
          }
?>
          <br>
<?php
        }
?>
</div>
      <form method="post" action="./requirements/bibl/confirm_borrow.php" class="acc_ref_form">
<?php
        if ($ok == 1) {
?>
        <input type="submit" name="accept<?php echo str_replace("-", "", $data_array[$i]) . $id_client[$k]; ?>" class="bibl_submit" value="Accepta">
<?php
        }
?>
        <input type="submit" name="refuz<?php echo str_replace("-", "", $data_array[$i]) . $id_client[$k]; ?>" class="bibl_submit" value="Refuza">
      </form>
      </div>
<?php
      }
    }
?>



    </div>
</div>

<div class="dreapta"> <!-- taxare clienti -->
    <div class="info_bibl">

    <h3>Taxare clienti</h3>

    <form action="./requirements/bibl/tax.php" method="post">
      <span>Client:</span>
      <select name="select_client_1" id="select_client_1" class="bibl_select">
        <option value="0">--Alege--</option>
<?php
        $query = "SELECT id_client, nume, prenume
                  FROM client
                  WHERE tip = 1";
        
        $res = mysqli_query($link, $query);

        $id_client = array();
        $nume = array();
        $prenume = array();

        while ($row = mysqli_fetch_array($res)) {
          array_push($id_client, $row[0]);
          array_push($nume, $row[1]);
          array_push($prenume, $row[2]);
        }

        for ($i = 0; $i < count($id_client); $i++) {
?>
          <option value="<?php echo $id_client[$i];?>">
<?php
            echo $prenume[$i] . ' ' . $nume[$i];
?>
          </option>
<?php
        }
?>
      </select>

      <span class="span_elem">Motiv:</span>
      <select name="select_motiv" id="select_motiv" class="bibl_select">
        <option value="0">--Alege--</option>
        <option value="1">Neprezentare la ridicare</option>
        <option value="2">Intarziere restituire</option>
        <option value="3">Intarziere plata</option>
      </select>

      <span class="span_elem" >Nr. zile:</span>
      <input type="number" name="nr_zile" id="nr_zile" min="1" max="15" class="nr_zile">

      <span class="span_elem" id="before">Descriere:</span>
      <input type="text" name="descriere1" class="descriere">

      <input type="submit" name="tax" value="Taxeaza" class="bibl_submit">
    </form>



    <h3>Anularea taxei</h3>

    <form action="./requirements/bibl/tax.php" method="post">
      <span>Client:</span>
      <select name="select_client_2" id="select_client_2" class="bibl_select">
        <option value="0">--Alege--</option>
<?php
        $query = "SELECT id_client, nume, prenume
                  FROM client
                  WHERE tip = 1";
        
        $res = mysqli_query($link, $query);

        $id_client = array();
        $nume = array();
        $prenume = array();

        while ($row = mysqli_fetch_array($res)) {
          array_push($id_client, $row[0]);
          array_push($nume, $row[1]);
          array_push($prenume, $row[2]);
        }

        for ($i = 0; $i < count($id_client); $i++) {
?>
          <option value="<?php echo $id_client[$i];?>">
<?php
            echo $prenume[$i] . ' ' . $nume[$i];
?>
          </option>
<?php
        }
?>
      </select>

      <span class="span_elem">Suma:</span>
      <input type="text" name="suma">

      <span class="span_elem">Descriere:</span>
      <input type="text" name="descriere2" class="descriere">
      
      <input type="submit" name="untax" value="Scade taxa" class="bibl_submit">
    </form>


<?php

      if (!isset($_SESSION['tax_error'])) {
        $_SESSION['tax_error'] = "";
      }

      if ($_SESSION['tax_error'] == "" || $_SESSION['tax_error'] == "Succes!") {
        $color = "green";
      }
      else {
        $color = "red";
      }
?>
      <p style="font-weight: bold; color: <?php echo $color;?>;">
<?php 
        echo $_SESSION['tax_error']; 
        $_SESSION['tax_error'] = '';
?>
      </p>

    </div>
</div>



<div class="dreapta"> <!-- cereri de imprumut -->
    <div class="info_bibl">

<?php
      $query = "SELECT DISTINCT id_imprumut
                FROM imprumut
                WHERE restituit = 0" . "
                ORDER BY 1";

      $res = mysqli_query($link, $query);

      $ids = array();
      while ($row = mysqli_fetch_array($res)) {
        array_push($ids, $row[0]);
      }
?>
      <ol>
<?php
      for ($i = 0; $i < count($ids); $i++) {
?>
        <li>
<?php

        $query = "SELECT id_client, id_carte, data_cerere
                  FROM imprumut
                  WHERE id_imprumut = " . $ids[$i];

        $res = mysqli_query($link, $query);

        $id_cl = 0;
        $id_carti = array();
        $data = '';

        while($row = mysqli_fetch_array($res)) {
          $id_cl = $row[0];
          array_push($id_carti, $row[1]);
          $data = $row[2];
        }

        $query = "SELECT nume, prenume
                  FROM client
                  WHERE id_client = " . $id_cl;
        
        $res = mysqli_query($link, $query);

        $row = mysqli_fetch_array($res);
        $n = $row[0];
        $pr = $row[1];

?>

        <form action="./requirements/bibl/returned.php" method="post">
          <h3>Imprumutul cu id-ul <?php echo $ids[$i]; ?></h3>
          <input type="submit" name="restituie<?php echo $i; ?>" id="restituie<?php echo $i; ?>" class="bibl_submit" value="Restituit">
        </form>

        <p>Clientul cu id-ul <?php echo $id_cl; ?>; Nume: <?php echo $n . " " . $pr?></p>

        <p><span style="text-decoration: underline;">Titluri imprumutate:</span> 
<?php

        for ($j = 0; $j < count($id_carti); $j++) {
          $query = "SELECT titlu
                    FROM carte
                    WHERE id_carte = " . $id_carti[$j];

          $res = mysqli_query($link, $query);

          $titlu = mysqli_fetch_array($res)[0];

          echo $titlu;

          if ($j < count($id_carti) - 1) {
            echo " / ";
          }
        }

?>
        </p>

        </li>
<?php
      }

?>
      </ol>
    </div>
</div>