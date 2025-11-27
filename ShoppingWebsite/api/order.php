<?php
session_start();
require_once(__DIR__ . '/../../backend_v2/db.php');

// Check for POST
$user_id = $_POST['user_id'] ?? null;
$raw_items = $_POST['items'] ?? [];

if (!$user_id || !is_array($raw_items) || count($raw_items) === 0) {
    die("user_id and items are required");
}

// Normalize items array
$items = [];
foreach ($raw_items as $item) {
    if (isset($item['skuID'], $item['quantity'])) {
        $items[] = [
            'skuID' => intval($item['skuID']),
            'quantity' => intval($item['quantity'])
        ];
    }
}

if (count($items) === 0) {
    die("No valid items in order");
}

// Insert into Orders table
$stmt = $mysqli->prepare("INSERT INTO Orders (userID) VALUES (?)");
$stmt->bind_param('i', $user_id);
if (!$stmt->execute()) {
    die("Order insert failed: " . $mysqli->error);
}
$order_id = $stmt->insert_id;

// Insert into OrderLines
$itm_stmt = $mysqli->prepare("INSERT INTO OrderLines (orderID, skuID, quantity) VALUES (?, ?, ?)");
foreach ($items as $it) {
    $sku_id = $it['skuID'];
    $qty = $it['quantity'];
    if ($qty <= 0 || $sku_id <= 0) continue;
    $itm_stmt->bind_param('iii', $order_id, $sku_id, $qty);
    $itm_stmt->execute();
}

// Clear cart session
unset($_SESSION['cart']);

// Redirect to success page
header("Location: ../order_success.html");
exit;
?>
