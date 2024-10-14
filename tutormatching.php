<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Check if the tutor data exists in the session
if (!isset($_SESSION['matched_tutors'])) {
    header('Location: tutorsearch.php'); // Redirect to search page
    exit;
}

// Retrieve matched tutors from the session
$matched_tutors = $_SESSION['matched_tutors'];

// Clear session variables after use
unset($_SESSION['matched_tutors']);

// Assume student interest is stored in session
$student_interest = $_SESSION['student_interest'] ?? 'Unknown'; // Fallback if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Matching Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .tutor-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .tutor {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .tutor h3 {
            margin: 0 0 10px;
            color: black;
        }
        .tutor p {
            margin: 0 0 10px;
            color: #555;
        }
        input {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }
        input:hover {
            background-color: #0056b3;
        }
        .no-match {
            text-align: center;
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Matched Tutors</h1>
    <div class="tutor-container">
        <?php if (!empty($matched_tutors)): ?>
            <?php foreach ($matched_tutors as $tutor): ?>
                <div class="tutor">
                    <h3><?= htmlspecialchars($tutor['name']); ?></h3>
                    <p>Subjects: <?= htmlspecialchars($tutor['interest']); ?></p>

                    <!-- Form for requesting this tutor -->
                    <form action="tutor_request.php" method="POST">
                        <input type="hidden" name="tutor_id" value="<?= htmlspecialchars($tutor['id']); ?>">
                        <input type="hidden" name="interest" value="<?= htmlspecialchars($tutor['interest']); ?>">
                        <input type="submit" value="Request Tutor">
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-match">No tutors found for your interest: <?= htmlspecialchars($student_interest); ?>.</p>
        <?php endif; ?>
    </div>
</body>
</html>
