<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Matching Results</title>
</head>
<body>
    <h1>Matched Tutors</h1>
    <?php
        // Simulated list of tutors
        $tutors = [
            ['name' => 'A', 'subjects' => 'Math, Physics, Chemistry'],
            ['name' => 'B', 'subjects' => 'Programming, Web Development, Databases'],
            ['name' => 'C', 'subjects' => 'English, History, Geography'],
            ['name' => 'D', 'subjects' => 'Math, Statistics, Algebra'],
            ['name' => 'E', 'subjects' => 'Biology, Chemistry, Environmental Science']
        ];

        // Get the student's interest
        if (isset($_POST['interest'])) {
            $student_interest = strtolower(trim($_POST['interest']));
            $matched = false;

            // Loop through tutors and display matched ones
            foreach ($tutors as $tutor) {
                $subjects = strtolower($tutor['subjects']);
                if (strpos($subjects, $student_interest) !== false) {
                    $matched = true;
                    echo '<div>';
                    echo '<h3>' . htmlspecialchars($tutor['name']) . '</h3>';
                    echo '<p>Subjects: ' . htmlspecialchars($tutor['subjects']) . '</p>';
                    
                    // Form for selecting this tutor
                    echo '<form action="#" method="POST">';
                    echo '<input type="hidden" name="selected_tutor" value="' . htmlspecialchars($tutor['name']) . '">';
                    echo '<input type="submit" value="Select Tutor">';
                    echo '</form>';
                    
                    echo '</div>';
                }
            }

            // If no match found
            if (!$matched) {
                echo '<p>No tutors found for your interest: ' . htmlspecialchars($student_interest) . '.</p>';
            }
        } else {
            echo '<p>No interest provided.</p>';
        }
    ?>
</body>
</html>
