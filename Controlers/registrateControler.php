<?php 
    require_once "../Utils/MySessionHandler.php";
    require_once "../Dao/UserDao.php";
    require_once "../Dao/DepartmentsDao.php";
    require_once "../Utils/InputValidator.php";

    $login = $_POST["login"];
    $password = $_POST["password"];
    $passwConfirmation = $_POST["passwConfirmation"];
    $role = $_POST["role"];
    $department_id = $_POST["department_id"];

    if(empty(trim($login)) || empty(trim($password)) || empty(trim($passwConfirmation))
        || empty(trim($role)) || empty(trim($department_id))){

        MySessionHandler::addErrorMessage("Заполните все поля");
        header("Location: ../views/registrationPage.php");
        return;
    }
    if(InputValidator::isUsernameValid($login) || InputValidator::isUserPasswordValid($password)){
        MySessionHandler::addErrorMessage("Использованы запрещенные символы");
        header("Location: ../views/registrationPage.php");
        return;
    }
    if($password!=$passwConfirmation){
        MySessionHandler::addErrorMessage("Пароли не совпадают");
        header("Location: ../views/registrationPage.php");
        return;
    }
    //если вдруг отдел удалят
    if(DepartmentsDao::read($department_id)==null){
        MySessionHandler::addErrorMessage("Отдел был удален");
        header("Location: ../views/registrationPage.php");
        return;
    }
    
    try{
        $user = UserDao::getUserByLogin($login);
        if($user==="not found"){
            UserDao::insertUser($login,$password,$role,$department_id);
            
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