<?php
//API for login functionality: Checks login credentials against what is stored in DB
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);
$email = isset($body['email']) ? $mysqli->real_escape_string($body['email']) : null;
$password = $body['password'] ?? null;

if (!$email || !$password) send_json(['error' => 'email and password required'], 400);

$res = $mysqli->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
if (!$res) send_json(['error' => 'Query failed: ' . $mysqli->error], 500);

if ($res->num_rows === 0) send_json(['error' => 'User not found'], 404);

$user = $res->fetch_assoc();
if (!password_verify($password, $user['password_hash'])) {
    send_json(['error' => 'Invalid credentials'], 401);
}

send_json(['success' => true, 'message' => 'Login successful', 'user' => ['id' => $user['id'], 'email' => $user['email']]]);
?>