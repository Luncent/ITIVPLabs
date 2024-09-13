<?php 
    require_once "../Utils/sessionHadler.php";
    require_once "../DBOperations/tableOperations.php";

    if(errorHappened()){
        header("Location: ../views/index.php");
        return;
    }
    
    $id = $_POST["id"];
    echo $id;

    $deletedRows = delete($id);
    if(errorHappened()){
        header("Location: ../views/index.php");
        return;
    }
    //TODO считать количество удаленных строк чтоы обнаружить удалено 0 строк
    else if(isset($deletedRows) && ($deletedRows==0)){
        addErrorMessage("Запись отсутствует в бд");
        header("Location: ../views/index.php");
        return;
    }
    else{
        addErrorMessage("Запись удалена");
    }
    header("Location: ../views/index.php");
    return;
?>