<?php
$itemName = $_POST['itemName'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$stockID = intval($_POST['stockID']);


$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_check = "SELECT COUNT(*) as count FROM STOCK WHERE STOCK_ID = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $stockID);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();
$count = intval($count);

if ($count == 0) {
    echo "Item Doesn't Exist";
} else {

    // if (empty($quantity) && empty($price) && empty($itemName)) {
    //     echo "Nothing to update.";
    //     // You may add further handling for this case if needed
    //     exit; // Optional: Exit script if nothing to update
    // } else if (!empty($quantity) && empty($price)) {
    //     $quantity = intval($quantity);
    //     $sql = "UPDATE STOCK SET COUNT_QTY = $quantity WHERE STOCK_ID = $stockID";
    // }else if (!empty($price) && empty($quantity)) {
    //     $price = intval($price);

    //     $sql = "UPDATE STOCK SET PRICE = $price WHERE STOCK_ID = $stockID";
    // } else {
    //     $price = intval($price);
    //     $quantity = intval($quantity);
        $sql = "UPDATE STOCK SET ITEM_NAME = '$itemName' , PRICE = $price, COUNT_QTY = $quantity  WHERE STOCK_ID = $stockID";
    }
    
    if (isset($sql)) {
        if ($conn->query($sql) === TRUE) {
            echo 'Update successful';
        } else {
            echo "Error: " . $conn->error;
        }
    }

$conn->close();
?>

