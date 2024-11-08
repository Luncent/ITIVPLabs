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

<div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../Controlers/UpdateTaskDescription.php" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Изменение описания задания</h5>
            <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userInfo">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal" id="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        </form>
    </div>
</div>
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
        <th></th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["department_my_employerTasks"])){?>
            <?php foreach($_SESSION["department_my_employerTasks"] as $task){?> 
                <tr>
                    <td><?php echo $task->id?></td>
                    <td><?php echo $task->title?></td>
                    <td><textarea readonly rows="3" type="text" name="descruption" ><?php echo $task->description?></textarea></td>
                    <td><?php echo $task->department_name?></td>
                    <td><?php echo $task->creator_login?></td>
                    <td><?php echo $task->assignee_login?></td>
                    <td><?php echo $task->status?></td>
                    <td><?php echo $task->created_at?></td>
                    <td><?php echo $task->updated_at?></td>
                    <td>
                        <button type="button" class="btn btn-primary openModal"
                        data-id="<?php echo $task->id?>"
                        data-title="<?php echo $task->title?>"
                        data-description="<?php echo $task->description?>">Изменить</button>
                    </td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>  
<script src="../js/editTaskDescription.js"></script>     
<?php } ?>

<?php 
    if($_SESSION["user"]->role == "сотрудник"){
?>
<div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="../Controlers/updateTaskStatus.php" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Изменение статуса задания</h5>
            <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userInfo">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal" id="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        </form>
    </div>
</div>
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

<?php 
require_once "../Controlers/usersController.php";
$managerNames = UsersController::getManagers($_SESSION["user"]->department_id)
?>

<form action="" method="get" class="formSearch">
    <select class="form-control" name="managerName" id="options">
        <?php foreach($managerNames as $name){?>
            <option value=<?php echo $name?>><?php echo $name?></option>
        <?php }?>
            <option selected value="">Все начальники</option>
    </select>
    <input type="text" class="form-control" name="title" id="formGroupExampleInput2" placeholder="Название задания">
    <input type="text" class="form-control" name="descr" id="formGroupExampleInput2" placeholder="Описание задачи">
    <button type="submit" class="btn btn-primary">Поиск</button>
</form>

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
                    <td><textarea readonly rows="3" type="text" name="status" ><?php echo $task->status?></textarea></td>
                    <td>
                        <button type="button" class="btn btn-primary openModal"
                        data-id="<?php echo $task->id?>"
                        data-title="<?php echo $task->title?>"
                        data-status="<?php echo $task->status?>">Изменить</button>
                    </td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>
<script src="../js/editTaskStatus.js"></script>  
<?php } ?>