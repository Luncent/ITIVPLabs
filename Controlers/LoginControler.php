<?php
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/UserDao.php";
    MySessionHandler::safeSessionStart();

    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);
    if(empty($login) || empty($password)){
        MySessionHandler::addErrorMessage("Заполните все поля");
        header("Location: ../views/loginPage.php");
        return;
    }

    //проверка наличия пользователя в бд
    try{
        $users = UserDao::getUser($login,$password);
        if(isset($users) && count($users)!=0){
            $_SESSION["user"]=$users[0];
            header("Location: ../views/index.php");
            return;
        }
        else{
            MySessionHandler::addErrorMessage("Неверный логин $login или неправильный пароль");
            header("Location: ../views/loginPage.php");
            return;
        }
    }
    catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка во время авторизации: ".$ex->getMessage());
        header("Location: ../views/loginPage.php");
        return;
    }
?>