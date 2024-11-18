<?php
    require_once "../Dao/UserDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    $fileParamName='profile_picture';
    $tempFileName = 'tmp_name';

    if(!isset($_FILES[$fileParamName]) || $_FILES[$fileParamName]["size"]==0){
        MySessionHandler::addErrorMessage("Картинка не выбрана");
        header("Location: ../views/userProfilePage.php");
        return;
    }
    $file = $_FILES[$fileParamName];
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        MySessionHandler::addErrorMessage("Ошибка загрузки файла. Код ошибки: " . $file['error']);
        header("Location: ../views/userProfilePage.php");
        return;
    }
    $maxSize = 512 * 1024;  // 512 КB
    if ($file['size'] > $maxSize) {
        MySessionHandler::addErrorMessage("Файл слишком большой. Максимальный размер: ". ($maxSize/1024)."КБ");
        header("Location: ../views/userProfilePage.php");
        return;
    }
    // Проверка формата изображения
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType = mime_content_type($file[$tempFileName]);
    if (!in_array($fileType, $allowedTypes)) {
        MySessionHandler::addErrorMessage("Недопустимый формат изображения. Разрешены только JPG, PNG.");
        header("Location: ../views/userProfilePage.php");
        return;
    }
    // Если все проверки прошли, сохраняем файл на сервер
    $uid = InputFilter::filterPost("uid");
    try{

        $bytes = file_get_contents($file[$tempFileName]);
        //false if picture not exists
        UserDAO::setPicture($uid, $bytes);
        header("Location: ../views/userProfilePage.php");
        return;
    }catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка при выборке изображения. ".$ex->getMessage());
        header("Location: ../views/userProfilePage.php");
        return;
    }
?>