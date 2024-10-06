<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/ScheduleDao.php";
    
    $id = $_POST["id"];

    try{
        $deletedRows = ScheduleDao::delete($id);
        //TODO считать количество удаленных строк чтоы обнаружить удалено 0 строк
        if(isset($deletedRows) && ($deletedRows==0)){
            MySessionHandler::addErrorMessage("Запись отсутствует в бд");
        }
        else{
            MySessionHandler::addErrorMessage("Запись удалена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при удалении расписания. ".$ex->getMessage());
    }
        
    header("Location: ../views/index.php");
    return;
?>