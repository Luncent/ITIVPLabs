<?php 

    Class MySessionHandler{

        public static function addErrorMessage($message){
            self::safeSessionStart();
            if(!isset($_SESSION["message"]) || empty($_SESSION["message"])){
                $_SESSION["message"]="! ".$message;
            }
            else{
                $_SESSION["message"].="<br>! ".$message;
            }
        }

        public static function safeSessionStart(){
            if (!(session_status() === PHP_SESSION_ACTIVE)) {
                session_start([
                    'cookie_lifetime' => 60*30,
                ]);
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

        public static function hasSpecialCharacters($string) {
            // Регулярное выражение для проверки наличия специальных символов
            return preg_match('/[^a-zA-Zа-яА-Я0-9 ]/u', $string);
        }
    }
?>