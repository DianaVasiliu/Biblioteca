<?php
    require_once 'dbconnect.php';
    $link = connectdb();
    mysqli_set_charset($link , "utf8");

    session_start();

    if (isset($_POST['borrowreq']) && $_POST['data_impr'] != '' && $_POST['carte1'] != 0) {
        
        $captcha_err = '';
        $captcha = trim($_POST['captcha_challenge']);

        $id_carti = array();
        array_push($id_carti, trim(mysqli_real_escape_string($link, $_POST['carte1'])));

        if ($captcha == trim($_SESSION['captcha_text'])) {

            if (isset($_POST['carte2']) && $_POST['carte2'] != 0) {
                array_push($id_carti, trim(mysqli_real_escape_string($link, $_POST['carte2'])));
                if (isset($_POST['carte3']) && $_POST['carte3'] != 0) {
                    array_push($id_carti, trim(mysqli_real_escape_string($link, $_POST['carte3'])));
                    if (isset($_POST['carte4']) && $_POST['carte4'] != 0) {
                        array_push($id_carti, trim(mysqli_real_escape_string($link, $_POST['carte4'])));
                        if (isset($_POST['carte5']) && $_POST['carte5'] != 0) {
                            array_push($id_carti, trim(mysqli_real_escape_string($link, $_POST['carte5'])));
                        }
                    }
                }
            }
            
            for ($i = 0; $i < count($id_carti); $i++) {
                // selectez titlurile cartilor cerute
                $query = "SELECT titlu
                          FROM carte
                          WHERE id_carte = " . $id_carti[$i];

                $res = mysqli_query($link, $query);

                $titlu = mysqli_fetch_array($res)[0];
                
                // trimit cererea la toti bibliotecarii
                $query = "SELECT id_client 
                          FROM client
                          WHERE tip = 2";

                $res = mysqli_query($link, $query);

                while ($row = mysqli_fetch_array($res)) {

                    $query = "INSERT INTO notificari (id_client, id_sender, descriere) VALUES
                                (" . $row[0] . ", " 
                                . $_SESSION['id'] . ", "
                                . " 'CERERE: imprumutul cartii cu titlul \"". $titlu ."\" cu ridicare la data de " . $_POST['data_impr'] . "')";
                    
                    $res1 = mysqli_query($link, $query);
                }
            }

            $_SESSION['submit_borrow_message'] = 'Cerere trimisa cu succes!';
        }
        else {
            $captcha_err = "Captcha incorect!";
        }

        $_SESSION['captcha_err_borrow'] = $captcha_err;

    }

    header("Location: ../contulmeu.php");

?>