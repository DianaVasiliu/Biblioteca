<?php

function connectdb() {
    // $server = "sql200.epizy.com";        
    // $username = "epiz_27089899";
    // $password = "KOsernnGmUa";
    // $dbname = "epiz_27089899_bib";

    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblioteca";
    
    $link = mysqli_connect($server, $username, $password, $dbname);
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    return $link;
}

?>