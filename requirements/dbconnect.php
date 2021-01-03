<?php

function connectdb() {

    $server = "servername";        
    $username = "user_name";
    $password = "password";
    $dbname = "db_name";
    
    $link = mysqli_connect($server, $username, $password, $dbname);
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    return $link;
}

?>