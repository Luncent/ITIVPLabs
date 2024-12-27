<?php
    require_once "../Dao/UserDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    function getBio($userName){
        $fileSizeLimit= 4 * 1024;
        try{
            $filePath = "../files/".$userName."/bio.txt";
            //if(!file_exists($filePath)){
                if (!is_readable($filePath)) {
                    MySessionHandler::addErrorMessage("Файл с биографией не найден или к нему отсутствует доступ");
                    return "Биография отсутствует";
                }
                //return "Биография отсутствует";
            //}
            $size = filesize($filePath);
            if($size>$fileSizeLimit){
                MySessionHandler::addErrorMessage("Размер файла с биографией слишком большой. Выберите другой файл");
                return "Биография отсутствует";
            }
            $fileContent = @file_get_contents($filePath);
            if($fileContent==false){
                MySessionHandler::addErrorMessage("Ошибка при чтении биографии. Проверьте папку с файлом");
                return "Биография отсутствует";
            }
            return nl2br(htmlspecialchars($fileContent));
        }catch(Exception $ex){
            MySessionHandler::addErrorMessage("Ошибка при выборе биографии. ".$ex->getMessage());
        }
    }
?>