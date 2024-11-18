<?php
    require_once "../Dao/UserDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    function getPicture($uid){
        try{
            //false if picture not exists
            $_SESSION["profile_picture"]=base64_encode(UserDAO::getPicture($uid));
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке изображения. ".$ex->getMessage());
        }
    }
?>