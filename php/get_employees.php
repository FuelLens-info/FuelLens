<?php
header('Content-Type: application/json');
require_once 'db_connect.php'; // Assumes you have a db_connect.php for DB connection

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT id, employee_id, name, role, created_at FROM erp_users WHERE role = 'employee'";
$result = $conn->query($sql);

$employees = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

$conn->close();
echo json_encode(['success' => true, 'employees' => $employees]); 