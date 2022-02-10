<?php

function db_connect() {
    $connect = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if($connect->connect_error) {
        die("Error connecting");
        exit;
    } 
    return $connect;
}

function db_disconnect($connect) {
    if(isset($connect)) {
        $connect->close();
    }
}


?>