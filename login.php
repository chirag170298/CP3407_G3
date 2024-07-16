<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection parameters
    $servername = 'cp3407-website-db.cfumcuommiak.ap-southeast-2.rds.amazonaws.com'; // Replace with your RDS endpoint
    $username = 'CP3407admin';
    $password = 'YFtG]?$4&+k}.WJ';
    $dbname = 'EasyGrocer';

    // Establish connection using mysqli without charset specification
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input (prevent SQL injection)
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    // $user_id = $conn->real_escape_string($_POST['user_id']);

    // Create SQL query
    $sql = "SELECT * FROM users join Person on PersonID = id WHERE username='$username' AND password='$password'";

    // Execute query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Start session and store username
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['loggedin'] = true;
        $_SESSION['Name'] = $row['FirstName'] ." " . $row['LastName'];
        // Redirect to FAQ page upon successful login
        header("Location: newIndex.php");
        exit();
    } else {
        // Display error message for invalid credentials
        $error = "Invalid username or password";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Response</title>
</head>
<body>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
