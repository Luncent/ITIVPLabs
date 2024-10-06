<form action="../Controlers/addDepartmentController.php" method="post" class="formAdd">
 <div class="formDataContainer">
    <input type="hidden" name="action" value="add">
    <div class="addLabelcls">
        <label class ="addLabel">Добавление отдела</label>
    </div>
    <label>Название</label>
    <input type="text" name="departmentName">
    <div class="buttonAdd">
        <button type="submit" class="btn btn-primary" name="add">Add</button>
    </div>
 </div>
</form>