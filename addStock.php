<?php
$itemName = $_POST['itemname'];
$quantity = $_POST['itemquantity'];
$price = $_POST['itemprice'];
$category = $_POST['itemcategory'];
$UOS = $_POST['itemunit'];
$storeID = 1;


$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_check = "SELECT COUNT(*) as count FROM STOCK WHERE ITEM_NAME = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $itemName);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();

if ($count > 0) {
    // If Product already in table, update qty instead of inserting new
    echo "Item Already Exists";
} else {
    // Proceed with the insert
    $sql = "INSERT INTO STOCK (ITEM_NAME, COUNT_QTY, PRICE, Store_StoreID, category_Type, UOS) VALUES ('$itemName', $quantity, $price, $storeID, '$category', '$UOS')";

if ($conn->query($sql) === TRUE) {
    echo "Item added successfully";
} else {
    echo "Error: " . $conn->error;
}
}

$conn->close();
?>

