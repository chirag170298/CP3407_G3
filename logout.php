<?php

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the authentication page
header("Location: login.html");
?>
