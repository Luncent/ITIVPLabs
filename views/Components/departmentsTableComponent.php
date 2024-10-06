<?php 
?>

<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название отдела</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["departments"])){?>
            <?php foreach($_SESSION["departments"] as $department){?> 
                <tr>
                    <td><?php echo $department->id?></td>

                    <form action="../Controlers/UpdateDepartmentControler.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $department->id?>">
                    <td><input type="text" name="departmentName" value="<?php echo $department->name; ?>"></td>

                    <td>
                        <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                    </form>

                    <td>
                        <form action="../Controlers/deleteDepartmentControler.php" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $department->id?>">
                            <button type="submit" class="btn btn-primary" name="delete">delete</button>
                        </form>
                    </td>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>      