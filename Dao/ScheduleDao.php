<?php
    require_once "pdo.php";
    
    class ScheduleDao{  
        public static function search($param, $department_id){
            $conn = getConnection();
            $query = self::getSearchQuery($conn, $param, $department_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public static function update($id,$day,$startTime,$endTime){
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
        }

        private static function getSearchQuery($conn, $param, $department_id){
            //admin
            if(!isset($department_id) || $department_id=="admin"){
                $query = $conn->prepare(
                "SELECT schedule.id AS id, startTime, endTime,
                 dayOfWeek, departments.name AS department, department_id
                 FROM schedule
                 JOIN departments ON department_id = departments.id
                 WHERE (schedule.id CONCAT('%', :param, '%')) OR (startTime LIKE CONCAT('%', :param, '%')) 
                 OR (endTime LIKE CONCAT('%', :param, '%')) OR (departments.name LIKE CONCAT('%', :param, '%'))
                 OR (dayOfWeek LIKE CONCAT('%', :param, '%'))");

                $query->bindParam(":param", $param);
                return $query;
            }
            else{
                $query = $conn->prepare(
                "SELECT schedule.id AS id, startTime, endTime,
                 dayOfWeek, departments.name AS department, department_id 
                 FROM schedule
                 JOIN departments ON department_id = departments.id
                 WHERE ((schedule.id LIKE CONCAT('%', :param, '%')) OR 
                  (startTime LIKE CONCAT('%', :param, '%')) OR (endTime LIKE CONCAT('%', :param, '%')) OR
                  (departments.name LIKE CONCAT('%', :param, '%')) OR (dayOfWeek LIKE CONCAT('%', :param, '%'))) 
                 AND department_id=:department_id");

                $query->bindParam(":param", $param);
                $query->bindParam(":department_id", $department_id);
                return $query;
            }
        }

        public static function delete(){
            $conn = getConnection();
            $id = $_POST["id"];
            //echo "  ".$id;
            $query = $conn->prepare("DELETE FROM schedule WHERE id=?");
            $query->execute([$id]);
            $affectedRows = $query->rowCount();
            return $affectedRows;
        }

        public static function selectAllRows($department_id){
            try{
                $conn = getConnection();
                $query = self::getSelectAllQuery($conn,$department_id);
                $query->execute(); 
                return $query->fetchAll(PDO::FETCH_OBJ); 
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        private static function getSelectAllQuery($conn, $department_id){
            //admin
            if(!isset($department_id) || $department_id=="admin"){
                $query = $conn->prepare(
                "SELECT schedule.id AS id, startTime, endTime,
                 dayOfWeek, departments.name AS department, department_id 
                 FROM schedule
                 JOIN departments ON department_id = departments.id");

                return $query;
            }
            else{
                $query = $conn->prepare(
                "SELECT schedule.id AS id, startTime, endTime,
                 dayOfWeek, departments.name AS department, department_id 
                 FROM schedule
                 JOIN departments ON department_id = departments.id
                 WHERE department_id=:department_id");

                $query->bindParam(":department_id", $department_id);
                return $query;
            }
        }

        //для проверки сущ записи при вставке 
        public static function selectCertainRows($dayOfWeek, $department_id){
            $conn = getConnection();
            $query = $conn->prepare("SELECT * FROM schedule WHERE department_id=?
                AND dayOfWeek=?");
            $query->execute([$department_id,$dayOfWeek]);
            return $query->fetchAll(PDO::FETCH_OBJ); 
        }

        public static function add($dayOfWeek, $startTime,$endTime,$department_id){
            $conn = getConnection();
            $query = $conn->prepare("INSERT INTO schedule(dayOfWeek, startTime, endTime, department_id)
                VALUES (?,?,?,?)");
            $query->execute([$dayOfWeek,$startTime,$endTime,$department_id]);
        }
    }
?>