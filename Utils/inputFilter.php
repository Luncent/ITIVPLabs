<?php 
    Class InputFilter{
        static function filterString($paramName){
            $str = isset($_GET[$paramName]) ? $_GET[$paramName]: "";
            return trim($str);
        }

        static function filterPost($paramName){
            $str = isset($_POST[$paramName]) ? $_POST[$paramName]: "";
            return trim($str);
        }
    }
?>