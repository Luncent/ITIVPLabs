<?php 
require_once "../Utils/MySessionHandler.php";
require_once "../Dao/TasksDao.php";

if(empty($_POST["status"])){
    MySessionHandler::addErrorMessage("Ошибка при обновлении: присутствует пустое поле");
    header("Location: ../views/tasksPage.php");
    return;
}
if(MySessionHandler::hasSpecialCharacters($_POST["status"])){
    MySessionHandler::addErrorMessage("Использованы недопустимые символы");
    header("Location: ../views/tasksPage.php");
    return;
}
//проверка наличия расписания и обновление
try{
    $taskId = $_POST["taskId"];
    $status = $_POST["status"];
    
    TaskDAO::updateTaskStatus($taskId, $status);
    MySessionHandler::addErrorMessage("Запись обновлена");
}
catch(Exception $ex){
    MySessionHandler::addErrorMessage("Ошибка при обновлении задания. ".$ex->getMessage());
}
finally{
    header("Location: ../views/tasksPage.php");
}