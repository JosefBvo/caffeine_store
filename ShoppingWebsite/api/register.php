<?php
// Enable error reporting
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
    echo "<p style='color:red;'>Error: All fields are required.</p>";
    exit;
}

// Insert user into DB
$stmt = $mysqli->prepare("
    INSERT INTO Users (firstName, lastName, username, email, password) 
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param('sssss', $firstName, $lastName, $username, $email, $password);

if ($stmt->execute()):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created - The Caffeine Place</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="../stylecopy.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="wrapper">
            <div class="logo">
                <a href="../index.html">The Caffeine Place</a>
            </div>
            <nav>
                <a href="../index.html">Home</a>
                <a href="../about.html">About</a>
                <a href="../products.html">Products</a>
                <a href="../contact.html">Contact</a>
                <div class="dropdown">
                    <button class="dropbtn">MORE</button>
                    <div class="dropdown-content">
                        <a href="../login.html">Login</a>
                        <a href="../signup.html">Signup</a>
                        <a href="../cart.html">Cart</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Success Section -->
    <main>
        <section class="background-color" style="padding-top: 120px;">
            <div class="signup-container">
                <div class="login-card" style="max-width: 500px; padding: 4rem;">
                    <div class="login-header">SUCCESS</div>
                    <h2 style="color: var(--pink); font-size: 3rem; margin: 2rem 0 1rem;">Account Created!</h2>
                    <p style="font-size: 1.8rem; line-height: 2.4rem; color: #333; margin-bottom: 3rem;">
                        Your account has been successfully registered. You can now log in and start shopping!
                    </p>
                    <a href="../login.html" class="add-to-cart" style="font-size: 2rem; padding: 1.5rem 3rem; display: inline-block;">
                        Go to Login
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
<?php
else:
    echo "<p style='color:red;'>Registration failed: " . $mysqli->error . "</p>";
endif;
?>
