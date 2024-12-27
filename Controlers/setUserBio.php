<?php

require_once "../Dao/UserDao.php";
require_once "../Utils/MySessionHandler.php";
require_once "../Utils/inputFilter.php";
require_once "../Utils/InputValidator.php";
// Указываем директорию для сохранения файла

$uploadDir = "../files/".@$_POST["userName"];
$fileParamName = "fileWithBio";

header('Content-Type: application/json');

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
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Ошибка загрузки файла! Код ошибки: " . $file['error'],
            ]);
            return;
        }

        // Проверка размера файла (например, до 4КB)
        $fileSizeLimit= 4 * 1024;
        if ($file['size'] > $fileSizeLimit) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Ошибка: файл слишком большой. Максимальный размер " . ($fileSizeLimit / 1024) . " КБ.",
            ]);
            return;
        }

        $allowedType = 'text/plain';
        $fileType = mime_content_type($file['tmp_name']);
        if ($fileType!== $allowedType){
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Недопустимый формат файла. Разрешены только txt.",
            ]);
            return;
        }   
        if(!is_readable($uploadDir)){
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Ошибка при сохнанении файла. Проверьте настройки доступа",
            ]);
            return;
        }
        // Перемещаем файл в целевую директорию
        if (@move_uploaded_file($file['tmp_name'], $filePath)) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Файл успешно загружен.",
            ]);
        } else {
            http_response_code(500);
            error_log("Ошибка 500 доступ запрещ0");
            echo json_encode([
                "success" => false,
                "message" => "Ошибка при сохнанении файла. Проверьте настройки доступа",
            ]);
        }
        return;
    } else {    
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Файл не выбран.",
        ]);
    }   
}catch(Exception $ex){
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Ошибка при сохранении файла: " . $ex->getMessage(),
    ]);
}
?>
