<?php
    require_once "../Dao/ScheduleDao.php";
    require_once "../Utils/MySessionHandler.php";

class GetScheduleDataController{

    public static function selectData($department_id){
        if(MySessionHandler::errorHappened()){
            return;
        }
        try{
            $searchParam = isset($_GET["searchLine"])?trim($_GET["searchLine"]):"";
            if(!empty($searchParam)){
                $selectedRows =  ScheduleDao::search($searchParam,$department_id);
                $_SESSION["selectedRows"]=$selectedRows;
            }
            else{
                self::selectAll($department_id);
            }
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }
    
    //TODO delete
    //functions ------------------------------------------------------------
    public static function searching(){
        return isset($_GET["action"]) && $_GET["action"]=="search";
    }
    //admin
    public static function selectAll($department_id){
        try{
            $selectedRows =  ScheduleDao::selectAllRows($department_id);
            $_SESSION["selectedRows"]=$selectedRows;
        }
        catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
            return;
        }
    }
}
?>