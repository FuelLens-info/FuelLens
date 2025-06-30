<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

if (!isset($_POST['id'], $_POST['name'], $_POST['role'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$id = intval($_POST['id']);
$name = trim($_POST['name']);
$role = trim($_POST['role']);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Only update if role is employee
$sql = "UPDATE erp_users SET name = ?, role = ? WHERE id = ? AND role = 'employee'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $name, $role, $id);
$success = $stmt->execute();

if ($success && $stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Update failed or not an employee']);
}

$stmt->close();
$conn->close(); 