<?php 
    if($_SESSION["user"]->role!="начальник отдела"){
        return;
    }
?>
<form action="../Controlers/addTaskController.php" method="post" class="formAdd">
    <input type="hidden" name="action" value="add">
    <div class="addLabelcls">
        <label class ="addLabel">Добавление задания</label>
    </div>
    <div class="formDataContainer">
        <label for="options">Название</label>
        <input type="text" name="title" value="">
        <label for="options">Описание</label>
        <textarea name="description"></textarea>
        <input type="hidden" name="department_id" value="<?php echo $_SESSION["user"]->department_id?>">
        <input type="hidden" name="created_by" value="<?php echo $_SESSION["user"]->id?>">
        <div class="buttonAdd">
            <button type="submit" class="btn btn-primary" name="add">Add</button>
        </div>
    </div>
</form>