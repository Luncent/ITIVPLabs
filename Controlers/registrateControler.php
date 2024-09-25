<?php 
    require_once "../Utils/sessionHadler.php";
    require_once "../DBOperations/userOperations.php";

    /*if(errorHappened()){
        header("Location: ../views/index.php");
        return;
    }*/

    $login = $_POST["login"];
    $password = $_POST["password"];
    $passwConfirmation = $_POST["passwConfirmation"];
    $role = $_POST["role"];
    $department = $_POST["department"];

    if(empty($login) || empty($password) || empty($passwConfirmation)
        || empty($role) || empty($department)){

        MySessionHandler::addErrorMessage("Заполните все поля");
        header("Location: ../views/registrationPage.php");
        return;
    }
    if($password!=$passwConfirmation){
        MySessionHandler::addErrorMessage("Пароли не совпадают");
        header("Location: ../views/registrationPage.php");
        return;
    }
    
    try{
        $user = UserDao::getUserByLogin($login);
        if($user==="not found"){
            UserDao::insertUser($login,$password,$role,$department);
            
            MySessionHandler::safeSessionStart();
            $user=UserDao::getUserByLogin($login);
            $_SESSION["user"]=$user;
            header("Location: ../views/index.php");
        }
        else{
            MySessionHandler::addErrorMessage("Логин ".$user->login." занят");
            header("Location: ../views/registrationPage.php");
        }
    }catch(Exception $ex){
        MySessionHandler::addErrorMessage("Ошибка во время регистрации: ".$ex->getMessage());
        header("Location: ../views/registrationPage.php");
    }
?>