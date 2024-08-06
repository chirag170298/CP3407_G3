<?php

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; 
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

    // Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');
$response = array('success' => false);

if (isset($_POST['RosterID'])) {
    $rosterID = intval($_POST['RosterID']);

  // Check connection
  if ($mysqli->connect_errno) {
      $response['message'] = 'Failed to connect to MySQL: ' . $mysqli->connect_error;
  } else {
      // Begin transaction
      $mysqli->begin_transaction();

      try {
          // SQL to delete from TIMESHEET
          $sqlTimesheet = "DELETE FROM TIMESHEET WHERE Roster_RosterID = ?";
          if ($stmtTimesheet = $mysqli->prepare($sqlTimesheet)) {
              $stmtTimesheet->bind_param('i', $rosterID);

              if (!$stmtTimesheet->execute()) {
                  throw new Exception('Failed to execute delete statement for TIMESHEET: ' . $stmtTimesheet->error);
              }
              $stmtTimesheet->close();
          } else {
              throw new Exception('Failed to prepare statement for TIMESHEET: ' . $mysqli->error);
          }

          // SQL to delete from Roster
          $sqlRoster = "DELETE FROM Roster WHERE RosterID = ?";
          if ($stmtRoster = $mysqli->prepare($sqlRoster)) {
              $stmtRoster->bind_param('i', $rosterID);

              if (!$stmtRoster->execute()) {
                  throw new Exception('Failed to execute delete statement for Roster: ' . $stmtRoster->error);
              }
              $stmtRoster->close();
          } else {
              throw new Exception('Failed to prepare statement for Roster: ' . $mysqli->error);
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
  $response['message'] = 'Invalid RosterID';
}

echo json_encode($response);
?>

