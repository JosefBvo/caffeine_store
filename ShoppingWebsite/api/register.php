<?php
// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB connection
require_once(__DIR__ . '/../../backend_v2/db.php');

// Get POST data
$body = $_POST;

// Extract fields
$firstName = $body['firstName'] ?? null;
$lastName  = $body['lastName'] ?? null;
$username  = $body['username'] ?? null;
$email     = $body['email'] ?? null;
$password  = $body['password'] ?? null;

// Validate required fields
if (!$firstName || !$lastName || !$username || !$email || !$password) {
    send_json(['error' => 'firstName, lastName, username, email, and password are required'], 400);
    exit;
}

// Insert user into DB
$stmt = $mysqli->prepare("
    INSERT INTO Users (firstName, lastName, username, email, password) 
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param('sssss', $firstName, $lastName, $username, $email, $password);

if ($stmt->execute()) {
    // Render HTML success page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Created - Caffeine Shop</title>
        <link rel="stylesheet" href="../style.css"> 
        <link href="https://fonts.googleapis.com/css?family=Jomhuria" rel="stylesheet">
    </head>
    <body>
        <header>
            <nav class="navbar">
                <a href="../index.html">Home</a>
                <a href="../about.html">About</a>
                <a href="../products.html">Products</a>
                <a href="../contact.html">Contact</a>
            </nav>
        </header>

        <div class="signup-container">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-header">ACCOUNT CREATED</div>
                    <h1>Your account has been successfully created!</h1>
                    <a href="../login.html" class="btn" style="font-size: 22px; padding: 16px 32px;">Go to Login</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
} else {
    // Registration failed
    send_json(['error' => 'Registration failed: ' . $mysqli->error], 500);
}
?>