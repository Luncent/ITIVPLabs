<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    //выбираем все департаменты
    require_once "../Controlers/getAllDepartmentsControler.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Заголовок страницы</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="page">
    <form action="../Controlers/registrateControler.php" method="post" class="formLogin">
        <input type="hidden" name="action" value="registrate">
        <div class="mb-3">
            <input type="text" name="login" placeholder="Login">
        </div>
        <div class="mb-3">
            <input type="text" name="password" placeholder="Password">
        </div>
        <div class="mb-3">
            <input type="text" name="passwConfirmation" placeholder="Write password again">
        </div>
        <div class="mb-3">
            <label>Выберите роль</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" value="сотрудник" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Сотрудник
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" value="начальник отдела" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                Начальник отдела
            </label>
        </div>
        <!--Department component-->
        <?php 
            require_once "../views/Components/registrationPageDepartmentsComponent.php"
        ?>

        <?php
            if(MySessionHandler::errorHappened()){
                echo '<div class="phpError"><p>'. $_SESSION["message"].'</p></div>';
                unset($_SESSION["message"]);
            }
        ?>
        <div class="buttons">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            <a href="../views/loginPage.php" class="btn btn-primary">У меня есть аккаунт</a>
        </div>
</form>
</div>
</body>
</html>

<?php
    unset($_SESSION["departments"]);
?>