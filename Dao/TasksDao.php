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

    public static function searchTasks($department_id,$creatorName, $title, $descr) {
        $query = "SELECT t.*, 
                   u1.login AS creator_login, 
                   d.name AS department_name 
                 FROM tasks t
                 LEFT JOIN users u1 ON t.created_by = u1.id
                 LEFT JOIN departments d ON t.department_id = d.id
                 WHERE t.department_id = ? AND t.assigned_to IS NULL";
        $params = [];
        $params[] = $department_id;
        if(!empty($creatorName)){
            $query.=" AND u1.login = ?";
            $params[] = $creatorName;
        }
        if(!empty($title)){
            $query.=" AND LOWER(t.title) LIKE LOWER(CONCAT('%',?,'%'))";
            $params[] = $title;
        }
        if(!empty($descr)){
            $query.=" AND LOWER(t.description) LIKE LOWER(CONCAT('%',?,'%'))";
            $params[] = $descr;
        }
        $stmt = getConnection()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function trackTaskSearch($creatorName, $title, $descr, $userId){
        $conn = getConnection();
        if(!empty($creatorName)){
            $stmt = $conn->prepare("
                INSERT INTO user_preferences2 (user_id, column_name, query_str, quantity)
                VALUES (?, 'creator', ?,1)
                ON DUPLICATE KEY UPDATE
                quantity = quantity+1;
            ");
            $stmt->execute([$userId,$creatorName]);
        }
        if(!empty($title)){
            $stmt = $conn->prepare("
                INSERT INTO user_preferences2 (user_id, column_name, query_str, quantity)
                VALUES (?, 'taskTitle', ?,1)
                ON DUPLICATE KEY UPDATE
                quantity = quantity+1;
            ");
            $stmt->execute([$userId,$title]);
        }
        if(!empty($descr)){
            $stmt = $conn->prepare("
                INSERT INTO user_preferences2 (user_id, column_name, query_str, quantity)
                VALUES (?, 'description', ?,1)
                ON DUPLICATE KEY UPDATE
                quantity = quantity+1;
            ");
            $stmt->execute([$userId,$descr]);
        }
        
    }

    // Выборка заданий по отделу, которые еще никто не взял с данными пользователей и отдела
    public static function getTasksByDepartmentWithoutAssignee($department_id, $userId) {
        $stmt = getConnection()->prepare("
            CALL GetTasks(?,?)
        ");
        $stmt->execute([$userId,$department_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

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
    
     // Выборка заданий по создателю с данными пользователей и отдела
     public static function getTasksByDescr($descr) {
        $start_memory = memory_get_usage();
        $start_time = microtime(true);
            
        $stmt = getConnection()->prepare("
            SELECT t.*, 
                   u1.login AS creator_login, 
                   u2.login AS assignee_login, 
                   d.name AS department_name 
            FROM tasks t
            JOIN users u1 ON t.created_by = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            JOIN departments d ON t.department_id = d.id 
            WHERE LOWER(t.description) LIKE LOWER(CONCAT('%',?,'%'))
        ");

        $stmt->execute([$descr]);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        $end_memory = memory_get_usage();
        $end_time = microtime(true);

        $memory_difference = $end_memory - $start_memory;
        $time_difference = number_format(($end_time - $start_time)*1000,2);
        echo "<br><b>Затраченная память: $memory_difference</b><br>";
        echo "<br><b>Затраченное время: $time_difference</b><br>";
        
        return $data;
    }


    // Выборка заданий по создателю с данными пользователей и отдела
    public static function getTasksSortedByUserSearchHistory() {
        $stmt = getConnection()->prepare("
    SELECT selection.id, title, managerName_queries_matches, titles_queries_matches, descr_queries_matches,
    managerName_queries_matches*(SELECT weight FROM properties_weights WHERE name='managerName') AS manager,
    titles_queries_matches *(SELECT weight FROM properties_weights WHERE name='title') AS titleWeight,
    descr_queries_matches*(SELECT weight FROM properties_weights WHERE name='description') AS descrWeight,
    COALESCE(managerName_queries_matches*(SELECT weight FROM properties_weights WHERE name='managerName'),0)+
    COALESCE(titles_queries_matches *(SELECT weight FROM properties_weights WHERE name='title'),0)+
    COALESCE(descr_queries_matches*(SELECT weight FROM properties_weights WHERE name='description'),0) AS summ
    FROM
    (	
    SELECT id, title, description, department_id, created_by,assigned_to,status,created_at,updated_at,creator_login,department_name,managerName_queries_matches,titles_queries_matches,SUM(descr_quantity) AS descr_queries_matches FROM 
    (
	    SELECT t.*, 
	    u1.login AS creator_login, 
	    d.name AS department_name,
	    managerName_queries_matches,
	    SUM(title_quantity) AS titles_queries_matches
	    FROM tasks t
	    LEFT JOIN users u1 ON t.created_by = u1.id
	    LEFT JOIN departments d ON t.department_id = d.id
	    LEFT JOIN
	    (
		    SELECT query_str AS managerName, quantity AS managerName_queries_matches FROM user_preferences2
    		WHERE user_id= 17 AND column_name = 'creator'
	    ) 
	    AS user_prefs_manager ON user_prefs_manager.managerName = u1.login
	    LEFT JOIN
	    (
		    SELECT query_str AS taskTitle, quantity AS title_quantity FROM user_preferences2
    		WHERE user_id= 17 AND column_name = 'taskTitle'
	    ) AS user_prefs_title ON LOWER(t.title) LIKE LOWER((CONCAT('%',user_prefs_title.taskTitle,'%'))) 
        WHERE t.department_id = 2 AND t.assigned_to IS NULL
        GROUP BY title
        )AS managers_tasktitles
        LEFT JOIN
        (
	        SELECT query_str AS descr, quantity AS descr_quantity FROM user_preferences2
	        WHERE user_id= 17 AND column_name = 'description'
        ) 
        AS user_prefs_description ON LOWER(managers_tasktitles.description) LIKE LOWER((CONCAT('%',user_prefs_description.descr,'%'))) 
        GROUP BY managers_tasktitles.description
    ) as selection
    ORDER BY summ DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}