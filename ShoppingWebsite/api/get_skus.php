<?php
require_once(__DIR__ . '/../../backend_v2/db.php');

$query = "SELECT skuID, name, description, price, stockQuantity FROM SKU";
$result = $mysqli->query($query);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

send_json($products, 200);
?>
