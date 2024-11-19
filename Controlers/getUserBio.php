<?php
    require_once "../Dao/UserDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    function getBio($userName){
        try{
            $filePath = "../files/".$userName."/bio.txt";
            if(!file_exists($filePath)){
                if (!is_readable($filePath)) {
                    MySessionHandler::addErrorMessage("Файл с биографией не найден или к нему отсутствует доступ");
                    return "Биография отсутствует";
                }
                return "Биография отсутствует";
            }
            $fileContent = file_get_contents($filePath);
            return nl2br(htmlspecialchars($fileContent));
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборке биографии. ".$ex->getMessage());
        }
    }
?>