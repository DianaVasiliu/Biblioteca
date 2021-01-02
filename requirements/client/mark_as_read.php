<?php
    require_once '../dbconnect.php';

    $link = connectdb();
    session_start();

    for ($i = 0; $i < count($_SESSION['id_notif']); $i++) {
        if (isset($_POST['mark_as_read' . $_SESSION['id_notif'][$i]])) {
          
          $query = "UPDATE notificari
                    SET citit = 1
                    WHERE id_notificare = " . $_SESSION['id_notif'][$i];

          $res = mysqli_query($link, $query);

          break;
        }
    }

    header("Location: ../../contulmeu.php");
?>