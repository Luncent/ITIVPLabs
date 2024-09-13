<?php
    require_once "pdo.php";
    
    function search($param){
        try{
            $conn = getConnection();
            echo $param;
            $query = $conn->prepare("SELECT * FROM schedule WHERE id= :param OR 
            startTime=:param OR endTime=:param OR departmentName=:param OR dayOfWeek=:param");
            $query->bindParam(":param", $param);
            $query->execute();
            $selectedRows = $query->fetchAll(PDO::FETCH_OBJ); 
            return $selectedRows; 
        }
        catch(Exception $ex){
            addErrorMessage("Ошибка при выборке данных ".$ex->getMessage());
        }
    }

    function delete(){
        try{
            $conn = getConnection();
            $id = $_POST["id"];
            echo "  ".$id;
            $query = $conn->prepare("DELETE FROM schedule WHERE id=?");
            $query->execute([$id]);
            $affectedRows = $query->rowCount();
            return $affectedRows;
        }   
        catch(Exception $ex){
            addErrorMessage("Ошибка при удалении ".$ex->getMessage());
        }
    }

    function selectAllRows(){
        try{
            $conn = getConnection();
            $query = $conn->prepare("SELECT * FROM schedule");
            $query->execute();
            global $selectedObjs; 
            return $selectedObjs = $query->fetchAll(PDO::FETCH_OBJ); 
        }
        catch(Exception $ex){
            addErrorMessage("Ошибка при выборке данных ".$ex->getMessage());
        }
    }

    function selectCertainRows($dayOfWeek, $departmentName){
        try{
            $conn = getConnection();
            $query = $conn->prepare("SELECT * FROM schedule WHERE departmentName=?
             AND dayOfWeek=?");
            $query->execute([$departmentName,$dayOfWeek]);
            $selectedObjs = $query->fetchAll(PDO::FETCH_OBJ); 
            return $selectedObjs; 
        }
        catch(Exception $ex){
            addErrorMessage("Ошибка при выборке данных ".$ex->getMessage());
        }
    }

    function add($dayOfWeek, $startTime,$endTime,$departmentName){
        try{
            $conn = getConnection();
            $query = $conn->prepare("INSERT INTO schedule(dayOfWeek, startTime, endTime, departmentName)
             VALUES (?,?,?,?)");
            $query->execute([$dayOfWeek,$startTime,$endTime,$departmentName]);
        }
        catch(Exception $ex){
            addErrorMessage("Ошибка при вставке данных". $ex->getMessage());
        }
    }
?>