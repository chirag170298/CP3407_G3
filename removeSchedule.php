<?php

// Perform database operations here (replace with your actual database logic)
// Example connection setup
$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
    $username = 'CP3407admin';
    $password = 'YFtG]?$4&+k}.WJ';
    $dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['RosterID'])) {
    $rosterID = $_POST['RosterID'];

    // Example query to delete from your table
    $stmt = $conn->prepare("DELETE FROM Roster WHERE RosterID = ?");
    $stmt->bind_param('i', $rosterID); // Assuming RosterID is an integer

    if ($stmt->execute()) {
        // Successful deletion
        http_response_code(200); // Optionally, set a success response code
        echo json_encode(['success' => true, 'message' => 'Entry deleted successfully']);
    } else {
        // Failed to delete
        http_response_code(500); // Server error
        echo json_encode(['success' => false, 'message' => 'Failed to delete entry']);
    }
} else {
    // Handle case where RosterID is not set in POST
    http_response_code(400); // Bad request
    echo json_encode(['success' => false, 'message' => 'RosterID not provided']);
}
?>

