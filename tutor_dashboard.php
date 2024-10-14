<?php
session_start(); // Start session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Fetch user details from session
$tutor_id = $_SESSION['student_id']; // Assuming the student ID is the tutor ID in this case

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

// Function to update request status
function updateRequestStatus($conn, $request_id, $status) {
    $updateSql = "UPDATE tutoring_requests SET status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ss", $status, $request_id);
    return $stmt->execute();
}

// Handle accept or reject request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    if ($action === 'accept') {
        updateRequestStatus($conn, $request_id, 'accepted');
    } elseif ($action === 'reject') {
        updateRequestStatus($conn, $request_id, 'rejected');
    }

    // Redirect to the same page to refresh the requests
    header('Location: tutor_dashboard.php');
    exit;
}

// Fetch interested topics
$interestsSql = "SELECT interest FROM tutors WHERE id = ?";
$stmt = $conn->prepare($interestsSql);
$stmt->bind_param("s", $tutor_id);
$stmt->execute();
$interestsResult = $stmt->get_result();

// Fetch pending requests
$pendingRequestsSql = "SELECT * FROM tutoring_requests WHERE tutor_id = ? AND status = 'pending'";
$stmt = $conn->prepare($pendingRequestsSql);
$stmt->bind_param("s", $tutor_id);
$stmt->execute();
$pendingRequestsResult = $stmt->get_result();

// Fetch accepted requests
$acceptedRequestsSql = "SELECT * FROM tutoring_requests WHERE tutor_id = ? AND status = 'accepted'";
$stmt = $conn->prepare($acceptedRequestsSql);
$stmt->bind_param("s", $tutor_id);
$stmt->execute();
$acceptedRequestsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard - NSU Sheba</title>
</head>
<body>
    <div>
        <h1>Tutor Dashboard</h1>

        <h2>Your Interested Topics</h2>
        <ul>
            <?php if ($interestsResult->num_rows > 0): ?>
                <?php while ($row = $interestsResult->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['interest']); ?></li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No interested topics found.</li>
            <?php endif; ?>
        </ul>

        <h2>Pending Requests</h2>
        <ul>
            <?php if ($pendingRequestsResult->num_rows > 0): ?>
                <?php while ($row = $pendingRequestsResult->fetch_assoc()): ?>
                    <li>
                        Request from Student ID: <?php echo htmlspecialchars($row['student_id']); ?> for "<?php echo htmlspecialchars($row['interest']); ?>"
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($row['request_id']); ?>">
                            <button type="submit" name="action" value="accept">Accept</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No pending requests.</li>
            <?php endif; ?>
        </ul>

        <h2>Accepted Requests</h2>
        <ul>
            <?php if ($acceptedRequestsResult->num_rows > 0): ?>
                <?php while ($row = $acceptedRequestsResult->fetch_assoc()): ?>
                    <li>Request from Student ID: <?php echo htmlspecialchars($row['student_id']); ?> for "<?php echo htmlspecialchars($row['interest']); ?>"</li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No accepted requests.</li>
            <?php endif; ?>
        </ul>

        <a href="tutoring.php">Become tutor</a>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
