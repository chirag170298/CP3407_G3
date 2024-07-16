<?php
$itemName = $_POST['item-name'];
$quantity = parseINT($_POST['item-quantity']);
$price = parseDOUBLE($_POST['item-price']);

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_check = "SELECT COUNT(*) as count STOCK WHERE ITEM_NAME = '$itemName';"
$result_check = $conn->query($sql_check);

if ($result_check) {
    $row_check = $result_check->fetch_assoc();
    if ($row_check['count'] > 0) {
        // If Product already in table, update qty instead of inserting new
        $sql = "UPDATE STOCK SET COUNT_QTY = COUNT_QTY + '$quantity' WHERE ITEM_NAME = '$itemName';"
    } else {
        // Proceed with the insert
        $sql = "INSERT INTO STOCK (ITEM_NAME, COUNT_QTY, PRICE, Store_StoreID) VALUES ('$itemName', '$quantity', '$price')";
    }
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            echo "Item added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
} else {
    echo "Error checking for existing record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

