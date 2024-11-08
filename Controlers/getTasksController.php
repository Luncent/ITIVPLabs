<?php
    require_once "../Dao/TasksDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

class GetTasksController{

    public static function selectTasksEmployee($department_id,$employee_id){
        try{
            $manager = InputFilter::filterString("managerName");
            $title = InputFilter::filterString("title");
            $descr = InputFilter::filterString("descr");
            if(empty($manager) && empty($title) && empty($descr)){
                $_SESSION["department_waiting_tasks"]=TaskDAO::getTasksByDepartmentWithoutAssignee($department_id,$employee_id);
            }
            else{
                if(InputValidator::hasSpecialCharacters($manager) || InputValidator::hasSpecialCharacters($title)
                            || InputValidator::hasSpecialCharacters($descr)){
                    MySessionHandler::addErrorMessage("спец-символы запрещены");
                    $_SESSION["department_waiting_tasks"]=TaskDAO::getTasksByDepartmentWithoutAssignee($department_id,$employee_id);
                }
                else{
                    TaskDAO::trackTaskSearch($manager,$title,$descr,$employee_id);
                    $_SESSION["department_waiting_tasks"]=TaskDAO::searchTasks($department_id,$manager,$title,$descr);
                }
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
}
?>