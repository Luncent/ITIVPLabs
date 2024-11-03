<?php
    require_once "../Dao/TasksDao.php";
    require_once "../Utils/MySessionHandler.php";

class GetTasksController{

    public static function selectTasksEmployee($department_id,$employee_id){
        try{
            $manager = isset($_GET["managerName"]) && !empty($_GET["managerName"]) ? $_GET["managerName"] : null;
            if(isset($manager)){
                TaskDAO::trackTaskSearch($manager,$employee_id);
                $_SESSION["department_waiting_tasks"]=TaskDAO::searchTasks($manager);
            }
            else{
                $_SESSION["department_waiting_tasks"]=TaskDAO::getTasksByDepartmentWithoutAssignee($department_id,$employee_id);
            }
            $_SESSION["department_my_employeeTasks"]=TaskDAO::getTasksByAssignedUser($employee_id);
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }
    public static function selectTasksEmployer($employer_id){
        try{
            $_SESSION["department_my_employerTasks"]=TaskDAO::getTasksByCreator($employer_id);
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }
    public static function selectTasksAdmin(){
        try{
            $_SESSION["tasks_admin"]=TaskDAO::getAllTasks();
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }

    //functions ------------------------------------------------------------
    /*public static function searching(){
        return isset($_GET["action"]) && $_GET["action"]=="search";
    }
    //admin
    public static function selectAll($department_id){
        try{
            $selectedRows =  TaskDAO::selectAllRows($department_id);
            $_SESSION["selectedRows"]=$selectedRows;
        }
        catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
            return;
        }
    }*/
}
?>