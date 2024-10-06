<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/DepartmentsDao.php";
    
    $id = $_POST["id"];

    try{
        $deletedRows = DepartmentsDao::delete($id);
        //TODO считать количество удаленных строк чтоы обнаружить удалено 0 строк
        if(isset($deletedRows) && ($deletedRows==0)){
            MySessionHandler::addErrorMessage("Запись отсутствует в бд");
        }
        else{
            MySessionHandler::addErrorMessage("Запись удалена");
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при удалении отдела. ".$ex->getMessage());
    }
        
    header("Location: ../views/departmentsPage.php");
    return;
?>