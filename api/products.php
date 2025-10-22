<?php
require_once(__DIR__ . '/../db.php');

$q = $mysqli->real_escape_string($_GET['q'] ?? '');

if ($q !== '') {
    $stmt = $mysqli->prepare("
        SELECT skuID, name, price, stockQuantity, description 
        FROM SKU 
        WHERE name LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%')
        LIMIT 200
    ");
    $stmt->bind_param('ss', $q, $q);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $mysqli->query("SELECT skuID, name, price, stockQuantity, description FROM SKU LIMIT 500");
}

if (!$result) send_json(['error' => 'Query failed: ' . $mysqli->error], 500);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

send_json($items);
?>
