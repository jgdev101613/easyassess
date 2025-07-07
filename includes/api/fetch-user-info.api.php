<?php

require_once '../database/dbh.inc.php';
header('Content-Type: application/json');

if (!isset($_GET['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing user_id parameter'
    ]);
    exit();
}

$user_id = $_GET['user_id'];

try {
    // 1. Get basic user info
    $stmt = $conn->prepare("SELECT id, user_type, email, status, profile_image FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found in users table'
        ]);
        exit();
    }

    // 2. Fetch extra info from either students or professors table
    $extra = [];
    if ($user['user_type'] === 'student') {
        $stmtStudent = $conn->prepare("
            SELECT user_id, first_name, middle_name, last_name, course, year_level, section, prog_department_id 
            FROM students 
            WHERE student_id = :id
        ");
        $stmtStudent->execute([':id' => $user_id]);
        $extra = $stmtStudent->fetch(PDO::FETCH_ASSOC);
    } elseif ($user['user_type'] === 'professor') {
        $stmtProf = $conn->prepare("
            SELECT user_id, employee_id, first_name, middle_name, last_name, department, position
            FROM professors 
            WHERE employee_id = :id
        ");
        $stmtProf->execute([':id' => $user_id]);
        $extra = $stmtProf->fetch(PDO::FETCH_ASSOC);
    }

    // Merge and return
    $fullData = array_merge($user, $extra ?: []);
    echo json_encode([
        'status' => 'success',
        'data' => $fullData
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
