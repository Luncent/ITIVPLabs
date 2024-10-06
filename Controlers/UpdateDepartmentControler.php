<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/DepartmentsDao.php";
    
    if(empty($_POST["departmentName"])){
        MySessionHandler::addErrorMessage("Ошибка при обновлении: присутствует пустое поле");
        header("Location: ../views/departmentsPage.php");
        return;
    }
    if(MySessionHandler::hasSpecialCharacters($_POST["departmentName"])){
        MySessionHandler::addErrorMessage("Использованы недопустимые символы");
        header("Location: ../views/departmentsPage.php");
        return;
    }
    //проверка наличия расписания и обновление
    try{
        $departmentName = $_POST["departmentName"];
        $dep_id = $_POST["id"];

        //если меняется имя на тоже самое
        if(count(DepartmentsDao::searchByNameAndID($departmentName,$dep_id))>0){
            return;
        }

        $result = DepartmentsDao::searchByName($departmentName);
        $count = isset($result) ? count($result) : 0;
        if($count>0){
            MySessionHandler::addErrorMessage("Отдел с таким названием уже существует");
            return;
        }
        else{
            DepartmentsDao::update($dep_id,$departmentName);
            MySessionHandler::addErrorMessage("Запись обновлена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при обновлении расписания. ".$ex->getMessage());
    }
    finally{
        header("Location: ../views/departmentsPage.php");
    }

?>