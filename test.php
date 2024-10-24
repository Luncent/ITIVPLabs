<?php
require_once "../labs/Utils/MySessionHandler.php";
require_once "../labs/Dao/pdo.php";
$id = $_GET["id"];
$day = $_GET["day"];
$startTime = $_GET["startTime"];
$endTime = $_GET["endTime"];
$conn = getConnection();
$query = $conn->prepare(
"UPDATE schedule
SET startTime = :start,
    endTime = :end,
    dayOfWeek =:day
WHERE id = :ID ");
$query->bindParam(":start",$startTime);
$query->bindParam(":end",$endTime);
$query->bindParam(":day",$day);
$query->bindParam(":ID",$id);
return $query->execute();

?>