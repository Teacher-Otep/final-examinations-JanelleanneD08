<?php

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['update_id'] ?? '';
    $name = $_POST['update_name'] ?? '';
    $surname = $_POST['update_surname'] ?? '';
    $middlename = $_POST['update_middlename'] ?? '';
    $address = $_POST['update_address'] ?? '';
    $contact = $_POST['update_contact'] ?? '';

    try {
        $sql = "UPDATE students SET name = :name, surname = :surname, middlename = :middlename, address = :address, contact_number = :contact WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id'         => $id,
            ':name'       => $name,
            ':surname'    => $surname,
            ':middlename' => $middlename,
            ':address'    => $address,
            ':contact'    => $contact
        ]);

        header("Location: ../index.php?status=updated");
        exit();
        
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>
