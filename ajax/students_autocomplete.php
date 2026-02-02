<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT 
        id,
        student_id,
        first_name,
        last_name,
        email,
        course,
        year,
        status
    FROM students
");

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>