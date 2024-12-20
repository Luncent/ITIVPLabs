<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    $userLogin = $_GET["userLogin"];
    if(isset($_COOKIE[$userLogin]))
    {
        setcookie($userLogin, "", time() - 3600, "/");
    }
    // var_dump(isset($_COOKIE[$userLogin]));
    // exit;
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        session_destroy();
    }
    header("Location: ../views/loginPage.php");
    return;
?>