<?php
    require_once "../DBOperations/tableOperations.php";
    require_once "../Utils/sessionHadler.php";
    
    if(searching()){
        $searchParam = $_GET["searchLine"];
        if(!empty($searchParam)){
            $selectedRows =  search($searchParam);
            if(!errorHappened()){
                $_SESSION["selectedRows"]=$selectedRows;
            }
        }
        else{
            selectAll();
        }
    }
    else{
        selectAll();
    }

    function searching(){
        return isset($_GET["action"]) && $_GET["action"]=="search";
    }

    function selectAll(){
        $selectedRows =  selectAllRows();
        if(!errorHappened()){
            $_SESSION["selectedRows"]=$selectedRows;
        }
    }
?>