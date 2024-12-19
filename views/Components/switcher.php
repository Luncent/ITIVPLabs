<link rel="stylesheet" href="../css/switcher.css"></link>
<h2>Режим работы</h2>

    <!-- Текст и переключатель рядом -->
    <div class="switch-wrapper">
        <div class="state">В офисе</div>
        <div class="toggle-container">
            <div id="toggleCircle" class="toggle-circle" 
                 style="left: <?php echo isset($_COOKIE['work_mode']) ? $_COOKIE['work_mode'] == 'remote' ? '145px' : '145px' : '5px'; ?>;"></div>
        </div>
        <div class="state">Удалёнка</div>
    </div>

        <p id="warningMessage" style="color: red;">Чтобы выбрать задание, выберите режим работы.</p>

