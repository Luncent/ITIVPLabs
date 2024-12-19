<?php 
    require_once "../Utils/MySessionHandler.php";
    
    
    function getConnection(){
        $servername = "localhost";
        $userName="root";
        $password = "";
        $database = "db1";
        $conn = new PDO("mysql:host=$servername; dbname=$database", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
?>