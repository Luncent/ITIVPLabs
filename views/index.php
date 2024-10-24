<?php
    require_once "../Utils/MySessionHandler.php";
    MySessionHandler::safeSessionStart();
    if(!MySessionHandler::userEntered()){
        header("Location: ../views/loginPage.php");
        return;
    }
    //echo var_dump($_SESSION);
    require_once "../Controlers/getScheduleDataControler.php";
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
        require_once "../views/Components/indexTableComponent.php"
    ?>

    <div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../Controlers/UpdateSchedule.php" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Изменение расписания</h5>
            <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userInfo">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal" id="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        </form>
    </div>
    </div>

    <main>
        <form action="" method="get" class="formSearch">
            <input type="hidden" name="action" value="search"> 
            <input type="text" name="searchLine">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!--AddForm component-->
        <?php 
            require_once "../views/Components/indexAddFormComponent.php"
        ?>
    </main>

    <script src="../js/editShedule.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>