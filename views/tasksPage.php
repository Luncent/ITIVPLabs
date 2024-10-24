<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    if(!MySessionHandler::userEntered()){
        header("Location: ../views/loginPage.php");
        return;
    }
    require_once "../Controlers/getTasksController.php";
    if($_SESSION["user"]->role == "admin"){
        GetTasksController::selectTasksAdmin();
    }
    if($_SESSION["user"]->role == "сотрудник"){
        GetTasksController::selectTasksEmployee($_SESSION["user"]->department_id,
         $_SESSION["user"]->id);
    }
    if($_SESSION["user"]->role == "начальник отдела"){
        GetTasksController::selectTasksEmployer($_SESSION["user"]->id);
    }
    if(isset($_SESSION["message"])){
        $message = $_SESSION["message"];
        unset($_SESSION["message"]);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Учет рабочего времени</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
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
<!--Table component-->
    <?php 
        require_once "../views/Components/tasksTable.php"
    ?>

    <main>
        <!--AddForm component-->
        <?php 
            require_once "../views/Components/tasksAddForm.php"
        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>