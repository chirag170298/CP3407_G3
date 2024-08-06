<?php
$empfname = $_POST['empfname'];
$emplname = $_POST['emplname'];
$roleID = $_POST['roleID'];
$storeID = 1;
$empname = $empfname . $emplname;

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($roleID > 3 or $roleID < 1){
    echo "RoleID invalid";
    exit;
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert into users table
$sql = "INSERT INTO users (username, password) VALUES ('$empname', 0)";
if ($conn->query($sql) === TRUE) {
    // Get the last inserted ID
    $last_id = $conn->insert_id;

    // Insert into Person table using the last inserted ID
    $sql2 = "INSERT INTO Person (FirstName, LastName, StoreID, RoleID, users_id) 
             VALUES ('$empfname', '$emplname', $storeID, $roleID, $last_id)";
    
    if ($conn->query($sql2) === TRUE) {
        echo "user added successfully";
    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
} else {
    
    echo "Error: occuring here " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
