<?php
require_once './dbconnect.php';

$mysqlconn = connectdb();

if (isset($_POST['uploadfile'])) {
    // $firstname = trim($_POST['authorfirstname']);
    // $lastname = trim($_POST['authorlastname']);
    $authors = explode(",", trim($_POST['authornames']));
    $filename = trim($_POST['filename']);
    $id = array();
    $id2 = array();       // id-ul autorului curent

    $firstname = array(); 
    $lastname = array();

    $query = "SELECT id_carte FROM carte ORDER BY id_carte DESC";
    $res = mysqli_query($mysqlconn, $query);
    $row = mysqli_fetch_array($res);
    $id_carte = $row[0] + 1;

    for ($i = 0; $i < count($authors); $i++) {
        $fn = "";
        $name = explode(" ", trim($authors[$i]));
        for ($j = 0; $j < count($name) - 1; $j++) {
            $fn = $fn . ' ' . $name[$j];
        }
        array_push($firstname, $fn);
        array_push($lastname, $name[count($name) - 1]);

        $query = "SELECT id_autor "
                ."FROM autor "
                ."WHERE lower(nume)='"
                . strtolower($lastname[$i])
                . "' AND lower(prenume)='"
                . strtolower($firstname[$i])
                . "'";

        $res = mysqli_query($mysqlconn, $query);
        while($row = mysqli_fetch_array($res)) {
            array_push($id, $row[0]);
        }

        if (count($id) == 0) {
            $query = "INSERT INTO autor (nume, prenume) VALUES ('"
                    . ucfirst($lastname[$i])
                    . "', '"
                    . ucwords($firstname[$i])
                    . "')";
            
            $res = mysqli_query($mysqlconn, $query);
    
            $query = "SELECT id_autor FROM autor ORDER BY id_autor DESC";
            $res = mysqli_query($mysqlconn, $query);
    
            $row = mysqli_fetch_array($res);
            array_push($id2, $row[0]);   
        }
        else {
            array_push($id2, $id[0]);
        }
    }
    
    $query = "SELECT id_categorie FROM categorie WHERE categorie = '" . $_POST["categorie"] . "'";

    $res = mysqli_query($mysqlconn, $query);
    $row = mysqli_fetch_array($res);
    $index_cat = $row[0];

    $query = "INSERT INTO carte (titlu, id_categorie, tip, descriere, url_fisier) VALUES ('"
    . trim($_POST["booktitle"])
    . "', "
    . $index_cat
    . ", 'digitala', '"
    . trim($_POST['description'])
    . "', '"
    . $filename
    . "')";

    $res = mysqli_query($mysqlconn, $query);

    for ($i = 0; $i < count($id2); $i++) {
        $query = "INSERT INTO carte_autor VALUES (" . $id_carte . ", " . $id2[$i] . ")";
        if ($res = mysqli_query($mysqlconn, $query)){
            $error = "OK";
        }
        else{
            $error = "Error";
        }
    }
    
    mysqli_close($mysqlconn);
    header("Location: ../bibliotecadigitala.php");
}


?>