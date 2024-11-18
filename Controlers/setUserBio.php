<?php

require_once "../Dao/UserDao.php";
require_once "../Utils/MySessionHandler.php";
require_once "../Utils/inputFilter.php";
require_once "../Utils/InputValidator.php";
// Указываем директорию для сохранения файла

$uploadDir = "../files/".$_POST["userName"];
$fileParamName = "fileWithBio";
try{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Проверяем, был ли файл отправлен
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES[$fileParamName]) && $_FILES[$fileParamName]['size']!=0) {    
        $file = $_FILES[$fileParamName];
        $filePath = $uploadDir .'/bio.txt';
    
        // Проверка ошибок загрузки
        if ($file['error'] !== UPLOAD_ERR_OK) {
            MySessionHandler::addErrorMessage("Ошибка загрузки файла! Код ошибки: " . $file['error']);
            header("Location: ../views/userProfilePage.php");
            return;
        }

        // Проверка размера файла (например, до 4КB)
        $fileSizeLimit= 4 * 1024;
        if ($file['size'] > $fileSizeLimit) {
            MySessionHandler::addErrorMessage("Ошибка: файл слишком большой. Максимальный размер ". ($fileSizeLimit/1024)." КВ.");
            header("Location: ../views/userProfilePage.php");
            return;
        }

        $allowedType = 'text/plain';
        $fileType = mime_content_type($file['tmp_name']);
        if ($fileType!== $allowedType){
            MySessionHandler::addErrorMessage("Недопустимый формат изображения. Разрешены только txt.");
            header("Location: ../views/userProfilePage.php");
            return;
        }   

        // Перемещаем файл в целевую директорию
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            MySessionHandler::addErrorMessage("Файл успешно загружен");
        } else {
            MySessionHandler::addErrorMessage("Ошибка при перемещении файла.");
        }
        header("Location: ../views/userProfilePage.php");
        return;
    } else {    
        MySessionHandler::addErrorMessage("Файл не выбран");
        header("Location: ../views/userProfilePage.php");
        return;
    }   
}catch(Exception $ex){
    MySessionHandler::addErrorMessage("Ошибка при сохранении файла ". $ex->getMessage());
    header("Location: ../views/userProfilePage.php");
    return;
}
?>
