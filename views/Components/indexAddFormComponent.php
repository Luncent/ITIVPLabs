<?php 
    if($_SESSION["user"]->role=="сотрудник"){
        return;
    }
?>
<form action="../Controlers/addScheduleControler.php" method="post" class="formAdd">
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
    <?php if($_SESSION["user"]->role=="admin"){
                require_once "../Controlers/getAllDepartmentsControler.php"; 
        ?>
        <label for="options">Отдел</label>

        <select name="department_id" id="department">
            <?php if(isset($_SESSION["departments"])){?>
                <?php foreach($_SESSION["departments"] as $department){?> 
                    <option value=<?php echo $department->id ?> > <?php echo $department->name ?> </option>
                <?php }?>
            <?php } ?>
        </select>
    <?php 
             unset($_SESSION["departments"]);
          }?>
       
      <?php if($_SESSION["user"]->role=="начальник отдела"){ ?>
        <input type="hidden" name="department_id" value="<?php echo $_SESSION["user"]->department_id?>">
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