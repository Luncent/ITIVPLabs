<header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <div class="d-flex">
                    <?php 
                        if(MySessionHandler::userEntered()){?>
                            <a class="navbar-brand" id="login"><?php echo $_SESSION["user"]->login ?></a>
                            <a href="index.php" class="btn btn-primary">Главная страница</a>
                            <a href="tasksPage.php" class="btn btn-primary">Задания</a>
                            <a href="userProfilePage.php" class="btn btn-primary">Профиль</a>
                            <?php 
                             if($_SESSION["user"]->role=="admin"){?>
                                <a href="departmentsPage.php" class="btn btn-primary">Справочник отделов</a>
                                <a href="CoefficientsPage.php" class="btn btn-primary">Коэффициенты</a>
                            <?php }?>
                            <form action="../Controlers/exitFromAccount.php" method="get">
                                <input type="hidden" name="userLogin" value="<?php echo $_SESSION["user"]->login?>">
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