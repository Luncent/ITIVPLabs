<?php 
    
?>

<table class="table table-striped table-hover tableBorder">
    <thead class="th-dark">
        <th>ID</th>
        <th>Название</th>
        <th>Значение</th>
        <th></th>
    </thead>
    <tbody>
        <?php if(isset($_SESSION["coefficients"])){?>
            <?php foreach($_SESSION["coefficients"] as $coeff){?> 
                <tr>
                    <td><?php echo $coeff->id?></td>

                    <form action="../Controlers/CoefficientsController.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $coeff->id?>">
                    <td><?php echo $coeff->name; ?></td>
                    <td><input type="text" name="weight" value="<?php echo $coeff->weight; ?>"></td>
                    <td>
                        <button type="submit" class="btn btn-primary" name="edit">Изменить</button>
                    </form>
                </tr>
            <?php }?>
        <?php } ?>
    </tbody>
</table>   