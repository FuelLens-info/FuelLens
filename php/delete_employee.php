<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing employee id']);
    exit;
}

$id = intval($_POST['id']);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Only delete if role is employee
$sql = "DELETE FROM erp_users WHERE id = ? AND role = 'employee'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$success = $stmt->execute();

if ($success && $stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Delete failed or not an employee']);
}

$stmt->close();
$conn->close(); 