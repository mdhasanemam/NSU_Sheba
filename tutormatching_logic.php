<?php
// Database connection (update with your settings)
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

// Dummy setup for foreign key table that might contain tutor names
$dummy_tutors = [
    1 => 'Tutor A',
    2 => 'Tutor B',
    3 => 'Tutor C',
    4 => 'Tutor D',
    5 => 'Tutor E'
];

// Initialize matched tutors array
$matched_tutors = [];

if (isset($_POST['interest'])) {
    $student_interest = $_POST['interest'];

    // Query the tutors table to find matching interests
    $stmt = $conn->prepare("SELECT id, interest FROM tutors WHERE interest LIKE ?");
    $search_interest = "%{$student_interest}%";  // SQL wildcard search
    $stmt->bind_param("s", $search_interest);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tutor_id = $row['id'];
            $interest = $row['interest'];

            // Fetch tutor's name from dummy data
            $tutor_name = isset($dummy_tutors[$tutor_id]) ? $dummy_tutors[$tutor_id] : 'Unknown Tutor';

            // Store the matched tutor details in an array
            $matched_tutors[] = [
                'name' => $tutor_name,
                'interest' => $interest,
                'id' => $tutor_id
            ];
        }
    }

    $stmt->close();
}

$conn->close();

// Pass the results back to the view (tutormatching.php)
header('Location: tutormatching.php?interest=' . urlencode($student_interest) . '&tutors=' . urlencode(json_encode($matched_tutors)));
exit;
?>
