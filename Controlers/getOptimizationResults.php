<?php
    header('Content-Type: application/json');

    function getAllTasksOptimized(){
        $iterations = 10;
        $notOptimizedUrl = "http://localhost:8083/labs/Controlers/getDataOptimized.php";

        $overall_start_memory = memory_get_usage();
        $overall_start_time = microtime(true);
        $results=[];
        try{
            for($i=1; $i<=$iterations; $i++){
                $start_memory = memory_get_usage();
                $start_time = microtime(true);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $notOptimizedUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                $url_responce = json_decode(curl_exec($curl));
            
                $end_memory = memory_get_usage();
                $end_time = microtime(true);

                curl_close($curl);

                $memory_difference = $end_memory - $start_memory;
                $time_difference = ($end_time - $start_time)*1000;

                $results[] = [
                    //'exec_time'=>$time_difference,
                    //'memory'=>$memory_difference,
                    'data'=>$url_responce,
                ];
            }
            $overall_end_memory = memory_get_usage();
            $overall_end_time = microtime(true);
            
            $overall_memory_difference = $overall_end_memory - $overall_start_memory;
            $overall_time_difference = ($overall_end_time - $overall_start_time)*1000;
            $avg_time_difference = $overall_time_difference/$iterations;
            $avg_memory_difference = $overall_memory_difference/$iterations;

            $response = [
                'overall_exec_time'=>$overall_time_difference,
                'overall_memory'=> $overall_memory_difference,
                'avg_time'=>$avg_time_difference,
                'avg_memory'=>$avg_memory_difference,
                'data'=>$results,
            ];

            echo json_encode($response);
        }
        catch(Exception $ex){
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Ошибка выбора заданий "+$ex->getMessage(),
            ]);
        }
    }

    getAllTasksOptimized();
?>