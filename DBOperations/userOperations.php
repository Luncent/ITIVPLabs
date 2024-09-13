<?php
    require_once "pdo.php";
    require_once "../Utils/sessionHadler.php";
    /*$user;
    
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["action"])){
        echo $_POST["action"];
        if($_POST["action"]=="registrate"){
            registrateUser();
        }
        if($_POST["action"]=="login"){
            login();
        }
    }*/

    function registrateUser(){
        $login = $_POST["login"];
        $password = $_POST["password"];
        $password2 = $_POST["passwConfirmation"];
        $role = $_POST["role"];
        $department = $_POST["department"];
        echo $login." " . $password . " ".$password2;
        
        if(!insertUser($login,$password,$role,$department)){
            echo "Пользователь ".$login." уже существует";
        }
        else{
            $users = getUser($login,$password);
            if(!empty($users)){
                $user= $users[0];
                var_dump($user);
                header("Location: ../views/index.php");
                exit();
            }
        }
    }

    function insertUser($login, $password, $role, $department){
        try{   
            $conn = getConnection();
            $query = $conn->prepare("INSERT INTO users(login,password,role,department) VALUES (?,?,?,?)");
            $bool = $query->execute([$login,$password,$role,$department]); 
            return $bool;
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    function getUser($login, $password){
        try{
            $conn = getConnection();
            $query = $conn->prepare("SELECT * FROM users WHERE login=? AND password=?");
            $query->execute([$login, $password]);
            $users = $query->fetchAll(PDO::FETCH_OBJ);
            if(empty($users)){
                addErrorMessage("Неверное имя пользрователя или пароль");
            }
            else{
                return $users[0];
            }
        }
        catch(Exception $ex){
            addErrorMessage("Ошибка при выборке данных ".$ex->getMessage());
        }
    }

    function getUserByLogin($login){
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
            addErrorMessage("Ошибка при выборке данных ".$ex->getMessage());
        }
    }

    
?>