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

    echo $login.$password.$passwConfirmation.$role.$department;

    if(empty($login) || empty($password) || empty($passwConfirmation)
        || empty($role) || empty($department)){

        addErrorMessage("Заполните все поля");
        header("Location: ../views/registrationPage.php");
        return;
    }
    if($password!=$passwConfirmation){
        addErrorMessage("Пароли не совпадают");
        header("Location: ../views/registrationPage.php");
        return;
    }
    
    $user = getUserByLogin($login);
    if(errorHappened()){
        header("Location: ../views/registrationPage.php");
    }
    else if($user==="not found"){
        insertUser($login,$password,$role,$department);
        safeSessionStart();
        $user=getUserByLogin($login);
        $_SESSION["user"]=$user;
        header("Location: ../views/index.php");
    }
    else{
        addErrorMessage("Логин ".$user->login." занят");
        header("Location: ../views/registrationPage.php");
    }
?>