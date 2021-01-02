<?php
    require_once './dbconnect.php';
    require './functions.php';

    $link = connectdb();
    session_start();

    for ($i = 0; $i < count($_SESSION['books']); $i++) {
        
        if (isset($_POST['favs'.$_SESSION['books'][$i]])) {
            if ($_SESSION['infavs'][$_SESSION['books'][$i]] == 1) {
                $query = "DELETE FROM user_favourites WHERE id_client=" . $_SESSION['id']
                        . " AND id_carte=" . $_SESSION['books'][$i];

                if($res = mysqli_query($link, $query)) {
                    $_SESSION['errfavs'] = "No error: " . mysqli_affected_rows($link);
                }
                else {
                    $_SESSION['errfavs'] = "Error: " . mysqli_error($link);
                }
            }
            else if ($_SESSION['infavs'][$_SESSION['books'][$i]] == 0) {
                $query = "INSERT INTO user_favourites VALUES (" . $_SESSION['id']
                       . ", " . $_SESSION['books'][$i] . ")";

                if($res = mysqli_query($link, $query)) {
                    $_SESSION['errfavs'] = "No error: " . mysqli_affected_rows($link);
                }
                else {
                    $_SESSION['errfavs'] = "Error: " . mysqli_error($link);
                }
            }
            break;
        }
        cauta(0);
    }
    if($_SESSION['favslocation'] == "contulmeu") {
        header("Location: ../contulmeu.php");
    }
    else {
        header("Location: ../bibliotecafizica.php#favs" . $_SESSION['books'][$i]);
    }


?>