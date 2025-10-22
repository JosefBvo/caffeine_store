<?php
<?php
require_once(__DIR__ . '/../db.php');

$body = json_decode(file_get_contents('php://input'), true);

$user_id = $body['user_id'] ?? null;
$items = $body['items'] ?? [];

if (!$user_id || !is_array($items) || count($items) === 0) {
    send_json(['error' => 'user_id and items are required'], 400);
}

// Insert into Orders table
$stmt = $mysqli->prepare("INSERT INTO Orders (userID) VALUES (?)");
$stmt->bind_param('i', $user_id);
if (!$stmt->execute()) {
    send_json(['error' => 'Order insert failed: ' . $mysqli->error], 500);
}
$order_id = $stmt->insert_id;

// Insert into OrderLines table
$itm_stmt = $mysqli->prepare("INSERT INTO OrderLines (orderID, skuID, quantity) VALUES (?, ?, ?)");
foreach ($items as $it) {
    $sku_id = intval($it['skuID'] ?? 0);
    $qty = intval($it['quantity'] ?? 0);
    if ($qty <= 0 || $sku_id <= 0) continue;
    $itm_stmt->bind_param('iii', $order_id, $sku_id, $qty);
    $itm_stmt->execute();
}

send_json(['success' => true, 'order_id' => $order_id], 201);
?>
