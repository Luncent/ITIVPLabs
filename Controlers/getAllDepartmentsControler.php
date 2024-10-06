<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/DepartmentsDao.php";
    
    try{
        if(!empty($_GET["searchLine"])){
            $selectedRows =  DepartmentsDao::partialSearch($_GET["searchLine"]);
            $_SESSION["departments"]=$selectedRows;
        }
        else{
            $_SESSION["departments"] = DepartmentsDao::readAll();
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка. ".$ex->getMessage());
        header("Location: ../views/registrationPage.php");
        return;
    }

?>