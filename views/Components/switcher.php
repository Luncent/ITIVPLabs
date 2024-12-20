<link rel="stylesheet" href="../css/switcher.css"></link>
<h2>Режим работы</h2>

    <!-- Текст и переключатель рядом -->
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

