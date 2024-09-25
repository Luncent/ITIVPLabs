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