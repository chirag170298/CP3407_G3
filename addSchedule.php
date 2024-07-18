 <?php
$employee = $_POST['employee'];
$selectedDate = $_POST['selectedDate'];
$shift = $_POST['shift'];

if ($shift == "morning"){
            $shift = 1;
        } elseif ($shift == "afternoon"){
            $shift = 2;
        } else {
            $shift = 3;
        }

$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com';
$username = 'CP3407admin';
$password = 'YFtG]?$4&+k}.WJ';
$dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_check = "SELECT COUNT(*) AS count FROM Roster WHERE Date = '$selectedDate' AND ShiftID = '$shift'";
$result_check = $conn->query($sql_check);

if ($result_check) {
    $row_check = $result_check->fetch_assoc();
    if ($row_check['count'] > 0) {
        echo "Shift already filled";
    } else {
        // Proceed with the insert
        $sql = "INSERT INTO Roster (Date, ShiftID, users_id) 
                VALUES ('$selectedDate', '$shift', $employee)";
        
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            echo "Schedule added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error checking for existing record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

