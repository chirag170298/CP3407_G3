<?php
$itemName = $_POST['itemname'];
$quantity = intval($_POST['itemquantity']);


$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_check = "SELECT COUNT(*) as count, STOCK_ID FROM STOCK WHERE ITEM_NAME = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $itemName);
$stmt_check->execute();
$stmt_check->bind_result($count, $stockID);
$stmt_check->fetch();
$stmt_check->close();
$count = intval($count);
$stockID = intval($stockID);

if ($count == 0) {
    echo "Item Doesn't Exist";
} else {
    $sql = "UPDATE STOCK SET COUNT_QTY = COUNT_QTY + $quantity  WHERE STOCK_ID = $stockID";

if ($conn->query($sql) === TRUE) {
    echo 'Item added successfully';
} else {
    echo "Error: " . $conn->error;
}
}

$conn->close();
?>

