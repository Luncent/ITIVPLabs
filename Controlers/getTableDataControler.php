<?php
    require_once "../DBOperations/tableOperations.php";
    require_once "../Utils/MySessionHandler.php";

class TableDataController{

    public static function selectData($otdel){
        if($otdel == "admin"){
            self::selectAdmin();
        }
        else{
            self::selectUser($otdel);
        }
    }
    public static function selectUser($otdel){
        if(MySessionHandler::errorHappened()){
            return;
        }
        try{
            if(self::searching()){
                $searchParam = $_GET["searchLine"];
                if(!empty($searchParam)){
                    $selectedRows =  ScheduleDao::uSearch($searchParam,$otdel);
                    $_SESSION["selectedRows"]=$selectedRows;
                }
                else{
                    self::uSelectAll($otdel);
                }
            }
            else{
                self::uSelectAll($otdel);
            }
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }

    public static function selectAdmin(){
        if(MySessionHandler::errorHappened()){
            return;
        }
        try{
            if(self::searching()){
                $searchParam = $_GET["searchLine"];
                if(!empty($searchParam)){
                    $selectedRows =  ScheduleDao::aSearch($searchParam);
                    $_SESSION["selectedRows"]=$selectedRows;
                }
                else{
                    self::aSelectAll();
                }
            }
            else{
                self::aSelectAll();
            }
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }


    //functions ------------------------------------------------------------
    public static function searching(){
        return isset($_GET["action"]) && $_GET["action"]=="search";
    }
    //admin
    public static function aSelectAll(){
        $selectedRows =  ScheduleDao::aSelectAllRows();
        if(!MySessionHandler::errorHappened()){
            $_SESSION["selectedRows"]=$selectedRows;
        }
        else{
            if(isset($_SESSION["message"]) && ($_SESSION["message"]=="Запись удалена")){
                $_SESSION["selectedRows"]=$selectedRows;
            } 
        }
    }
    //user
    public static function uSelectAll($otdel){
        $selectedRows =  ScheduleDao::uSelectAllRows($otdel);
        if(!MySessionHandler::errorHappened()){
            $_SESSION["selectedRows"]=$selectedRows;
        }
        else{
            if(isset($_SESSION["message"]) && ($_SESSION["message"]=="Запись удалена")){
                $_SESSION["selectedRows"]=$selectedRows;
            } 
        }
    }
}
?>