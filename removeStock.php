<?php

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$mysqli = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');
$response = array('success' => false);

if (isset($_POST['stockID'])) {
    $stockID = intval($_POST['stockID']);

  if ($mysqli->connect_errno) {
      $response['message'] = 'Failed to connect to MySQL: ' . $mysqli->connect_error;
  } else {
      // Begin transaction
      $mysqli->begin_transaction();

      try {
          // SQL to delete from STOCK
          $sqlSTOCK = "DELETE FROM STOCK WHERE STOCK_ID = ?";
          if ($stmtSTOCK = $mysqli->prepare($sqlSTOCK)) {
              $stmtSTOCK->bind_param('i', $stockID);

              if (!$stmtSTOCK->execute()) {
                  throw new Exception('Failed to execute delete statement for STOCK: ' . $stmtSTOCK->error);
              }
              $stmtSTOCK->close();
          } else {
              throw new Exception('Failed to prepare statement for STOCK: ' . $mysqli->error);
          }
          // Commit transaction
          $mysqli->commit();
          $response['success'] = true;
      } catch (Exception $e) {
          // Rollback transaction
          $mysqli->rollback();
          $response['message'] = $e->getMessage();
      }

      $mysqli->close();
  }
} else {
  $response['message'] = 'Invalid STOCK_ID';
}

echo json_encode($response);
?>

