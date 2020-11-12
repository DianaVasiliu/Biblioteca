<?php
require_once 'dbconnect.php';

$mysqlconn = connectdb();

if (isset($_POST['uploadfile'])) {
    $firstname = trim($_POST['authorfirstname']);
    $lastname = trim($_POST['authorlastname']);
    $filename = trim($_POST['filename']);
    $id = array();
    $id2;

    $query = "SELECT id_autor "
            ."FROM autor "
            ."WHERE lower(nume)='"
            . strtolower($lastname)
            . "' AND lower(prenume)='"
            . strtolower($firstname)
            . "'";
    
    $res = mysqli_query($mysqlconn, $query);
    while($row = mysqli_fetch_array($res)) {
        array_push($id, $row[0]);
    }


    if (count($id) == 0) {
        $query = "INSERT INTO autor (nume, prenume) VALUES ('"
                . ucfirst($lastname)
                . "', '"
                . ucfirst($firstname)
                . "')";
        
        $res = mysqli_query($mysqlconn, $query);

        $query = "SELECT id_autor FROM autor ORDER BY id_autor DESC";
        $res = mysqli_query($mysqlconn, $query);

        $row = mysqli_fetch_array($res);
        $id2 = $row[0];
        
    }
    else {
        $id2 = $id[0];
    }

    
    $query = "INSERT INTO carte (titlu, id_autor, categorie, tip, descriere, url_fisier) VALUES ('"
    . trim($_POST["booktitle"])
    . "', "
    . $id2
    . ", '"
    . $_POST["categorie"]
    . "', 'digitala', '"
    . trim($_POST['description'])
    . "', '"
    . $filename
    . "')";
    
    if($res = mysqli_query($mysqlconn, $query)) {
        $error = "OK";
    }
    else{
        $error = "Error";
    }
    mysqli_close($mysqlconn);
    header("Location: ../bibliotecadigitala.php");
}


?>