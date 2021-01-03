<?php

    require_once '../dbconnect.php';

    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    $query = "SELECT DISTINCT id_imprumut
              FROM imprumut
              WHERE restituit = 0" . "
              ORDER BY 1";

    $res = mysqli_query($link, $query);

    $ids = array();
    while ($row = mysqli_fetch_array($res)) {
      array_push($ids, $row[0]);
    }


    for ($i = 0; $i < count($ids); $i++) {
      if (isset($_POST['restituie' . $i])) {

        $query = "UPDATE imprumut
                  SET restituit = 1
                  WHERE id_imprumut = " . $ids[$i];

        $res = mysqli_query($link, $query);

        break;
      }
    }

    header("location: ../../contulmeu.php");

?>