<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Change if you have a password set for root
$dbname = "fuellens"; // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_type = $_POST['login_type'] ?? 'station';

if ($login_type === 'station') {
    // Station owner login
    $email = $conn->real_escape_string($_POST['email']);
    $password_input = $_POST['password'];

    // Check if user exists
    $sql = "SELECT id, password, first_name, last_name FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password_input, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['user_email'] = $email;
            // Redirect to dashboard
            header("Location: ../dashboard.html");
            exit();
        } else {
            // Wrong password
            header("Location: ../login.html?error=Invalid email or password");
            exit();
        }
    } else {
        // User not found
        header("Location: ../login.html?error=User not found. Please register first.");
        exit();
    }
} else if ($login_type === 'erp') {
    // ERP login
    $employee_id = $conn->real_escape_string($_POST['employee_id']);
    $password_input = $_POST['password'];
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT id, password, name, role FROM erp_users WHERE employee_id='$employee_id' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password_input, $row['password'])) {
            $_SESSION['erp_id'] = $row['id'];
            $_SESSION['erp_name'] = $row['name'];
            $_SESSION['erp_role'] = $row['role'];
            if ($row['role'] === 'admin') {
                header("Location: ../admin-dashboard.html");
            } else {
                header("Location: ../employee-dashboard.html");
            }
            exit();
        } else {
            header("Location: ../login.html?error=Invalid ERP credentials");
            exit();
        }
    } else {
        header("Location: ../login.html?error=ERP user not found. Please contact admin.");
        exit();
    }
}

$conn->close();
?> 