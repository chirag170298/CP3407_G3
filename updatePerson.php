<?php
$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);


$ID = intval($_POST['PersonID']);
$empfname = $_POST['empfname'];
$emplname = $_POST['emplname'];
$storeID = intval($_POST['StoreID']);
$roleID = intval($_POST['RoleID']);
$userID = intval($_POST['UserID']);
$DBusername = $_POST['Username'];


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE Person SET FirstName = ?, LastName = ?, StoreID = ?, RoleID = ? WHERE PersonID = ?");
$stmt->bind_param("ssiii", $empfname, $emplname, $storeID, $roleID, $ID);

// Execute the statement
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>

