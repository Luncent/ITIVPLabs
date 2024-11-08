<?php
    Class InputValidator{
        public static function correctDescription($str){
            return preg_match('/[^a-zA-Zа-яА-Я0-9 \n\r]/u', $str);
        }
        public static function hasSpecialCharacters($string) {
            // Регулярное выражение для проверки наличия специальных символов
            return preg_match('/[^a-zA-Zа-яА-Я0-9 ]/u', $string);
        }

        public static function isUsernameValid($string) {
            return preg_match('/[^a-zA-Zа-яА-Я]/u', $string);
        }

        public static function isUserPasswordValid($string) {
            return preg_match('/[^a-zA-Zа-яА-Я0-9]/u', $string);
        }

        public static function validateDecimal($value) {
            if (filter_var($value, FILTER_VALIDATE_FLOAT) === false) {
                return false;
            }

            if (preg_match('/^-?\d{1,3}(\.\d{1,2})?$/', $value)) {
                return true;
            }
            return false;
        }

        public static function isEmpty($dayOfWeek,$startTime,$endTime,$department_id){
            if(empty($dayOfWeek) || empty($department_id)){
                MySessionHandler::addErrorMessage("Отдел, день недели обязательные поля для заполнения");
                return true;
            }
            return self::timeIsEmpty($startTime,$endTime);
        }

        public static function timeIsEmpty($startTime,$endTime){
            if((empty($startTime) && !empty($endTime)) || ((!empty($startTime) && empty($endTime)))){
                MySessionHandler::addErrorMessage("Или заполните оба временных поля, или оставьте их пустыми");
                return true;
            }
            return false;
        }

        //валидация
        public static function timesValid($start,$end){
            if(!self::isValidTime($start) || !self::isValidTime($end)){
                MySessionHandler::addErrorMessage("Введены неверные значения. Допустимые форматы времени - HH:MM:SS или HH:MM<br>
                диапазон часов [0;23], диапазон минут [0;59],диапазон секунд [0;59],");
                return false;
            }
            // Создаем объекты DateTime
            $startTime = DateTime::createFromFormat('H:i:s', $start) ?: DateTime::createFromFormat('H:i', $start);
            $endTime = DateTime::createFromFormat('H:i:s', $end) ?: DateTime::createFromFormat('H:i', $end);
            $zeroTime = new DateTime('00:00:00');
            // Сравниваем время
            if (($startTime >= $endTime) && !($startTime==$zeroTime && $endTime==$zeroTime)) {
                MySessionHandler::addErrorMessage("Начало смены не может быть позже ее окончания или быть равной");
                return false;
            }
            return true;
        }

        public static function isValidTime($time) {
            // Проверка формата hh:mm:ss
            if (preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $time)) {
                return true; // Формат hh:mm:ss
            }
            // Проверка формата hh:mm
            if (preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d$/', $time)) {
                return true; // Формат hh:mm
            }
            return false; // Не соответствует ни одному формату
        }
    }
?>