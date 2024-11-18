<?php
    require_once "../Filters/SecurityFilter.php";
    require_once "../Controlers/getUserPicture.php";
    require_once "../Controlers/getUserBio.php";
    $bio = getBio($_SESSION["user"]->login); 
    getPicture($_SESSION["user"]->id);
    if(isset($_SESSION["message"])){
        $message = $_SESSION["message"];
        unset($_SESSION["message"]);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/user_profile.css">
</head>
<body>

    <!--Header component-->
    <?php 
        require_once "../views/Components/indexPageHeader.php"
    ?>
<!--ErrorMessage component-->
    <?php
        if(isset($message)){
            echo '<div class="phpError"><p>'. $message.'</p></div>';
            unset($message);
        }
    ?>

    <div class="container">
        <!-- Профиль заголовка -->
        <div class="profile-header">
            <!-- Изображение пользователя  <img src="data:image/jpeg;base64,' . $base64Image . '" alt="Image">-->
            <?php if(!isset($_SESSION["profile_picture"]) || !$_SESSION["profile_picture"]){
                echo '<img src="../img/blank_profile.png" alt="Изображение пользователя">';
            } else {
                echo '<img src="data:image/jpeg;base64,' . $_SESSION["profile_picture"] . '" alt="Image">';
            }?>
            <div>
                <h1><?php echo $_SESSION["user"]->login?></h1>
                <p><strong>Отдел:</strong> <?php echo $_SESSION["user"]->department_name?></p>
                <p><strong>Должность:</strong><?php echo $_SESSION["user"]->role?></p>
            </div>
        </div>

        <!-- Биография -->
        <div class="bio section">
            <h2>Биография</h2>
            <p><?php echo $bio?></p>
        </div>

        <div class="forms">
            <div class="pictureChange">
                <!-- Кнопка для редактирования фото профиля -->
                <form class="section" action="../Controlers/setUserPicture.php" method="POST" enctype="multipart/form-data">
                    <label for="fileToUpload">Выберите изображение:</label>
                    <input type="file" class="form-control" name="profile_picture" id="formGroupExampleInput2" name="profile_picture">
                    <input type="hidden" name="uid" value=<?php echo $_SESSION["user"]->id?>>
                    <button type="submit" class="btn">Изменить фото профиля</button>
                </form>
            </div>
            <div class="pictureChange">
                <!-- Кнопка для редактирования биографии профиля -->
                <form class="section" action="../Controlers/setUserBio.php" method="POST" enctype="multipart/form-data">
                    <label for="fileToUpload">Выберите файл с биографией:</label>
                    <input type="file" class="form-control" name="fileWithBio" id="formGroupExampleInput2" name="profile_picture">
                    <input type="hidden" name="uid" value=<?php echo $_SESSION["user"]->id?>>
                    <input type="hidden" name="userName" value=<?php echo $_SESSION["user"]->login?>>
                    <button type="submit" class="btn">Изменить биографию</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
