 <?php
// // Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Collect form data
//     $employeeID = $_POST['employee'];
//     $date = $_POST['date'];
//     $shift = $_POST['shift'];
//     if ($shift == "morning"){
//         $shift = 1;
//     } elseif ($shift == "afternoon"){
//         $shift = 2;
//     } else {
//         $shift = 3;
//     }

    
//     // Here you would typically perform validation and sanitation of input data
    
//     // Connect to your database (example: replace with your actual database connection details)
//     $servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
//     $username = 'CP3407admin';
//     $password = 'YFtG]?$4&+k}.WJ';
//     $dbname = 'EasyGrocer';
    
//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);
    
//     // Check connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }
    
//     // SQL to insert data into your schedule table (adjust table and column names as per your database schema)
//     $sql = "INSERT INTO Roster (Date, ShiftID, users_id) VALUES ( '$date', '$shift', $employeeID)";
    
//     if ($conn->query($sql) === TRUE) {
//         echo "Schedule added successfully";
//         // echo "User id: " $
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
    
//     // Close connection
//     $conn->close();
// }


// Example PHP script to handle adding schedule to database
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

// Perform database operations here (replace with your actual database logic)
// Example connection setup
$servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
    $username = 'CP3407admin';
    $password = 'YFtG]?$4&+k}.WJ';
    $dbname = 'EasyGrocer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $sql = $sql = "INSERT INTO Roster (Date, ShiftID, users_id) 
// VALUES ('$selectedDate', '$shift', $employee)
// ON DUPLICATE KEY UPDATE users_id = $employee";
// $stmt = $conn->prepare($sql);

// if ($stmt->execute()) {
//     if ($stmt->rowCount() > 0) {
//         echo "Schedule added successfully";
//     } else {
//         echo "Shift already filled";
//     }
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

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

