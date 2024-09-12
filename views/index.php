<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Заголовок страницы</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="phpError">
        <?php
            include "../dataSource/crud.php";
            include "../dataSource/userOperations.php"
        ?>
    </div>

    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <!--<?php 
                    global $user;
                    echo $user->login;
                ?>-->
                <a class="navbar-brand">Вы не вошли в аккаунт</a>
                <form class="d-flex" role="search">
                    <!--<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
                    <a href="../views/loginPage.php" class="btn btn-primary">Войти в аккаунт</a>
                    <button class="btn btn-outline-success" type="submit">Выйти</button>
                </form>
            </div>
        </nav>
    </header>

    <main>
        <table class="table table-striped table-hover tableBorder">
            <thead class="th-dark">
                <th>ID</th>
                <th>Name</th>
                <th>PhoneNumber</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach($selectedRows as $row){?> 
                <tr>
                    <td><?php echo $row->id?></td>
                    <td><?php echo $row->name?></td>
                    <td><?php echo $row->phone?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $row->id?>">
                            <button type="submit" class="btn-delete" name="delete">delete</button>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn-edit" name="edit">edit</button>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>          

        <form action="" method="post" class="formAdd">
            <input type="hidden" name="action" value="add">
            <label>Name</label> 
            <input type="text" name="name">
            <label>Phone</label>
            <input type="text" name="phone">
            <button type="submit" class="btn btn-primary" name="add">Add</button>
        </form>
    
        <form action="" method="get" class="formSearch">
            <input type="hidden" name="action" value="search"> 
            <input type="text" name="searchLine">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>