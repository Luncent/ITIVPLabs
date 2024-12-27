<?php

if (isset($_POST['mode'])) {
    setcookie($_POST['userLogin'], password_hash($_POST['mode'],PASSWORD_DEFAULT), time() + (60*60*24 * 7),"/"); // cookie на 30 дней
    //$_COOKIE[$_POST['userLogin']] = $_POST['mode']; // Обновляем локально
}
header("Location: ../views/tasksPage.php");
?>