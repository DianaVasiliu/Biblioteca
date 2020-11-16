<?php
    session_start();

    $_SESSION["loggedin"] = false;
    $_SESSION["id"] = null;
    $_SESSION["username"] = null;
    $_SESSION["email"] = null;

    header("Location: ../paginaprincipala.php");
?>