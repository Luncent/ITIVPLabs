<?php
    include "pdo.php";
    $selectedRows=[];

    $method = $_SERVER["REQUEST_METHOD"];
    echo $method;

    switch($method){
        case "POST":
            if($_POST["action"]=="delete"){
                echo $_POST["action"];
                delete();
                selectAll();
            }
            else if($_POST["action"]=="add"){
                echo "adding";
                add();
                selectAll();
            }
            break;
        case "GET":
            if(isset($_GET["action"]) && $_GET["action"]=="search"){
                echo "searching";
                $searchLine = $_GET["searchLine"];
                if($searchLine==""){
                    selectAll();
                }
                else{
                    search($searchLine);
                }
            }
            else{
                echo "get";
                selectAll();
            }
            break;
    }

    function search($param){
        try{
            global $conn;
            echo $param;
            $query = $conn->prepare("SELECT * FROM test WHERE id= :param OR 
            name=:param OR phone=:param");
            $query->bindParam(":param", $param);
            $query->execute();
            global $selectedRows; 
            $selectedRows = $query->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $ex){
            echo "Ошибка при выборке данных ".$ex->getMessage();
        }
    }

    function delete(){
        try{
            global $conn;
            $id = $_POST["id"];
            echo "  ".$id;
            $query = $conn->prepare("DELETE FROM test WHERE id=?");
            $query->execute([$id]);
        }   
        catch(Exception $ex){
            echo "Ошибка при удалении ".$ex->getMessage();
        }
    }

    function selectAll(){
        try{
            global $conn;
            $query = $conn->prepare("SELECT * FROM test");
            $query->execute();
            global $selectedRows; 
            $selectedRows = $query->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $ex){
            echo "Ошибка при выборке данных ".$ex->getMessage();
        }
    }

    function add(){
        try{
            global $conn;
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $query = $conn->prepare("INSERT INTO test(name, phone) VALUES (?,?)");
            $query->execute([$name,$phone]);
        }
        catch(Exception $ex){
            echo "Ошибка при вставке данных". $ex->getMessage();
        }
    }


?>