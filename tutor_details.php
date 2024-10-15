<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Check if tutor_id is passed in the query string
if (!isset($_GET['tutor_id']) || !is_numeric($_GET['tutor_id'])) {
    echo 'No valid tutor selected.';
    exit;
}

$tutor_id = intval($_GET['tutor_id']);

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

// Fetch tutor details from the tutors table
$fetchTutorSql = "
    SELECT u.student_name, t.interest 
    FROM tutors t 
    JOIN users u ON t.id = u.student_id 
    WHERE t.id = ?
";
$stmt = $conn->prepare($fetchTutorSql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$tutor_result = $stmt->get_result();
$tutor = $tutor_result->fetch_assoc();

if (!$tutor) {
    echo 'Tutor not found.';
    exit;
}

// Fetch only accepted tutoring requests for this tutor
$fetchAcceptedSql = "
    SELECT u.student_name, tr.interest 
    FROM tutoring_requests tr
    JOIN users u ON tr.student_id = u.student_id
    WHERE tr.tutor_id = ? AND tr.status = 'accepted'
";
$stmt = $conn->prepare($fetchAcceptedSql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$accepted_result = $stmt->get_result();
$accepted_students = $accepted_result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tutor['student_name']); ?>'s Profile</title>
</head>
<body>
    <h1><?= htmlspecialchars($tutor['student_name']); ?>'s Profile</h1>
    <p>Subjects of Interest: <?= htmlspecialchars($tutor['interest']); ?></p>

    <h2>Accepted Students</h2>
    <?php if (!empty($accepted_students)): ?>
        <ul>
            <?php foreach ($accepted_students as $student): ?>
                <li><?= htmlspecialchars($student['student_name']); ?> - <?= htmlspecialchars($student['interest']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No students have been accepted yet.</p>
    <?php endif; ?>

    <p><a href="tutormatching.php">Back to Tutor Matching</a></p> <!-- Back link -->
</body>
</html>
