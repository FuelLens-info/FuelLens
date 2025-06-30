<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once 'db_connect.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT t.id, t.title, t.description, t.status, t.due_date, t.created_at, u.name as assignee_name, u.employee_id as assignee_employee_id
        FROM employee_tasks t
        JOIN erp_users u ON t.employee_id = u.id
        ORDER BY t.due_date ASC, t.created_at DESC";
$result = $conn->query($sql);

$tasks = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$conn->close();
echo json_encode(['success' => true, 'tasks' => $tasks]); 