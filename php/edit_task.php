<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once 'db_connect.php';

if (!isset($_POST['id'], $_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['status'], $_POST['employee_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$id = intval($_POST['id']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$due_date = $_POST['due_date'];
$status = trim($_POST['status']);
$employee_id = intval($_POST['employee_id']);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$sql = 'UPDATE employee_tasks SET title=?, description=?, due_date=?, status=?, employee_id=? WHERE id=?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssii', $title, $description, $due_date, $status, $employee_id, $id);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Update failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close(); 