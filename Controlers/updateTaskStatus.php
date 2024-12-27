<?php 
require_once "../Utils/MySessionHandler.php";
require_once "../Dao/TasksDao.php";
require_once "../Utils/InputValidator.php";

if(empty($_POST["status"])){
    MySessionHandler::addErrorMessage("Ошибка при обновлении: присутствует пустое поле");
    header("Location: ../views/tasksPage.php");
    return;
}
// if(InputValidator::correctDescription($_POST["status"])){
//     MySessionHandler::addErrorMessage("Использованы недопустимые символы");
//     header("Location: ../views/tasksPage.php");
//     return;
// }
$userLogin = $_POST["userLogin"];
// if(!isset($_COOKIE[$userLogin]))
// {
//     MySessionHandler::addErrorMessage("Не выбран режим работы");
//     header("Location: ../views/tasksPage.php");
//     return;
// }
//проверка наличия расписания и обновление
try{
    $taskId = $_POST["taskId"];
    $status = trim($_POST["status"]);
    // var_dump($taskId);
    // die;
    TaskDAO::updateTaskStatus($taskId, $status);
    MySessionHandler::addErrorMessage("Запись обновлена");
}
catch(Exception $ex){
    MySessionHandler::addErrorMessage("Ошибка при обновлении задания. ".$ex->getMessage());
}
finally{
    header("Location: ../views/tasksPage.php");
}