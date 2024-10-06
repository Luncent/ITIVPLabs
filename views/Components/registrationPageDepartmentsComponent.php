<?php 
    
?>
    <div class="mb-3">
        <label>Выберите свой отдел</label>
    </div>
    <select name="department_id" id="department">
        <?php if(isset($_SESSION["departments"])){?>
            <?php foreach($_SESSION["departments"] as $department){?> 
                <option value=<?php echo $department->id ?> > <?php echo $department->name ?> </option>
            <?php }?>
        <?php } ?>
    </select>
<?php 
    
?>