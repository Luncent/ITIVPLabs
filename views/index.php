<?php
    require_once "../Utils/sessionHadler.php";
    MySessionHandler::safeSessionStart();
    //echo var_dump($_SESSION);
    require_once "../Controlers/getTableDataControler.php";
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
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <div class="d-flex">
                    <?php 
                        if(MySessionHandler::userEntered()){?>
                            <a class="navbar-brand"><?php echo $_SESSION["user"]->login ?></a>
                            <form action="../Controlers/exitFromAccount.php" method="get">
                                <button class="btn btn-primary" type="submit">Выйти</button>
                            </form>
                        <?php 
                        }
                        else{?>
                            <a class="navbar-brand">Вы не вошли в аккаунт</a>
                            <form class="d-flex" role="search">
                                <!--<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
                                <a href="../views/loginPage.php" class="btn btn-primary">Войти в аккаунт</a>
                            </form>
                        <?php 
                        }
                    ?>
                    
                    
                </div>
            </div>
        </nav>
    </header>

    <?php
        if(isset($message)){
            echo '<div class="phpError"><p>'. $message.'</p></div>';
            unset($message);
        }
    ?>

    <main>
        <table class="table table-striped table-hover tableBorder">
            <thead class="th-dark">
                <th>ID</th>
                <th>День недели</th>
                <th>Начало смены</th>
                <th>Конец смены</th>
                <th>Отдел</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php if(isset($_SESSION["selectedRows"])){?>
                    <?php foreach($_SESSION["selectedRows"] as $row){?> 
                        <tr>
                            <td><?php echo $row->id?></td>
                            <td><?php echo $row->dayOfWeek?></td>
                            <td><?php echo $row->startTime?></td>
                            <td><?php echo $row->endTime?></td>
                            <td><?php echo $row->departmentName?></td>
                            <td>
                            <form action="../Controlers/deleteRowControler.php" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row->id?>">
                                <button type="submit" class="btn btn-primary" name="delete">delete</button>
                            </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" name="edit">edit</button>
                            </td>
                        </tr>
                    <?php }?>
                <?php } ?>
            </tbody>
        </table>          

        <form action="" method="get" class="formSearch">
            <input type="hidden" name="action" value="search"> 
            <input type="text" name="searchLine">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <form action="../Controlers/addRowControler.php" method="post" class="formAdd">
            <input type="hidden" name="action" value="add">
            <div class="addLabelcls">
                <label class ="addLabel">Добавление расписания</label>
            </div>
            <div class="formDataContainer">
                <label for="options">День недели</label>
                <select name="dayOfWeek" id="options">
                    <option value="Понедельник">Понедельник</option>
                    <option value="Вторник">Вторник</option>
                    <option value="Среда">Среда</option>
                    <option value="Четверг">Четверг</option>
                    <option value="Пятница">Пятница</option>
                    <option value="Суббота">Суббота</option>
                    <option value="Воскресенье">Воскресенье</option>
                </select>  
                <label for="options">Отдел</label>
                <select name="departmentName" id="options">
                    <option value="Отдел кадров">Отдел кадров</option>
                    <option value="Плановый отдел">Плановый отдел</option>
                    <option value="Маркетинговый отдел">Маркетинговый отдел</option>
                    <option value="Финансовый отдел">Финансовый отдел</option>
                </select>
                <label>Начало смены</label>
                <input type="text" name="startTime">
                <label>Конец смены</label>
                <input type="text" name="endTime">
                <div class="buttonAdd">
                    <button type="submit" class="btn btn-primary" name="add">Add</button>
                </div>
            </div>
        </form>
    
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>