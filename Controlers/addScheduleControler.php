<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/ScheduleDao.php";
    require_once "../Utils/InputValidator.php";
    
    $dayOfWeek = $_POST["dayOfWeek"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $department_id = $_POST["department_id"];
    
    if(InputValidator::isEmpty($dayOfWeek,$startTime,$endTime,$department_id)){
        header("Location: ../views/index.php");
        return;
    }

    if(!empty($startTime) && !empty($endTime)){
        if(!InputValidator::timesValid($startTime,$endTime)){
            header("Location: ../views/index.php");
            return;
        }
    }

    //проверка наличия расписания и добавление
    try{
        $result = ScheduleDao::selectCertainRows($dayOfWeek,$department_id);
        $count = isset($result) ? count($result) : 0;
        if($count>0){
            MySessionHandler::addErrorMessage("Расписание для указанного дня уже есть");
        }
        else{
            ScheduleDao::add($dayOfWeek,$startTime,$endTime,$department_id);
            MySessionHandler::addErrorMessage("Запись добавлена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при добавлении расписания. ".$ex->getMessage());
    }
    finally{
        header("Location: ../views/index.php");
    }
?>