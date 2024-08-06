<?php
include 'auth.php';
?>



<!DOCTYPE html>
<html>
<head>
    <title>ROSTER</title>
</head>
<body>
    <h1>Hello! Your roster is : <?php
$current_date = date('Y-m-d');

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

$user_id = $_SESSION['id'];

$sql = "SELECT R.Date, S.ShiftType
FROM Roster R
JOIN Shift S ON R.ShiftID = S.ShiftID
WHERE R.users_id = $user_id AND R.Date >= CURDATE()";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("i", $user_id);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result === false) {
    die("Execute failed: " . $stmt->error);
}

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Start HTML output
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Shift ID</th></tr>";

    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["Date"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ShiftType"]) . "</td>";
        echo "</tr>";
    }

    // End HTML output
    echo "</table>";
} else {
    echo "No results found for users_id: " . htmlspecialchars($users_id);
}

$stmt->close();
$conn->close();
?>


</h1>
     <h1>Just testing stuff</h1>
     <h1>Testing username: <?php echo $_SESSION['username']; ?>  </h1>
     <h1>Testing user id: <?php echo $_SESSION['id']; ?>  </h1>
    <h1>Testing roster: <?php echo $roster_today; ?> </h1>

    <h1>Testing current date: <?php echo $current_date; ?> </h1>


 
        <h1>Welcome to Our Website</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="roster.php">Roster</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
 
</body>
</html>