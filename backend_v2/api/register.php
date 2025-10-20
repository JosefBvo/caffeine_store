<?php
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);

if (!isset($body['email']) || !isset($body['password'])) {
    send_json(['error' => 'email and password required'], 400);
}

$email = $mysqli->real_escape_string($body['email']);
$hash = password_hash($body['password'], PASSWORD_DEFAULT);

// Adjust table/column names
$query = "INSERT INTO users (email, password_hash, created_at) VALUES ('$email', '$hash', NOW())";

if ($mysqli->query($query)) {
    send_json(['success' => true, 'message' => 'User registered'], 201);
} else {
    send_json(['error' => 'Registration failed: ' . $mysqli->error], 500);
}
?>