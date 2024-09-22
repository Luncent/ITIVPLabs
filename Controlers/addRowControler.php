<?php 
    require_once "../Utils/sessionHadler.php";
    require_once "../DBOperations/tableOperations.php";

    /*if(errorHappened()){
        header("Location: ../views/index.php");
        return;
    }*/
    
    $dayOfWeek = $_POST["dayOfWeek"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $departmentName = $_POST["departmentName"];

    if(isEmpty($dayOfWeek,$startTime,$endTime,$departmentName)){
        header("Location: ../views/index.php");
        return;
    }


    if(!empty($start) && !empty($endTime)){
        if(!timesValid($startTime,$endTime)){
            header("Location: ../views/index.php");
            return;
        }
    }

    $result = selectCertainRows($dayOfWeek,$departmentName);
    $count = isset($result) ? count($result) : 0;
    if(!errorHappened()){
        if($count>0){
            addErrorMessage("Расписание для указанного дня уже есть");
        }
        else{
            add($dayOfWeek,$startTime,$endTime,$departmentName);
        }
    }
    header("Location: ../views/index.php");
    return;

    function isEmpty($dayOfWeek,$startTime,$endTime,$departmentName){
        if(empty($dayOfWeek) || empty($departmentName)){
            addErrorMessage("Отдел, день недели обязательные поля для заполнения");
            return true;
        }
        if((empty($startTime) && !empty($endTime)) || ((!empty($startTime) && empty($endTime)))){
            addErrorMessage("Или заполните оба временных поля, или оставьте их пустыми");
            return true;
        }
        return false;
    }

    function timesValid($start,$end){
        if(!isValidTime($start) || !isValidTime($end)){
            addErrorMessage("Допустимые форматы времени - HH:MM:SS или HH:MM");
            return false;
        }
        if($start>$end){
            addErrorMessage("Начало смены не может быть позже ее окончания");
            return false;
        }
        return true;
    }

    function isValidTime($time) {
        // Регулярное выражение для проверки формата HH:MM:SS
        return preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $time);
    }
?>