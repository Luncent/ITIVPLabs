<?php 
require_once "../Utils/MySessionHandler.php";
require_once "../Dao/ScheduleDao.php";
require_once "../Utils/InputValidator.php";

$id = $_POST["id"];
$day = $_POST["day"];
$startTime = $_POST["startTime"];
$endTime = $_POST["endTime"];

if(InputValidator::timeIsEmpty($startTime,$endTime)){
    header("Location: ../views/index.php");
    return;
}

if(!empty($startTime) && !empty($endTime)){
    if(!InputValidator::timesValid($startTime,$endTime)){
        header("Location: ../views/index.php");
        return;
    }
}

try{
    $result = ScheduleDao::update($id,$day,$startTime,$endTime);
    MySessionHandler::addErrorMessage("Запись обновлена");
}
catch(Exception $ex){
    MySessionHandler::addErrorMessage("Ошибка при обновлении расписания. ".$ex->getMessage());
}
finally{
    header("Location: ../views/index.php");
}