<?php 
    if($_SESSION["user"]->role=="сотрудник"){
        return;
    }
?>
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
      <?php if($_SESSION["user"]->role=="admin"){ ?>
        <label for="options">Отдел</label>
        <select name="departmentName" id="options">
            <option value="Отдел кадров">Отдел кадров</option>
            <option value="Плановый отдел">Плановый отдел</option>
            <option value="Маркетинговый отдел">Маркетинговый отдел</option>
            <option value="Финансовый отдел">Финансовый отдел</option>
        </select>
      <?php }?>
       
      <?php if($_SESSION["user"]->role=="начальник отдела"){ ?>
        <input type="hidden" name="departmentName" value="<?php echo $_SESSION["user"]->department?>">
      <?php }?>
        

        <label>Начало смены</label>
        <input type="text" name="startTime">
        <label>Конец смены</label>
        <input type="text" name="endTime">
        <div class="buttonAdd">
            <button type="submit" class="btn btn-primary" name="add">Add</button>
        </div>
    </div>
</form>