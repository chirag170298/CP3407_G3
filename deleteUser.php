<?php

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$mysqli = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');
$response = array('success' => false);


if (isset($_POST['UserID'])) {
    $userID = intval($_POST['UserID']);

  if ($mysqli->connect_errno) {
      $response['message'] = 'Failed to connect to MySQL: ' . $mysqli->connect_error;
  } else {
      // Begin transaction
      $mysqli->begin_transaction();

      try {
        // SQL to delete from Users
        $sqlUsers = "DELETE FROM users WHERE id = ?";
        if ($stmtUsers = $mysqli->prepare($sqlUsers)) {
            $stmtUsers->bind_param('i', $userID);

            if (!$stmtUsers->execute()) {
                throw new Exception('Failed to execute delete statement for users: ' . $stmtUsers->error);
            }
            $stmtUsers->close();
        } else {
            throw new Exception('Failed to prepare statement for users: ' . $mysqli->error);
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

$mysqli = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');
$response = array('success' => false);


if ($mysqli->connect_errno) {
    $response['message'] = 'Failed to connect to MySQL: ' . $mysqli->connect_error;
} else {
    // Begin transaction
    $mysqli->begin_transaction();

      try {
          // SQL to delete from Person
          $sqlPerson = "DELETE FROM Person WHERE users_id = ?";
          if ($stmtPerson = $mysqli->prepare($sqlPerson)) {
              $stmtPerson->bind_param('i', $userID);

              if (!$stmtPerson->execute()) {
                  throw new Exception('Failed to execute delete statement for PERSON: ' . $stmtPerson->error);
              }
              $stmtPerson->close();
          } else {
              throw new Exception('Failed to prepare statement for PERSON: ' . $mysqli->error);
          }
          // Commit transaction
          $mysqli->commit();
          $response['success'] = true;
      } catch (Exception $e) {
          // Rollback transaction
          $mysqli->rollback();
          $response['message'] = $e->getMessage();
      }

       

      // Remove log in credentials
      

  }
} else {
  $response['message'] = 'Invalid UserID';
}

echo json_encode($response);
?>

