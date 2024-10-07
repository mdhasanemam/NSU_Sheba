<?php
session_start(); // Start session to access session variables

// Database connection
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "nsu_sheba";      

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the student ID, tutor ID, and interest from form input
    $student_id = intval($_POST["student_id"]);
    $tutor_id = intval($_POST["tutor_id"]);
    $interest = trim($_POST["interest"]);

    /*
    // Validate if student and tutor IDs exist in the accounts table
    $checkIdsSql = "SELECT id FROM accounts WHERE id = ? OR id = ?";
    $stmt = $conn->prepare($checkIdsSql);
    $stmt->bind_param("ii", $student_id, $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 2) {
        echo "Either the student or tutor ID does not exist!";
    } else {*/
        // Check if the same request already exists
        $checkRequestSql = "SELECT * FROM tutoring_requests WHERE student_id = ? AND tutor_id = ? AND interest = ?";
        $stmt = $conn->prepare($checkRequestSql);
        $stmt->bind_param("iis", $student_id, $tutor_id, $interest);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert the request into the tutoring_requests table
            $insertSql = "INSERT INTO tutoring_requests (student_id, tutor_id, interest) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("iis", $student_id, $tutor_id, $interest);

            if ($stmt->execute()) {
                echo "Tutoring request sent successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "You have already requested this tutor for the same interest.";
        }
    //}
    $stmt->close();
}

$conn->close();
?>
