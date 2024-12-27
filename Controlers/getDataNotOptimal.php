<?php
    require_once "../Dao/pdo.php";

    function getDataNotOptimized(){
        $query = "SELECT t.*, 
                u1.login AS creator_login, 
                u2.login AS assignee_login, 
                d.name AS department_name 
                FROM tasks t
                JOIN users u1 ON t.created_by = u1.id
                LEFT JOIN users u2 ON t.assigned_to = u2.id
                JOIN departments d ON t.department_id = d.id 
                WHERE LOWER(t.description) LIKE LOWER(CONCAT('%',?,'%'))";  
        try{
            $start_memory = memory_get_usage();
            $start_time = microtime(true);

            $stmt = getConnection()->prepare($query);

            $stmt->execute(['task 5599']);
            $tasks = $stmt->fetchAll(PDO::FETCH_OBJ);

            $response = [
                'tasks'=>$tasks,
            ];

            $end_memory = memory_get_usage();
            $end_time = microtime(true);
            $memory_difference = $end_memory - $start_memory;
            $time_difference = number_format(($end_time - $start_time)*1000,2);

            echo "<div style='border: 1px solid #ccc; padding: 10px; width: 80%; max-width: 420px; overflow-x: auto; background-color: #f9f9f9;'>";
            echo "<pre>" . json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "</pre>";
            echo "</div>";

            echo "<br><b>Затраченная память: $memory_difference</b><br>";
            echo "<br><b>Затраченное время: $time_difference</b><br>";
        }
        catch(Exception $ex){
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Ошибка выбора заданий ".$ex->getMessage(),
            ]);
        }
    }

    getDataNotOptimized();
?>