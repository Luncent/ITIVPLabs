<?php
    require_once "pdo.php";
    require_once "../Utils/MySessionHandler.php";

    class CoefficentsDao{

        public function getAll(){
            $conn = getConnection();
            $query = $conn->prepare("SELECT * FROM properties_weights");
            $query->execute();
            $coefficents = $query->fetchAll(PDO::FETCH_OBJ); 
            return $coefficents;
        }

        public function update($id,$weight){
            $conn = getConnection();
            $query = $conn->prepare("UPDATE properties_weights SET weight = ? WHERE id = ?");
            $bool = $query->execute([$weight, $id]);
            return $bool;
        }
    }
?>