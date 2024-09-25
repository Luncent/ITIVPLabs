<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        session_destroy();
    }
    header("Location: ../views/loginPage.php");
    return;
?>