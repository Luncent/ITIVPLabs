<!-- <link rel="stylesheet" href="../css/switcher.css"></link>
<h2>Режим работы</h2>

    <div class="switch-wrapper">
        <div class="state">В офисе</div>
        <div class="toggle-container">
            <div id="toggleCircle" class="toggle-circle" 
                 style="left: <?php if(isset($_COOKIE[$_SESSION["user"]->login]))
                  { 
                    if ($_COOKIE[$_SESSION["user"]->login] == 'remote') echo'145px';
                    else { echo '5px';}
                  } ?>;"></div>
        </div>
        <div class="state">Удалёнка</div>
    </div>

        <p id="warningMessage" style="color: red;">Чтобы выбрать задание, выберите режим работы.</p>
 -->

<link rel="stylesheet" href="../css/switcher.css"></link>
    <h2>Выберите режим работы</h2>

    <form action="../Controlers/addCookieController.php" method="POST" id="modeForm">
        <div class="switch">
            <input type="hidden" name="userLogin" value="<?php echo $_SESSION["user"]->login?>">
            <button type="submit" name="mode" value="office" class="button">
                В офисе
            </button>
            <button type="submit" name="mode" value="remote" class="button">
                На удалёнке
            </button>
        </div>
    </form>

    <?php if (isset($_COOKIE[$_SESSION["user"]->login])): ?>
        <p >Текущий статус: <?php echo password_verify('office',$_COOKIE[$_SESSION["user"]->login]) == true ? 'office' : 'remote';?></p>
    <?php else: ?>
        <p style="color: red;">Чтобы выбрать задание, необходимо указать режим работы.</p>
    <?php endif; ?>