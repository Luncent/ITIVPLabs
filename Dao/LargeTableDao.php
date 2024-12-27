<?php
require_once "pdoForDB.php";

function getAllRows() {
    $stmt = getConnection()->prepare("SELECT * FROM large_table WHERE id < 500");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}