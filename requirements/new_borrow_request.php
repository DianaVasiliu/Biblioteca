<?php
    session_start();

    if (isset($_POST['borrowreq']) && $_POST['data_impr'] != '' && $_POST['carte'] != 0) {
        $captcha_err = '';
        $captcha = trim($_POST['captcha_challenge']);

        if ($captcha == trim($_SESSION['captcha_text'])) {
            // SEND NOTIFICATION TO LIBRARIAN
            // <=> ADD NOTIFICATION IN DB
            // + verifica daca mai este cartea in stoc



        
        }
        else {
            $captcha_err = "Captcha incorect!";
        }

        $_SESSION['captcha_err_borrow'] = $captcha_err;

        }

        header("Location: ../contulmeu.php");

?>