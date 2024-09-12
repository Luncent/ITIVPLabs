
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
    <div class="phpError">
        <?php
            include "../dataSource/userOperations.php"
        ?>
    </div>
<div class="page">
    <form action="" method="post" class="formLogin">
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
  <!--<div class="mb-3">
    <label>Email</label>
    <input type="text" name="email">
  </div>
  -->
        <div class="buttons">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            <a href="../views/login.php" class="btn btn-primary">У меня есть аккаунт</a>
        </div>
    </form>
</div>
</body>
</html>