<?php 
    require_once "../Utils/sessionHadler.php";
    require_once "../DBOperations/tableOperations.php";
    
    $dayOfWeek = $_POST["dayOfWeek"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $departmentName = $_POST["departmentName"];
    
    //валидация
    if(isEmpty($dayOfWeek,$startTime,$endTime,$departmentName)){
        header("Location: ../views/index.php");
        return;
    }

    if(!empty($startTime) && !empty($endTime)){
        if(!timesValid($startTime,$endTime)){
            header("Location: ../views/index.php");
            return;
        }
    }
    //

    //проверка наличия расписания и добавление
    try{
        $result = ScheduleDao::selectCertainRows($dayOfWeek,$departmentName);
        $count = isset($result) ? count($result) : 0;
        if($count>0){
            MySessionHandler::addErrorMessage("Расписание для указанного дня уже есть");
        }
        else{
            ScheduleDao::add($dayOfWeek,$startTime,$endTime,$departmentName);
            MySessionHandler::addErrorMessage("Запись добавлена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при добавлении расписания. ".$ex->getMessage());
    }
    finally{
        header("Location: ../views/index.php");
    }


    //functions---------------------
    function isEmpty($dayOfWeek,$startTime,$endTime,$departmentName){
        if(empty($dayOfWeek) || empty($departmentName)){
            MySessionHandler::addErrorMessage("Отдел, день недели обязательные поля для заполнения");
            return true;
        }
        if((empty($startTime) && !empty($endTime)) || ((!empty($startTime) && empty($endTime)))){
            MySessionHandler::addErrorMessage("Или заполните оба временных поля, или оставьте их пустыми");
            return true;
        }
        return false;
    }

    function timesValid($start,$end){
        if(!isValidTime($start) || !isValidTime($end)){
            MySessionHandler::addErrorMessage("Допустимые форматы времени - HH:MM:SS или HH:MM");
            return false;
        }
        // Создаем объекты DateTime
        $startTime = DateTime::createFromFormat('H:i:s', $start) ?: DateTime::createFromFormat('H:i', $start);
        $endTime = DateTime::createFromFormat('H:i:s', $end) ?: DateTime::createFromFormat('H:i', $end);
        // Сравниваем время
        if ($startTime > $endTime) {
            MySessionHandler::addErrorMessage("Начало смены не может быть позже ее окончания");
            return false;
        }
        return true;
    }

    function isValidTime($time) {
        // Проверка формата hh:mm:ss
        if (preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $time)) {
            return true; // Формат hh:mm:ss
        }
    
        // Проверка формата hh:mm
        if (preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d$/', $time)) {
            return true; // Формат hh:mm
        }
    
        return false; // Не соответствует ни одному формату
    }
?>