<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/TasksDao.php";
    
    $title = $_POST["title"];
    $description = $_POST["description"];
    $department_id = $_POST["department_id"];
    $created_by = $_POST["created_by"];

    if(empty($title) || empty($description)){
        MySessionHandler::addErrorMessage("Заполните поля");
        header("Location: ../views/tasksPage.php");
        return;
    }
    if(MySessionHandler::hasSpecialCharacters($title) ||
    MySessionHandler::hasSpecialCharacters($description)){
        MySessionHandler::addErrorMessage("Использованы недопустимые символы");
        header("Location: ../views/tasksPage.php");
        return;
    }
    try{
        $result = TaskDAO::getTasksByTitle($title, $department_id);
        $count = isset($result) ? count($result) : 0;
        if($count>0){
            MySessionHandler::addErrorMessage("Задание с таким названием уже существует");
        }
        else{
            TaskDAO::createTask($title, $description, $department_id, $created_by);
            MySessionHandler::addErrorMessage("Запись добавлена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при добавлении задания. ".$ex->getMessage());
    }
    finally{
        header("Location: ../views/tasksPage.php");
    }