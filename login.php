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

    // Create SQL query
    $sql = "SELECT * FROM users AS u JOIN Person AS p ON p.users_id = u.id WHERE username='$username' AND password='$password'";

    // Execute query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Start session and store username
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['loggedin'] = true;
        $_SESSION['Name'] = $row['FirstName'] . " " . $row['LastName'];
        // Redirect to FAQ page upon successful login
        header("Location: index.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - All In One Grocery</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(to right, #e74c3c, #c0392b);
            color: #fff;
        }
        .container {
            width: 90%;
            max-width: 600px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1 {
            color: #e74c3c;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .welcome-message {
            color: #555;
            margin-bottom: 30px;
            font-size: 18px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e74c3c;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #c0392b;
        }
        .error {
            color: #c0392b;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to All In One Grocery!</h1>
        <p class="welcome-message">Please log in to access your account</p>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
