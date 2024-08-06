<?php



// SQL query to fetch roster data for the specified week starting from weekStartDate

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


$sql = "SELECT * FROM STOCK ORDER BY ITEM_NAME ASC";

$result = $conn->query($sql);

$stockData = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $stockData[] = $row;
    }
} else {
    $stockData = ['error' => 'No results found'];
}
header('Content-Type: application/json');
echo json_encode($stockData);
$conn->close();

exit;

?>