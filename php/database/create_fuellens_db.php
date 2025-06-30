<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default for XAMPP

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE fuellens";
if ($conn->query($sql) === TRUE) {
    echo "Database 'fuellens' created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>