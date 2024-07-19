<?php
$promoName = $_POST['promo-name'];
$promoDesc = $_POST['promo-description'];
$start_date = $_POST['promo-start-date'];
$end_date = $_POST['promo-end-date'];



$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO PROMOTIONAL (PROMOTION_NAME, DESCRIPTION, START_DATE, END_DATE) VALUES ('$promoName', $promoDesc, $start_date, $end_date)";

if ($conn->query($sql) === TRUE) {
    echo "Promo added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

