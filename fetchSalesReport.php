<?php
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


$sql = "SELECT DATE_FORMAT(SaleDate, '%Y-%u') AS WeekPeriod,SUM(i.TotalAmount) AS TotalSales,COUNT(DISTINCT s.SaleID) AS NumberOfSales,AVG(i.TotalAmount) AS AverageSale FROM Sales s JOIN Invoice i ON s.SaleID = i.SaleID JOIN InvoiceDetails id ON i.InvoiceID = id.InvoiceID GROUP BY WeekPeriod ORDER BY WeekPeriod";

$result = $conn->query($sql);

$promoData = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $promoData[] = $row;
    }
} else {
    $promoData = ['error' => 'No results found'];
}
header('Content-Type: application/json');
echo json_encode($promoData);
$conn->close();

exit;



?>