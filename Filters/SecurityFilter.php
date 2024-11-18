<?php require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    if(!MySessionHandler::userEntered()){
        header("Location: ../views/loginPage.php");
        return;
    }
    else{
        return;
    }
?>