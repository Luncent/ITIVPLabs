<?php 

    Class MySessionHandler{
        public static function addErrorMessage($message){
            self::safeSessionStart();
            $_SESSION["message"]=$message;
        }

        public static function safeSessionStart(){
            if (!(session_status() === PHP_SESSION_ACTIVE)) {
                session_start();
            }
        }   

        public static function errorHappened(){
            if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
                return true;
            } 
            else{
                return false;
            }
        }

        public static function userEntered(){
            return (isset($_SESSION["user"])); 
        }
    }
?>