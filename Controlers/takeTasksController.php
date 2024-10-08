<?php 
    require_once "../Dao/TasksDao.php";
    require_once "../Utils/MySessionHandler.php";

    $taskId = $_POST["taskId"];
    $userId = $_POST["userId"];

    try{
        if(TaskDAO::getTaskById($taskId)->assignee_login!=null){
            MySessionHandler::addErrorMessage("Задание уже взято");
            header("Location: ../views/tasksPage.php");
            return;
        }
        else{
            TaskDAO::assignTaskToUser($taskId, $userId);
            MySessionHandler::addErrorMessage("Задание взято");
            header("Location: ../views/tasksPage.php");
            return;
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка взятии задания. ".$ex->getMessage());
        header("Location: ../views/tasksPage.php");
        return;
    }
