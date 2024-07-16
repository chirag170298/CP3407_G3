<?php
// Default to the start of the current week

$currentDate = date('Y-m-d');
if (isset($_POST['date'])) {
    $selectedDate = $_POST['date'];
    $selectedDateTime = new DateTime($selectedDate);

    // Adjust weekStartDate based on selectedDate
    if ($selectedDateTime->format('N') != 1) { // Check if the selected date is a Monday
        $weekStartDate = $selectedDateTime->modify('last monday')->format('Y-m-d');
    } else {
        $weekStartDate = $selectedDateTime->format('Y-m-d');
    }
} else {
    $selectedDate = $currentDate;
    if ($selectedDateTime->format('N') != 1) { // Check if the selected date is a Monday
        $weekStartDate = $selectedDateTime->modify('last monday')->format('Y-m-d');
    } else {
        $weekStartDate = $selectedDateTime->format('Y-m-d');
    }
}




// SQL query to fetch roster data for the specified week starting from weekStartDate
$sql = "SELECT RosterID, Date, ShiftID, users_id, PersonID, FirstName, LastName from Roster join Person on PersonID = users_id WHERE Date >= '$weekStartDate' AND Date <= DATE_ADD('$weekStartDate', INTERVAL 6 DAY)";

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query($sql);

$rosterData = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $rosterData[] = $row;
    }
} else {
    $rosterData = ['error' => 'No results found for the specified week'];
}
header('Content-Type: application/json');
echo json_encode($rosterData);
$conn->close();

exit;

?>