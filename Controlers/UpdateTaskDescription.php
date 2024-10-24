<?php 
require_once "../Utils/MySessionHandler.php";
require_once "../Dao/TasksDao.php";
require_once "../Utils/InputValidator.php";

if(empty($_POST["description"])){
    MySessionHandler::addErrorMessage("Ошибка при обновлении: присутствует пустое поле");
    header("Location: ../views/tasksPage.php");
    return;
}
if(InputValidator::correctDescription($_POST["description"])){
    MySessionHandler::addErrorMessage("Использованы недопустимые символы");
    header("Location: ../views/tasksPage.php");
    return;
}
//проверка наличия расписания и обновление
try{
    $taskId = $_POST["taskId"];
    $description = $_POST["description"];
    
    TaskDAO::updateTaskDescription($taskId, $description);
    MySessionHandler::addErrorMessage("Запись обновлена");
}
catch(Exception $ex){
    MySessionHandler::addErrorMessage("Ошибка при обновлении задания. ".$ex->getMessage());
}
finally{
    header("Location: ../views/tasksPage.php");
}