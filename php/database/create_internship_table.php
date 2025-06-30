<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fuellens"; // Make sure this database exists

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create internship_applications table
$sql = "CREATE TABLE IF NOT EXISTS internship_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position VARCHAR(50) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    university VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    year_of_study VARCHAR(20) NOT NULL,
    portfolio_url VARCHAR(255),
    linkedin_url VARCHAR(255),
    cover_letter TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'internship_applications' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>