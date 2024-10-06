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

    // Выборка заданий по отделу, которые еще никто не взял с данными пользователей и отдела
    public static function getTasksByDepartmentWithoutAssignee($department_id) {
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   d.name AS department_name 
            FROM tasks t
            LEFT JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN departments d ON t.department_id = d.id 
            WHERE t.department_id = ? AND t.assigned_to IS NULL
        ");
        $stmt->execute([$department_id]);
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

    /* Чтение задания по ID
    public static function getTaskById($id) {
        $stmt = getConnection()->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // 3Выборка заданий по отделу, которые еще никто не взял
    public static function getTasksByDepartmentWithoutAssignee($department_id) {
        $stmt = getConnection()->prepare("SELECT * FROM tasks WHERE department_id = ? AND assigned_to IS NULL");
        $stmt->execute([$department_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

     // Выборка всех заданий
     public static function getAllTasks() {
        $stmt = getConnection()->prepare("SELECT * FROM tasks");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 2Выборка заданий по назначенному пользователю
    public static function getTasksByAssignedUser($assigned_to) {
        $stmt = getConnection()->prepare("SELECT * FROM tasks WHERE assigned_to = ?");
        $stmt->execute([$assigned_to]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 1Выборка заданий по создателю
    public static function getTasksByCreator($created_by) {
        $stmt = getConnection()->prepare("SELECT * FROM tasks WHERE created_by = ?");
        $stmt->execute([$created_by]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/



     // Выборка заданий по отделу, исключая задания по указанному создателю или исполнителю
    /* public function getTasksByDepartmentExcludingUser($department_id, $excluded_user_id) {
        $stmt = getConnection()->prepare("
            SELECT * FROM tasks 
            WHERE department_id = ? 
            AND created_by <> ? 
            AND assigned_to <> ?
        ");
        $stmt->execute([$department_id, $excluded_user_id, $excluded_user_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/
}