<?php 
    $servername = "localhost";
    $userName="root";
    $password = "root";
    $database = "db1";

    $conn;
    try{
        $conn = new PDO("mysql:host=$servername; dbname=$database", $userName, $password);
        //echo "connected";
    }
    catch(Exception $ex){
        echo $ex->getMessage();
    }
?>