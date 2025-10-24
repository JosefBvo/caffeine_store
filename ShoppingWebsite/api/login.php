<?php
require_once(__DIR__ . '/../../backend_v2/db.php');

// Get form data (POST from regular HTML form)
$body = $_POST;

$username = $body['username'] ?? null;
$password = $body['password'] ?? null;

if (!$username || !$password) {
    exit('Username and password required');
}

// Query DB
$stmt = $mysqli->prepare("SELECT userID, username, password, firstName, lastName, role FROM Users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    exit('User not found');
}

$user = $result->fetch_assoc();

// Password validation
if ($password !== $user['password']) {
    exit('Invalid credentials');
}

// Successful login 
header('Location: ../index.html');
exit;
?>