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


if (isset($_POST['startDate'])) {
    $selectedStartDate = $_POST['startDate'];
    $selectedStartDate = new Date($selectedDate)->format('Y-m-d');

} else {
$selectedStartDate = date('Y-m-d');

    
}

if(isset($_POST['endDate'])){
    $selectedEndDate = new Date($_POST['endDate'])->format('Y-m-d');
} else {
$currentDate = date('Y-m-d');
$selectedEndDate = date('Y-m-d', strtotime($currentDate . ' +6 days'));

}



$sql = "SELECT
    SUM(Invoice.TotalAmount) AS TotalSales,
    COUNT(Invoice.InvoiceID) AS NumberOfSales,
    AVG(Invoice.TotalAmount) AS AverageSales
FROM
    Invoice
JOIN
    InvoiceDetails ON Invoice.InvoiceID = InvoiceDetails.InvoiceID
WHERE
    InvoiceDate >= '$selectedStartDate' AND InvoiceDate <= '$selectedEndDate'";

$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $sales[] = $row;
    }
} else {
    $sales = ['error' => 'No results found'];
}
header('Content-Type: application/json');
echo json_encode($sales);
$conn->close();

exit;





?>