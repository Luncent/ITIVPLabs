<?php
    require_once "pdo.php";
    
    class DepartmentsDao{  
        public static function create($name) {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (:name)");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            return $conn->lastInsertId();
        }
    
        // Получение всех департаментов
        public static function readAll() {
            $conn = getConnection();
            $stmt = $conn->query("SELECT * FROM departments");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    
        // Получение департамента по ID
        public static function read($id) {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM departments WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    
        // Обновление департамента
        public static function update($id, $name) {
            $conn = getConnection();
            $stmt = $conn->prepare("UPDATE departments SET name = :name WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        }
    
        // Удаление департамента
        public static function delete($id) {
            $conn = getConnection();
            $stmt = $conn->prepare("DELETE FROM departments WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    
        // Поиск департамента по имени
        public static function searchByName($name) {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM departments WHERE name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Поиск департамента по имени и id
        public static function searchByNameAndID($name, $id) {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM departments WHERE name = :name AND id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Частичный Поиск департамента по имени
        public static function partialSearch($param) {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM departments WHERE
             name LIKE CONCAT('%', :param, '%') OR id LIKE CONCAT('%', :param, '%')");
            $stmt->bindParam(':param', $param);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>