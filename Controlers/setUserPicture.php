<?php
    require_once "../Dao/UserDao.php";
    require_once "../Utils/MySessionHandler.php";
    require_once "../Utils/inputFilter.php";
    require_once "../Utils/InputValidator.php";

    $fileParamName='profile_picture';
    $tempFileName = 'tmp_name';

    header('Content-Type: application/json');

    if(!isset($_FILES[$fileParamName]) || $_FILES[$fileParamName]["size"]==0){
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Картинка не выбрана",
        ]);
        return;
    }
    $file = $_FILES[$fileParamName];
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Ошибка загрузки файла. Код ошибки: " . $file['error'],
        ]);
        return;
    }
    $maxSize = 512 * 1024;  // 512 КB
    if ($file['size'] > $maxSize) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Файл слишком большой. Максимальный размер: ". ($maxSize/1024)."КБ",
        ]);
        return;
    }
    // Проверка формата изображения
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($file[$tempFileName]);
    error_log("Определённый MIME-тип: " . $fileType);
    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Недопустимый формат изображения. Разрешены только JPG, JPEG, PNG, IMAGE/WEBP.",
        ]);
        return;
    }
    // Если все проверки прошли, сохраняем файл на сервер
    $uid = InputFilter::filterPost("uid");
    try{
        $bytes = file_get_contents($file[$tempFileName]);
        @UserDAO::setPicture($uid, $bytes);
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Файл сохранен",
        ]);
        return;
    }catch(Exception $ex){
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Ошибка при выборке изображения. ".$ex->getMessage(),
        ]);
        return;
    }
?>