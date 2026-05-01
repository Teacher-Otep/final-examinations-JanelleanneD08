<?php

require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $student = $stmt->fetch();

        if ($student) {
            echo json_encode(['success' => true, 'student' => $student]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No ID provided']);
}
?>
