<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Change if you have a password set for root
$dbname = "fuellens"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize POST data
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash
$company_name = $conn->real_escape_string($_POST['company_name']);
$company_type = $conn->real_escape_string($_POST['company_type']);
$address = $conn->real_escape_string($_POST['address']);
$city = $conn->real_escape_string($_POST['city']);
$state = $conn->real_escape_string($_POST['state']);
$zip_code = $conn->real_escape_string($_POST['zip_code']);
$country = $conn->real_escape_string($_POST['country']);
$terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;
$privacy_accepted = isset($_POST['privacy_accepted']) ? 1 : 0;
$marketing_accepted = isset($_POST['marketing_accepted']) ? 1 : 0;

// Check if email already exists
$check_email = $conn->query("SELECT id FROM users WHERE email='$email'");
if ($check_email->num_rows > 0) {
    // Email already registered
    header("Location: ../register.html?error=Email already registered");
    exit();
}

// Insert into database
$sql = "INSERT INTO users (first_name, last_name, email, phone, password, company_name, company_type, address, city, state, zip_code, country, terms_accepted, privacy_accepted, marketing_accepted)
        VALUES ('$first_name', '$last_name', '$email', '$phone', '$password', '$company_name', '$company_type', '$address', '$city', '$state', '$zip_code', '$country', $terms_accepted, $privacy_accepted, $marketing_accepted)";

if ($conn->query($sql) === TRUE) {
    // Registration successful
    header("Location: ../login.html?success=Account created successfully");
    exit();
} else {
    // Error
    header("Location: ../register.html?error=Registration failed");
    exit();
}

$conn->close();
?> 