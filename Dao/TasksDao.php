<?php
require_once "pdo.php";
class TaskDAO {

    // Создание задания
    public static function createTask($title, $description, $department_id, $created_by) {
        $stmt = getConnection()->prepare("INSERT INTO tasks (title, description, department_id, created_by, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'Ожидает', NOW(),NOW())");
        return $stmt->execute([$title, $description, $department_id, $created_by]);
    }

    // Обновление статуса задания
    public static function updateTaskStatus($taskId, $status) {
        $stmt = getConnection()->prepare("
            UPDATE tasks 
            SET status = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$status, $taskId]);
    }

    public static function updateTaskDescription($taskId, $description) {
        $stmt = getConnection()->prepare("
            UPDATE tasks 
            SET description = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$description, $taskId]);
    }

    public static function assignTaskToUser($taskId, $userId) {
        $stmt = getConnection()->prepare("
            UPDATE tasks 
            SET assigned_to = ?, status = 'Выполняется', updated_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$userId, $taskId]);
    }

    // Обновление задания
    public static function updateTask($id, $title, $description, $assigned_to, $status) {
        $stmt = getConnection()->prepare("UPDATE tasks SET title = ?, description = ?, assigned_to = ?, status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$title, $description, $assigned_to, $status, $id]);
    }

    // Удаление задания
    public static function deleteTask($id) {
        $stmt = getConnection()->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Выборка заданий по заголовку с данными пользователей и отдела
    public static function getTasksByTitle($title, $department_id) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                u1.login AS creator_login, 
                u2.login AS assignee_login, 
                d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            LEFT JOIN departments d ON t.department_id = d.id 
            WHERE t.title LIKE CONCAT('%', ?, '%') AND t.department_id = ?
        ");
        $stmt->execute([$title, $department_id]); // Используем LIKE для частичного соответствия
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Чтение задания по ID с данными пользователей и отдела
    public static function getTaskById($id) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   u2.login AS assignee_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            LEFT JOIN departments d ON t.department_id = d.id 
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function searchTasks($creatorName) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN departments d ON t.department_id = d.id
            WHERE t.department_id = u1.department_id AND t.assigned_to IS NULL 
            AND u1.login = ? 
        ");
        $stmt->execute([$creatorName]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function trackTaskSearch($creatorName, $userId){
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT * FROM user_preferences WHERE user_id = ? AND managerName = ?
        ");
        $stmt->execute([$userId,$creatorName]);
        if(sizeof($stmt->fetchAll(PDO::FETCH_OBJ))>0){
            $stmt = $conn->prepare("
                UPDATE user_preferences
                SET managerName_count = managerName_count + 1
                WHERE user_id = ? AND managerName=?
            ");
             $stmt->execute([$userId,$creatorName]);
        }
        else{
            $stmt = $conn->prepare("
                INSERT INTO user_preferences(user_id,managerName,managerName_count)
                VALUES (?,?,?)
            ");
             $stmt->execute([$userId,$creatorName,1]);
        }
    }

    // Выборка заданий по отделу, которые еще никто не взял с данными пользователей и отдела
    public static function getTasksByDepartmentWithoutAssignee($department_id, $userId) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN departments d ON t.department_id = d.id
            LEFT JOIN
            (
                SELECT managerName, managerName_count FROM user_preferences
                WHERE user_id= ?
            ) AS user_prefs ON user_prefs.managerName = u1.login
            WHERE t.department_id = ? AND t.assigned_to IS NULL
            ORDER BY managerName_count DESC
        ");
        $stmt->execute([$userId,$department_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Выборка всех заданий с данными пользователей и отдела
    public static function getAllTasks() {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   u2.login AS assignee_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            LEFT JOIN departments d ON t.department_id = d.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Выборка заданий по назначенному пользователю с данными пользователей и отдела
    public static function getTasksByAssignedUser($assigned_to) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   u2.login AS assignee_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            LEFT JOIN departments d ON t.department_id = d.id 
            WHERE t.assigned_to = ?
        ");
        $stmt->execute([$assigned_to]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Выборка заданий по создателю с данными пользователей и отдела
    public static function getTasksByCreator($created_by) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   u2.login AS assignee_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            LEFT JOIN departments d ON t.department_id = d.id 
            WHERE t.created_by = ?
        ");
        $stmt->execute([$created_by]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}