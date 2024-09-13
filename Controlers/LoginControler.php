<?php
    require_once "../Utils/sessionHadler.php";
    safeSessionStart();

    $login = $_POST["login"];
    $password = $_POST["password"];
    echo $login." " . $password;
    // TO DO проверить переменные на пустоту
    if(empty($login) || empty($password)){
        addErrorMessage("Заполните все поля");
        header("Location: ../views/loginPage.php");
        return;
    }
    
    //получение соединения с бд
    require_once "../DBOperations/userOperations.php";
    //проверяем не произошла ли ошибка при подключении к бд
    if(errorHappened()){
        header("Location: ../views/loginPage.php");
        return;
    }

    //проверка наличия пользователя в бд
    $user = getUser($login,$password);
    if(errorHappened()){
        header("Location: ../views/loginPage.php");
    }
    else{
        $_SESSION["user"]=$user;
        header("Location: ../views/index.php");
    }
?>