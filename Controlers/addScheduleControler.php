<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/ScheduleDao.php";
    
    $dayOfWeek = $_POST["dayOfWeek"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $department_id = $_POST["department_id"];
    
    if(isEmpty($dayOfWeek,$startTime,$endTime,$department_id)){
        header("Location: ../views/index.php");
        return;
    }

    if(!empty($startTime) && !empty($endTime)){
        if(!timesValid($startTime,$endTime)){
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


    //functions---------------------
    function isEmpty($dayOfWeek,$startTime,$endTime,$department_id){
        if(empty($dayOfWeek) || empty($department_id)){
            MySessionHandler::addErrorMessage("Отдел, день недели обязательные поля для заполнения");
            return true;
        }
        if((empty($startTime) && !empty($endTime)) || ((!empty($startTime) && empty($endTime)))){
            MySessionHandler::addErrorMessage("Или заполните оба временных поля, или оставьте их пустыми");
            return true;
        }
        return false;
    }

    //валидация
    function timesValid($start,$end){
        if(!isValidTime($start) || !isValidTime($end)){
            MySessionHandler::addErrorMessage("Введены неверные значения. Допустимые форматы времени - HH:MM:SS или HH:MM<br>
                диапазон часов [0;23], диапазон минут [0;59],диапазон секунд [0;59],");
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