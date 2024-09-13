<?php
    require_once "../Utils/sessionHadler.php";
    safeSessionStart();
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        session_destroy();
    }
    header("Location: ../views/loginPage.php");
    return;
?>