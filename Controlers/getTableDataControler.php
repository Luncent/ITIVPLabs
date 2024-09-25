<?php
    require_once "../DBOperations/tableOperations.php";
    require_once "../Utils/sessionHadler.php";
    
    if(MySessionHandler::errorHappened()){
        return;
    }
    try{
        if(searching()){
            $searchParam = $_GET["searchLine"];
            if(!empty($searchParam)){
                $selectedRows =  ScheduleDao::search($searchParam);
                $_SESSION["selectedRows"]=$selectedRows;
            }
            else{
                selectAll();
            }
        }
        else{
            selectAll();
        }
    }catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
    }


    //functions ------------------------------------------------------------
    function searching(){
        return isset($_GET["action"]) && $_GET["action"]=="search";
    }

    function selectAll(){
        $selectedRows =  ScheduleDao::selectAllRows();
        if(!MySessionHandler::errorHappened()){
            $_SESSION["selectedRows"]=$selectedRows;
        }
        else{
            if(isset($_SESSION["message"]) && ($_SESSION["message"]=="Запись удалена")){
                $_SESSION["selectedRows"]=$selectedRows;
            } 
        }
    }
?>