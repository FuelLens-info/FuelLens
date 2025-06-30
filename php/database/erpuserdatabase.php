<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fuellens";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create erp_users table
$sql = "CREATE TABLE IF NOT EXISTS erp_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL UNIQUE,
    role ENUM('employee', 'admin') NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql) === TRUE) {
    echo "Table 'erp_users' created or already exists.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert default admin user if not exists
$default_employee_id = 'ADM001';
$default_name = 'Admin User';
$default_role = 'admin';
$default_password_plain = 'admin123';
$default_password_hashed = password_hash($default_password_plain, PASSWORD_DEFAULT);

// Check if admin already exists
$check_sql = "SELECT id FROM erp_users WHERE employee_id='$default_employee_id'";
$result = $conn->query($check_sql);

if ($result->num_rows == 0) {
    $insert_sql = "INSERT INTO erp_users (employee_id, role, password, name) VALUES ('$default_employee_id', '$default_role', '$default_password_hashed', '$default_name')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Default admin user created: Employee ID = $default_employee_id, Password = $default_password_plain<br>";
    } else {
        echo "Error inserting default admin user: " . $conn->error . "<br>";
    }
} else {
    echo "Default admin user already exists.<br>";
}

$conn->close();
?> 