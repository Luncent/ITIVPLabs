EXPLAIN ANALYZE SELECT * FROM tasks
WHERE title IN ('Task 5500', 'Task 400', 'Task 9000')
AND department_id NOT IN (
    SELECT department_id FROM tasks
    WHERE title = 'Задание первое'
)

