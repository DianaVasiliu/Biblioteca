<?php
    require_once 'dbconnect.php';
    require 'functions.php';

    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    $query = "SELECT DISTINCT id_carte
              FROM carte 
              WHERE BINARY tip = 'fizica'";

    $res = mysqli_query($link, $query);
    $ids = array();

    while ($row = mysqli_fetch_array($res)) {
      array_push($ids, $row[0]);
    }

    $bookid = 0;
    for ($i = 0; $i < count($ids); $i++) {
        $name = 'rating' . $ids[$i];
        if (isset($_POST[$name])) {
          $bookid = $ids[$i];
          $nota = mysqli_real_escape_string($link, $_POST[$name]);
          break;
        }
    }

    if ($nota != 0) {
      $query = "SELECT nota
                FROM reviews
                WHERE id_client = " . $_SESSION['id'] . 
              " AND id_carte = " . $bookid;

      $res = mysqli_query($link, $query);

      if (mysqli_num_rows($res) != 0) {
        // UPDATE
        $query = "UPDATE reviews
                SET nota = " . $nota .  
              " WHERE id_client = " . $_SESSION['id'] . 
              " AND id_carte = " . $bookid;

        update_rating($link, $query, $bookid);
      }
      else {
        // INSERT
        $query = "INSERT INTO reviews VALUES
                (" . $_SESSION['id'] . 
                ", " . $bookid . 
                ", " . $nota .
                ")";

        update_rating($link, $query, $bookid);
      }   
    }

    header("Location: ../bibliotecafizica.php");

?>