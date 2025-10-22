<?php
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);

$email = $body['email'] ?? null;
$password = $body['password'] ?? null;

if (!$email || !$password) {
    send_json(['error' => 'email and password required'], 400);
}

$stmt = $mysqli->prepare("SELECT userID, email, password, firstName, lastName, role FROM Users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    send_json(['error' => 'User not found'], 404);
}

$user = $result->fetch_assoc();

// Password validation
if ($password !== $user['password']) {
    send_json(['error' => 'Invalid credentials'], 401);
}

send_json([
    'success' => true,
    'message' => 'Login successful',
    'user' => [
        'userID' => $user['userID'],
        'email' => $user['email'],
        'firstName' => $user['firstName'],
        'lastName' => $user['lastName'],
        'role' => $user['role']
    ]
]);
?>

