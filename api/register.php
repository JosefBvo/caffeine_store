<?php
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);

$firstName = $body['firstName'] ?? null;
$lastName = $body['lastName'] ?? null;
$username = $body['username'] ?? null;
$email = $body['email'] ?? null;
$password = $body['password'] ?? null;

if (!$firstName || !$lastName || !$username || !$email || !$password) {
    send_json(['error' => 'firstName, lastName, username, email, and password are required'], 400);
}

// Password Creation
$stmt = $mysqli->prepare("
    INSERT INTO Users (firstName, lastName, username, email, password) 
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param('sssss', $firstName, $lastName, $username, $email, $password);

if ($stmt->execute()) {
    send_json(['success' => true, 'message' => 'User registered', 'userID' => $stmt->insert_id], 201);
} else {
    send_json(['error' => 'Registration failed: ' . $mysqli->error], 500);
}
?>
