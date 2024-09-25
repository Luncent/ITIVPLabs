<?php 
    TableDataController::selectData($_SESSION["user"]->department);
    $isUser = $_SESSION["user"]->role == "сотрудник";
?>

<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>День недели</th>
        <th>Начало смены</th>
        <th>Конец смены</th>
        <th>Отдел</th>
      <?php if(!$isUser){ ?>
        <th></th>
        <th></th>
      <?php }?>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["selectedRows"])){?>
            <?php foreach($_SESSION["selectedRows"] as $row){?> 
                <tr>
                    <td><?php echo $row->id?></td>
                    <td><?php echo $row->dayOfWeek?></td>
                    <td><?php echo $row->startTime?></td>
                    <td><?php echo $row->endTime?></td>
                    <td><?php echo $row->departmentName?></td>
                  <?php if(!$isUser){ ?>
                    <td>
                        <form action="../Controlers/deleteRowControler.php" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $row->id?>">
                            <button type="submit" class="btn btn-primary" name="delete">delete</button>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" name="edit">edit</button>
                    </td>
                  <?php }?>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>       