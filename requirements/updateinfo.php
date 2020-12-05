<?php
    require_once 'dbconnect.php';
    session_start();

    $link = connectdb();

    if (isset($_POST['upemail'])) {
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $parola = mysqli_real_escape_string($link, $_POST['pw']);
        $ok = 1;

        $query = "SELECT parola FROM client WHERE BINARY email = '" . $_SESSION['email'] . "'";
        $res = mysqli_query($link, $query);
        $hash = mysqli_fetch_array($res)[0];

        if (password_verify($parola, $hash)) {
            $query = "SELECT 1 FROM client WHERE BINARY email = '" . $email . "'";

            $temp = array();

            if ($res = mysqli_query($link, $query)) {

                while($row = mysqli_fetch_array($res)) {
                    array_push($temp, row[0]);
                }

                if (count($temp) != 0) {
                    $_SESSION['erroremail'] = 'Email deja existent.';
                    $ok = 0;
                }
                else {
                    $ok = 1;
                }

            }
            else {
                $_SESSION['erroremail'] = 'Nu a putut fi schimbat email-ul.';
            }


            if ($ok == 1) {
                $query = "UPDATE client SET email='" . $email . "' WHERE BINARY email = '" . $_SESSION['email'] . "'";

                if ($res = mysqli_query($link, $query)) {
                    $_SESSION['erroremail'] = 'Succes';
                    $_SESSION['email'] = $email;
                }
                else {
                    echo mysqli_error($link);
                }
            }
        }
        else {
            $_SESSION['erroremail'] = 'Nu a putut fi schimbat email-ul.';
        }
    }
    elseif(isset($_POST['upname'])) {
        $lastname = mysqli_real_escape_string($link, $_POST['lastname']);
        $firstname = mysqli_real_escape_string($link, $_POST['firstname']);

        $query = "UPDATE client SET nume='" . $lastname . "', prenume='" . $firstname . "' WHERE BINARY email = '" . $_SESSION['email'] . "'";

        if ($res = mysqli_query($link, $query)) {
            $_SESSION['errorname'] = 'Succes';
            $_SESSION['lastname'] = $lastname;
            $_SESSION['firstname'] = $firstname;
        }
        else {
            $_SESSION['errorname'] = 'Nu a putut fi schimbat numele.';
        }
    }
    elseif(isset($_POST['uppw'])) {
        $parola_v = $_POST['oldpw'];
        $parola1 = $_POST['newpw1'];
        $parola2 = $_POST['newpw2'];

        $query = "SELECT parola FROM client WHERE BINARY email = '" . $_SESSION['email'] . "'";
        $res = mysqli_query($link, $query);
        $hash = mysqli_fetch_array($res)[0];

        if (password_verify($parola_v, $hash)) {
            if (strcmp($parola1,$parola2) == 0) {
                $hash2 = password_hash($parola1, PASSWORD_DEFAULT);

                $query = "UPDATE client SET parola='" . $hash2 . "' WHERE BINARY email = '" . $_SESSION['email'] . "'";

                if ($res = mysqli_query($link, $query)) {
                    $_SESSION['errorpw'] = 'Succes';
                }
                else {
                    $_SESSION['errorpw'] = 'Nu a putut fi schimbata parola. Nu s-a putut face update';
                }
            }
            else {
                $_SESSION['errorpw'] = 'Parolele noi nu coincid.';
            }
        }
        else {
            $_SESSION['errorpw'] = 'Nu a putut fi schimbata parola. Parola veche nu e buna';
        }
    }
    elseif(isset($_POST['upaddress'])) {    
        $street = mysqli_real_escape_string($link, $_POST['street']);
        $number = mysqli_real_escape_string($link, $_POST['number']);
        $city = mysqli_real_escape_string($link, $_POST['city']);
        $county = mysqli_real_escape_string($link, $_POST['county']);

        if ($county != "0") {
            $new_address = $street . ' ' . $number . ' ' . $city . ' ' . $county;

            $query = "UPDATE client SET adresa='" . $new_address . "' WHERE BINARY email='" . $_SESSION['email'] . "'";
    
            if ($res = mysqli_query($link, $query)) {
                $_SESSION['erroraddress'] = 'Succes';
            }
            else {
                $_SESSION['erroraddress'] = 'Nu a putut fi actualizata adresa.';
            }
        }
        else {
            $_SESSION['erroraddress'] = 'Nu a putut fi actualizata adresa. Judetul este obligatoriu.';
        }
    }
    else if (isset($_POST['confirm'])) {
        $query = "UPDATE client SET activ=0 WHERE BINARY email='" . $_SESSION['email'] . "'";

        if ($res = mysqli_query($link, $query)) {
            $_SESSION['err'] = 'Succes';
            $_SESSION['loggedin'] = false;
        }
        else {
            $_SESSION['err'] = 'Something went wrong. Please try again later.';
        }
    }

    if ($_SESSION['loggedin'] == true) {
        header("Location: ../contulmeu.php");      
    }
    else {
        header("Location: ../paginaprincipala.php");
    }

?>