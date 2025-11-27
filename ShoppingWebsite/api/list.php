<?php
require_once(__DIR__ . '/../db.php');

$q = $mysqli->query("SELECT skuID, name, description, price, stockQuantity FROM SKU");

$items = [];

while ($row = $q->fetch_assoc()) {
    $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode($items);
