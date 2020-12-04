<?php

function connectdb() {
    $server = "myservername";        
    $username = "myusername";
    $password = "mypassword";
    $dbname = "mydatabasename";
    
    $link = mysqli_connect($server, $username, $password, $dbname);
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    return $link;
}

?>