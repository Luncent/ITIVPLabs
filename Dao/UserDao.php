<?php
    require_once "pdo.php";
    require_once "../Utils/MySessionHandler.php";

    class UserDao{

        public static function insertUser($login, $password, $role, $department){
            $conn = getConnection();
            $query = $conn->prepare("INSERT INTO users(login,password,role,department_id) VALUES (?,?,?,?)");
            $bool = $query->execute([$login,$password,$role,$department]); 
            return $bool;
        }

        public static function getUser($login, $password){
            $conn = getConnection();
            $query = $conn->prepare("SELECT users.*, departments.name AS department_name FROM users 
            LEFT JOIN departments ON departments.id=users.department_id
            WHERE users.login='$login' AND users.password = '$password'");
            $query->execute();
            $users = $query->fetchAll(PDO::FETCH_OBJ);
            return $users;
        }

        public static function getManagers($department_id){
            $conn = getConnection();
            $query = $conn->prepare("SELECT login FROM users WHERE department_id=? AND role='начальник отдела'");
            $query->execute([$department_id]);
            $users = $query->fetchAll(PDO::FETCH_COLUMN);
            return $users;
        } 

        public static function getUserByLogin($login){
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

        public static function getPicture($uid){
            $conn = getConnection();
            $query = $conn->prepare("SELECT profile_pic FROM users WHERE id=?");
            $query->execute([$uid]);
            $picture = $query->fetchColumn();
            return $picture;
        }

        public static function setPicture($uid, $bytes){
            $conn = getConnection();
            $query = $conn->prepare("UPDATE users SET profile_pic =:bytes WHERE id=:user_id");
            $query->bindParam(":bytes",$bytes, PDO::PARAM_LOB);
            $query->bindParam(":user_id",$uid);
            $query->execute();
        }
    }
?>