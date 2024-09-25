<?php
    require_once "pdo.php";
    require_once "../Utils/MySessionHandler.php";

    class UserDao{

        public static function insertUser($login, $password, $role, $department){
            try{    
                $conn = getConnection();
                $query = $conn->prepare("INSERT INTO users(login,password,role,department) VALUES (?,?,?,?)");
                $bool = $query->execute([$login,$password,$role,$department]); 
                return $bool;
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        public static function getUser($login, $password){
            try{
                $conn = getConnection();
                $query = $conn->prepare("SELECT * FROM users WHERE login=? AND password=?");
                $query->execute([$login, $password]);
                $users = $query->fetchAll(PDO::FETCH_OBJ);
                return $users;
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        public static function getUserByLogin($login){
            try{
                $conn = getConnection();
                $query = $conn->prepare("SELECT * FROM users WHERE login=?");
                $query->execute([$login]);
                $users = $query->fetchAll(PDO::FETCH_OBJ);
                if(empty($users)){
                    return "not found";
                }
                else{
                    return $users[0];
                }
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

    }
?>