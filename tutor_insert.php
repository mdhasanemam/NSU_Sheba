<?php
// Database connection
$servername = "localhost";  
$username = "root";         // DB username
$password = "";             // DB password
$dbname = "nsu_sheba";      // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error = urlencode("Connection failed: " . $conn->connect_error);
    header("Location: index.php?error=$error");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $topics = trim($_POST["topics"]);
    $interests = explode(",", $topics);

    /*
    // Validate if the ID exists in the referenced table
    $checkIdSql = "SELECT id FROM another_table WHERE id = ?";
    $stmt = $conn->prepare($checkIdSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Redirect with error if tutor ID does not exist
        $error = urlencode("The tutor ID does not exist!");
        header("Location: index.php?error=$error");
        exit();
    }
    */

    foreach ($interests as $interest) {
        $interest = trim($interest);

        // Check if the same interest already exists for this tutor
        $checkInterestSql = "SELECT * FROM tutors WHERE id = ? AND interest = ?";
        $stmt = $conn->prepare($checkInterestSql);
        $stmt->bind_param("is", $id, $interest);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert the interest into the tutoring table
            $insertSql = "INSERT INTO tutors (id, interest) VALUES (?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("is", $id, $interest);

            if ($stmt->execute()) {
                // Redirect with success message
                $message = urlencode("$interest added successfully.");
                header("Location: tutoring.php?message=$message");
            } else {
                // Redirect with error message
                $error = urlencode("Error: " . $stmt->error);
                header("Location: tutoring.php?error=$error");
            }
        } else {
            // Redirect with message if interest already exists
            $error = urlencode("$interest is already listed.");
            header("Location: tutoring.php?error=$error");
        }
    }

    $stmt->close();
}

$conn->close();
?>
