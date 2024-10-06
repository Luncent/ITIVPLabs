<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/DepartmentsDao.php";
    
    $departmentName = $_POST["departmentName"];

    if(empty($departmentName)){
        MySessionHandler::addErrorMessage("Заполните поля");
        header("Location: ../views/departmentsPage.php");
        return;
    }
    if(MySessionHandler::hasSpecialCharacters($departmentName)){
        MySessionHandler::addErrorMessage("Использованы недопустимые символы");
        header("Location: ../views/departmentsPage.php");
        return;
    }
    //проверка наличия расписания и добавление
    try{
        $result = DepartmentsDao::searchByName($departmentName);
        $count = isset($result) ? count($result) : 0;
        if($count>0){
            MySessionHandler::addErrorMessage("Отдел с таким названием уже существует");
        }
        else{
            DepartmentsDao::create($departmentName);
            MySessionHandler::addErrorMessage("Запись добавлена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при добавлении расписания. ".$ex->getMessage());
    }
    finally{
        header("Location: ../views/departmentsPage.php");
    }

    //functions---------------------
?>