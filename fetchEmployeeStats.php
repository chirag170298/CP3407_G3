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



$sql = "SELECT p.PersonID, p.FirstName, p.LastName, p.StoreID, p.RoleID, p.users_id,
                   COALESCE(pr.FEEDBACK, 0) AS FEEDBACK,
                   COALESCE(pr.TASKS_COMPLETED, 0) AS TASKS_COMPLETED,
                   COALESCE(pr.ATTENDANCE, 0) AS ATTENDANCE,
                   COALESCE(pr.EFFICIENCY, 0) AS EFFICIENCY,
                   COALESCE(pr.TRAINING_COMPLETED, 0) AS TRAINING_COMPLETED,
                   COALESCE(IFNULL(SUM(i.TotalAmount), 0), 0) AS TotalSales
            FROM Person p
            LEFT JOIN PERFORMANCE pr ON p.PersonID = pr.PersonID
            LEFT JOIN Sales s ON p.PersonID = s.PersonID
            LEFT JOIN Invoice i ON s.SaleID = i.SaleID
            GROUP BY p.PersonID, p.FirstName, p.LastName, p.StoreID, p.RoleID, p.users_id,
                     pr.FEEDBACK, pr.TASKS_COMPLETED, pr.ATTENDANCE, pr.EFFICIENCY, pr.TRAINING_COMPLETED";$sql = "SELECT p.PersonID, p.FirstName, p.LastName, p.StoreID, p.RoleID, p.users_id,
                   COALESCE(pr.FEEDBACK, 0) AS FEEDBACK,
                   COALESCE(pr.TASKS_COMPLETED, 0) AS TASKS_COMPLETED,
                   COALESCE(pr.ATTENDANCE, 0) AS ATTENDANCE,
                   COALESCE(pr.EFFICIENCY, 0) AS EFFICIENCY,
                   COALESCE(pr.TRAINING_COMPLETED, 0) AS TRAINING_COMPLETED,
                   COALESCE(IFNULL(SUM(i.TotalAmount), 0), 0) AS TotalSales
            FROM Person p
            LEFT JOIN PERFORMANCE pr ON p.PersonID = pr.PersonID
            LEFT JOIN Sales s ON p.PersonID = s.PersonID
            LEFT JOIN Invoice i ON s.SaleID = i.SaleID
            GROUP BY p.PersonID, p.FirstName, p.LastName, p.StoreID, p.RoleID, p.users_id,
                     pr.FEEDBACK, pr.TASKS_COMPLETED, pr.ATTENDANCE, pr.EFFICIENCY, pr.TRAINING_COMPLETED";



$result = $conn->query($sql);
$employeeStats = array();


if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $employeeStats[] = $row;
    }
} else {
    $employeeStats = ['error' => 'No results found'];
}


header('Content-Type: application/json');
echo json_encode($employeeStats);
$conn->close();

exit;
?>