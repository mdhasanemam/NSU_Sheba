<?php
// Start the session and database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nsu_sheba";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch all accepted clubs for the dropdown
$clubs_sql = "SELECT club_name FROM club WHERE status = 'accepted'";
$clubs_result = $conn->query($clubs_sql);

// Get the club name from the query parameter
$club_name = isset($_GET['club_name']) ? $_GET['club_name'] : '';

// Fetch members of the specified club if a club is selected
$members_result = null;
if (!empty($club_name)) {
    $sql = "SELECT u.student_name, u.student_id, cm.designation
            FROM club_members cm
            JOIN users u ON cm.id = u.student_id
            WHERE cm.club_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $club_name);
    $stmt->execute();
    $members_result = $stmt->get_result();
}

// Fetch events of the specified club if a club is selected
$events_result = null;
if (!empty($club_name)) {
    $events_sql = "SELECT event_id, event_name, description, event_date
                   FROM club_events
                   WHERE club_name = ?";
    $events_stmt = $conn->prepare($events_sql);
    $events_stmt->bind_param("s", $club_name);
    $events_stmt->execute();
    $events_result = $events_stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($club_name); ?> Members and Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center; /* Center-align content in the container */
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px; /* Add space above the form */
        }

        select {
            width: 83%; /* Full width of the parent container */
            padding: 10px; /* Padding for better spacing */
            border-radius: 4px; /* Rounded corners */
            border: 1px solid #ccc; /* Light gray border */
            background-color: #f9f9f9; /* Light background color */
            font-size: 16px; /* Font size */
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>'); /* Custom arrow icon */
            background-repeat: no-repeat; /* No repeat for the arrow */
            background-position: right 10px center; /* Position the arrow */
            background-size: 12px; /* Size of the arrow */
        }

        select:focus {
            border-color: #007BFF; /* Change border color on focus */
            outline: none; /* Remove outline */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Shadow effect on focus */
        }

        button.return-button {
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 83%;
        }

        button.return-button:hover {
            background-color: lightcoral;
        }

        .member-info, .event-info {
            background-color: lightcyan;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            display: inline-block; /* Make member/event info block inline for centering */
            text-align: left; /* Align text to the left within the block */
            width: 80%; /* Set a width to allow centering */
        }

        .event-info {
            background-color: lightgreen; /* Different background for events */
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Select a Club to View Members and Events</h1>
        
        <form action="" method="GET">
            <label for="club_name"><h3>Choose a club:</h3></label>
            <select id="club_name" name="club_name" onchange="this.form.submit()">
                <option value="">Select a club</option>
                <?php if ($clubs_result->num_rows > 0): ?>
                    <?php while ($club = $clubs_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($club['club_name']); ?>" <?php echo ($club['club_name'] === $club_name) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($club['club_name']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No clubs available</option>
                <?php endif; ?>
            </select>
        </form>

        <?php if ($members_result && $members_result->num_rows > 0): ?>
            <h2>Members of <?php echo htmlspecialchars($club_name); ?></h2>
            <form>
                <?php while ($member = $members_result->fetch_assoc()): ?>
                    <div class="member-info">
                        <strong>Name:</strong> <?php echo htmlspecialchars($member['student_name']); ?><br>
                        <strong>Student ID:</strong> <?php echo htmlspecialchars($member['student_id']); ?><br>
                        <strong>Designation:</strong> <?php echo htmlspecialchars($member['designation']); ?><br>
                    </div>
                <?php endwhile; ?>
            </form>
        <?php elseif ($members_result && $members_result->num_rows === 0): ?>
            <p>No members found for this club.</p>
        <?php endif; ?>

        <?php if ($events_result && $events_result->num_rows > 0): ?>
            <h2>Events for <?php echo htmlspecialchars($club_name); ?> Club</h2>
            <form>
                <?php while ($event = $events_result->fetch_assoc()): ?>
                    <div class="event-info">
                        <strong>Event Name:</strong> <?php echo htmlspecialchars($event['event_name']); ?><br>
                        <strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?><br>
                        <strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?><br>
                    </div>
                <?php endwhile; ?>
            </form>
        <?php elseif ($events_result && $events_result->num_rows === 0): ?>
            <p>No events found for this club.</p>
        <?php endif; ?>

        <!-- Form with a button to return to the events dashboard -->
        <form action="events_dashboard.php" method="post">
            <button type="submit" class="return-button">Back to Events Dashboard</button>
        </form>
    </div>

    <?php
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($events_stmt)) {
        $events_stmt->close();
    }
    $conn->close(); // Close the database connection
    ?>
</body>
</html>
