<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
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
    <form action="../Controlers/LoginControler.php" method="post" class="formLogin">
    <input type="hidden" name="action" value="login">
        <div class="mb-3">
            <input type="text" name="login" placeholder="Login">
        </div>
        <div class="mb-3">
            <input type="text" name="password" placeholder="Password">
        </div>
        <div class="buttons">
            <button type="submit" class="btn btn-primary">Войти</button>
            <a href="../views/registrationPage.php" class="btn btn-primary">Регистрация</a>
        </div>
        <?php
            if(MySessionHandler::errorHappened()){
                echo '<div class="phpError"><p>'. $_SESSION["message"].'</p></div>';
                unset($_SESSION["message"]);
            }
        ?>
    </form>
</div>
</body>
</html>