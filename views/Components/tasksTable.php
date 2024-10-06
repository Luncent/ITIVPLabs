<?php 
    if($_SESSION["user"]->role == "admin"){
?>
<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Отдел</th>
        <th>Создатель</th>
        <th>Исполнитель</th>
        <th>Статус</th>
        <th>Время создания</th>
        <th>Последнее обновление</th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["tasks_admin"])){?>
            <?php foreach($_SESSION["tasks_admin"] as $task){?> 
                <tr>
                    <td><?php echo $task->id?></td>
                    <td><?php echo $task->title?></td>
                    <td><?php echo $task->description?></td>
                    <td><?php echo $task->department_name?></td>
                    <td><?php echo $task->creator_login?></td>
                    <td><?php echo $task->assignee_login?></td>
                    <td><?php echo $task->status?></td>
                    <td><?php echo $task->created_at?></td>
                    <td><?php echo $task->updated_at?></td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>       
<?php } ?>

<?php 
    if($_SESSION["user"]->role == "начальник отдела"){
?>
<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Отдел</th>
        <th>Создатель</th>
        <th>Исполнитель</th>
        <th>Статус</th>
        <th>Время создания</th>
        <th>Последнее обновление</th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["department_my_employerTasks"])){?>
            <?php foreach($_SESSION["department_my_employerTasks"] as $task){?> 
                <tr>
                    <td><?php echo $task->id?></td>
                    <td><?php echo $task->title?></td>
                    <td><?php echo $task->description?></td>
                    <td><?php echo $task->department_name?></td>
                    <td><?php echo $task->creator_login?></td>
                    <td><?php echo $task->assignee_login?></td>
                    <td><?php echo $task->status?></td>
                    <td><?php echo $task->created_at?></td>
                    <td><?php echo $task->updated_at?></td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>       
<?php } ?>

<?php 
    if($_SESSION["user"]->role == "сотрудник"){
?>
<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Отдел</th>
        <th>Создатель</th>
        <th>Статус</th>
        <th>Время создания</th>
        <th>Последнее обновление</th>
        <th></th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["department_waiting_tasks"])){?>
            <?php foreach($_SESSION["department_waiting_tasks"] as $task){?> 
                <tr>
                    <td><?php echo $task->id?></td>
                    <td><?php echo $task->title?></td>
                    <td><?php echo $task->description?></td>
                    <td><?php echo $task->department_name?></td>
                    <td><?php echo $task->creator_login?></td>
                    <td><?php echo $task->status?></td>
                    <td><?php echo $task->created_at?></td>
                    <td><?php echo $task->updated_at?></td>
                    <td>
                    <form action="../Controlers/takeTasksController.php" method="post">
                        <input type="hidden" name="taskId" value="<?php echo $task->id?>">
                        <input type="hidden" name="userId" value="<?php echo $_SESSION["user"]->id?>">
                        <button type="submit" class="btn btn-primary" name="изменить">Взять</button>
                    </form>
                    </td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>

<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Отдел</th>
        <th>Создатель</th>
        <th>Исполнитель</th>
        <th>Время создания</th>
        <th>Последнее обновление</th>
        <th>Статус</th>
        <th></th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["department_my_employeeTasks"])){?>
            <?php foreach($_SESSION["department_my_employeeTasks"] as $task){?> 
                <tr>
                    <td><?php echo $task->id?></td>
                    <td><?php echo $task->title?></td>
                    <td><?php echo $task->description?></td>
                    <td><?php echo $task->department_name?></td>
                    <td><?php echo $task->creator_login?></td>
                    <td><?php echo $task->assignee_login?></td>
                    <td><?php echo $task->created_at?></td>
                    <td><?php echo $task->updated_at?></td>
                <form action="../Controlers/updateTaskStatus.php" method="post">
                    <input type="hidden" name="taskId" value="<?php echo $task->id?>">
                    <td><textarea type="text" name="status" ><?php echo $task->status?></textarea></td>
                    <td>
                        <button type="submit" class="btn btn-primary" name="изменить">Изменить</button>
                    </td>
                </form>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>
<?php } ?>