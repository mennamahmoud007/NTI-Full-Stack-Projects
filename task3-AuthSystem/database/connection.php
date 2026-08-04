<?php

    $server = 'localhost';
    $userName = 'root';
    $pass = "";
    $dbName = 'university';

    $conn = mysqli_connect($server, $userName, $pass, $dbName);
    if (!$conn){
        //die for close program 
        //+type of error 
         die("Connection Failed: " . mysqli_connect_error());
    }

?>