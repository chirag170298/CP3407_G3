<?php
// auth.php

// Check if the session is not already started, then start the session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Check if the user is logged in by checking the existence of a session variable
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If the session variable is not set or is false, redirect to the login page
    header("Location: login.html");
    exit; // Ensure no further code is executed
}
?>
