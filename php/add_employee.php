<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

if (!isset($_POST['name'], $_POST['employee_id'], $_POST['role'], $_POST['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$name = trim($_POST['name']);
$employee_id = trim($_POST['employee_id']);
$role = trim($_POST['role']);
$password = $_POST['password'];

if (strtolower($role) !== 'employee') {
    echo json_encode(['success' => false, 'error' => 'Role must be employee']);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Check for duplicate employee_id
$check = $conn->prepare('SELECT id FROM erp_users WHERE employee_id = ?');
$check->bind_param('s', $employee_id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Employee ID already exists']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

$sql = 'INSERT INTO erp_users (employee_id, role, password, name, created_at) VALUES (?, ?, ?, ?, NOW())';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $employee_id, $role, $hashed_password, $name);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Insert failed']);
}

$stmt->close();
$conn->close(); 