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
        <?php
            // Retrieve interest and tutor data from URL
            if (isset($_GET['interest']) && isset($_GET['tutors'])) {
                $student_interest = $_GET['interest'];
                $tutors = json_decode(urldecode($_GET['tutors']), true);

                if (!empty($tutors)) {
                    // Assume student ID is retrieved from session or another source
                    //session_start();
                    //$student_id = $_SESSION['student_id']; // Assuming student_id is stored in session

                    foreach ($tutors as $tutor) {
                        echo '<div class="tutor">';
                        echo '<h3>' . htmlspecialchars($tutor['name']) . '</h3>';
                        echo '<p>Subjects: ' . htmlspecialchars($tutor['interest']) . '</p>';

                        // Form for requesting this tutor
                        echo '<form action="tutor_request.php" method="POST">';
                        echo '<input type="hidden" name="student_id" value="' . htmlspecialchars(45555) . '">';
                        echo '<input type="hidden" name="tutor_id" value="' . htmlspecialchars($tutor['id']) . '">'; // Add tutor ID
                        echo '<input type="hidden" name="interest" value="' . htmlspecialchars($tutor['interest']) . '">'; // Add interest
                        echo '<input type="submit" value="Request Tutor">';
                        echo '</form>';
                        
                        echo '</div>';
                    }
                } else {
                    echo '<p class="no-match">No tutors found for your interest: ' . htmlspecialchars($student_interest) . '.</p>';
                }
            } else {
                echo '<p class="no-match">No interest provided.</p>';
            }
        ?>
    </div>
</body>
</html>
