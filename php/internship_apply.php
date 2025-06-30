<?php
// Set the content type to JSON for the response
header('Content-Type: application/json');

// Initialize the response array
$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Check if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = ""; // Default for XAMPP
    $dbname = "fuellens";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        $response['message'] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit();
    }

    // Basic server-side validation for required fields
    $required_fields = ['position', 'full_name', 'email', 'phone', 'university', 'course', 'year_of_study', 'cover_letter'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $response['message'] = "Error: Please fill all required fields. Missing: $field";
            echo json_encode($response);
            exit();
        }
    }

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO internship_applications (position, full_name, email, phone, university, course, year_of_study, portfolio_url, linkedin_url, cover_letter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssssssss", $position, $full_name, $email, $phone, $university, $course, $year_of_study, $portfolio_url, $linkedin_url, $cover_letter);

    // Assign form data to variables
    $position = $_POST['position'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $university = $_POST['university'];
    $course = $_POST['course'];
    $year_of_study = $_POST['year_of_study'];
    // Handle optional fields
    $portfolio_url = !empty($_POST['portfolio_url']) ? $_POST['portfolio_url'] : NULL;
    $linkedin_url = !empty($_POST['linkedin_url']) ? $_POST['linkedin_url'] : NULL;
    $cover_letter = $_POST['cover_letter'];

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Application submitted successfully!';
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle cases where the request method is not POST
    $response['message'] = 'Invalid request method.';
}

// Send the JSON response back to the client
echo json_encode($response);
?> 