<?php 
    require_once "../Utils/MySessionHandler.php";
    
    
    function getConnection(){
        //try{
            $servername = "localhost";
            $userName="root";
            $password = "root";
            $database = "db1";
            $conn = new PDO("mysql:host=$servername; dbname=$database", $userName, $password);
            return $conn;
        //}
        /*catch(Exception $ex){
            addErrorMessage("Ошибка соединения с бд: ".$ex->getMessage());
        }*/
    }
?>