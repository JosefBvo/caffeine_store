<?php
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);

$user_id = $body['user_id'] ?? null;
$items = $body['items'] ?? [];

if (!$user_id || !is_array($items) || count($items) === 0) {
    send_json(['error' => 'user_id and items are required'], 400);
}

// Calculate total of order using DB/Front-end Prices
$total = 0.0;
foreach ($items as $it) {
    $price = floatval($it['price'] ?? 0);
    $qty = intval($it['quantity'] ?? 0);
    $total += $price * $qty;
}

// Insert into orders table (Specific name of table can be changed later)
$stmt = $mysqli->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, 'pending', NOW())");
$stmt->bind_param('id', $user_id, $total);
if (!$stmt->execute()) {
    send_json(['error' => 'Order insert failed: ' . $mysqli->error], 500);
}
$order_id = $stmt->insert_id;

// Insert info into tables (again, keywords may need to be changed, see README.md for more)
$itm_stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)"); 
foreach ($items as $it) {
    $pid = intval($it['product_id'] ?? 0);
    $qty = intval($it['quantity'] ?? 0);
    $unit = floatval($it['price'] ?? 0);
    $itm_stmt->bind_param('iiid', $order_id, $pid, $qty, $unit);
    $itm_stmt->execute();
}

send_json(['success' => true, 'order_id' => $order_id], 201);
?>