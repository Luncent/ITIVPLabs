<?php
    require_once "../Dao/CoefficentsDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        CoefficientsController::update($_POST["id"],$_POST["weight"]);
        header("Location: ../views/CoefficientsPage.php");
        return;
    }
    else if($_SERVER['REQUEST_METHOD'] === 'GET'){
        CoefficientsController::getAll();
    }

class CoefficientsController{

    public static function getAll(){
        try{
            $dao = new CoefficentsDao();
            $_SESSION["coefficients"] = $dao->getAll();
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке данных. ".$ex->getMessage());
        }
    }

    public static function update($id,$weight){
        try{
            $weight = InputFilter::filterPost("weight");
           if(!InputValidator::validateDecimal($weight)){
                MySessionHandler::addErrorMessage("Ошибка при обновлении записи. "."Число должно состоять из 5 цифр и иметь не более 2 знаков после запятой");
                return;  
           }
           else{
                $dao = new CoefficentsDao();
                $dao->update($id,$weight);
           }
        }
        catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при обновлении записи. ".$ex->getMessage());
            return;
        }
    }
}
?>