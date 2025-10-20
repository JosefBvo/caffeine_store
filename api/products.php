<?php
require_once(__DIR__ . '/../db.php');

// Simple product list endpoint. Adjust table/column names when needed
$q = isset($_GET['q']) ? $mysqli->real_escape_string($_GET['q']) : '';

if ($q !== '') {
    $stmt = $mysqli->prepare("SELECT id, name, price, stock, category, image_url, description FROM products WHERE name LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%') LIMIT 200");
    $stmt->bind_param('ss', $q, $q);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $mysqli->query("SELECT id, name, price, stock, category, image_url, description FROM products LIMIT 500");
}

if (!$result) send_json(['error' => 'Query failed: ' . $mysqli->error], 500);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

send_json($items);
?>