<?php 
    require_once "../Dao/TasksDao.php";
    require_once "../Utils/MySessionHandler.php";

    $taskId = htmlspecialchars($_POST["taskId"]);
    $userId = htmlspecialchars($_POST["userId"]);
    $userLogin = htmlspecialchars($_POST["userLogin"]);
    try{
        if(TaskDAO::getTaskById($taskId)->assignee_login!=null){
            MySessionHandler::addErrorMessage("Задание уже взято");
            header("Location: ../views/tasksPage.php");
            return;
        }
        else if(!isset($_COOKIE[$userLogin]))
        {
            MySessionHandler::addErrorMessage("Не выбран режим работы");
            header("Location: ../views/tasksPage.php");
            return;
        }
        else if(!password_verify('remote',$_COOKIE[$userLogin]) && !password_verify('office',$_COOKIE[$userLogin]))
        {
            MySessionHandler::addErrorMessage("Не выбран режим работы");
            header("Location: ../views/tasksPage.php");
            return;
        }
        else{
            $status = password_verify('remote',$_COOKIE[$userLogin]) ? 'На удалёнку' : 'Работа в офисе';
            TaskDAO::assignTaskToUser($taskId, $userId,$status);
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
