<?php
    include "pdo.php";
    $user;
    
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["action"])){
        echo $_POST["action"];
        if($_POST["action"]=="registrate"){
            registrateUser();
        }
        if($_POST["action"]=="login"){
            login();
        }
    }

    function login(){
        $login = $_POST["login"];
        $password = $_POST["password"];
        echo $login." " . $password;
        
        $users = getUsers($login,$password);

        if(empty($users)){
            echo "Неверное имя пользователя или пароль";
        }
        else{
            $user = $users[0];
            var_dump($user);
            header("Location: ../views/index.php");
            exit();
        }
    }

    function registrateUser(){
        $login = $_POST["login"];
        $password = $_POST["password"];
        $password2 = $_POST["passwConfirmation"];
        echo $login." " . $password . " ".$password2;
        
        if(!insertUser($login,$password)){
            echo "Пользователь ".$login." уже существует";
        }
        else{
            $users = getUsers($login,$password);
            if(!empty($users)){
                $user= $users[0];
                var_dump($user);
                header("Location: ../views/index.php");
                exit();
            }
        }
    }

    function insertUser($login, $password){
        try{   
            global $conn;
            $query = $conn->prepare("INSERT INTO users(login,password,role) VALUES (?,?,'user')");
            $bool = $query->execute([$login,$password]); 
            echo "вставка";
            return $bool;
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    function getUsers($login, $password){
        try{
            global $conn;
            $query = $conn->prepare("SELECT * FROM users WHERE login=? AND password=?");
            $query->execute([$login, $password]);
            $users = $query->fetchAll(PDO::FETCH_OBJ);
            return $users;
        }
        catch(Exception $ex){
            echo "Ошибка при выборке данных ".$ex->getMessage();
        }
    }


    
?>