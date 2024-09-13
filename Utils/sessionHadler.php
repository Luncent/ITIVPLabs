<?php 
    function addErrorMessage($message){
        safeSessionStart();
        $_SESSION["message"]=$message;
    }

    function safeSessionStart(){
        if (!(session_status() === PHP_SESSION_ACTIVE)) {
            session_start();
        }
    }

    function errorHappened(){
        if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
            return true;
        } 
        else{
            return false;
        }
    }

    function userEntered(){
        return (isset($_SESSION["user"])); 
    }
?>