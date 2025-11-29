<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add-to-cart post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skuID = $_POST['skuID'] ?? null;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    if ($skuID) {
        if (isset($_SESSION['cart'][$skuID])) {
            $_SESSION['cart'][$skuID]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$skuID] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }
    }
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += ($item['price'] * $item['quantity']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart - Caffeine Shop</title>

<link href="https://fonts.googleapis.com/css?family=Jomhuria" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
/* ===== CART LAYOUT ===== */
.cart-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
}

.cart-title {
    font-size: 6rem;
    text-align: center;
    margin-bottom: 3rem;
    color: var(--black);
}

/* ===== CART TABLE ===== */
.cart-table {
    width: 100%;
    background: var(--white);
    border-radius: 0.5rem;
    border-collapse: collapse;
    overflow: hidden;
}

.cart-table th {
    background: var(--pink);
    color: var(--white);
    padding: 1.5rem 1rem;
    font-size: 3rem;
    letter-spacing: 1px;
}

.cart-table td {
    padding: 1.5rem 1rem;
    text-align: center;
    font-size: 2.4rem;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    color: var(--black);
}

/* ===== TOTAL ===== */
.cart-total {
    margin-top: 2rem;
    text-align: right;
    font-size: 3.5rem;
    font-weight: bold;
    color: var(--black);
}

/* ===== BUTTON ===== */
.place-order-btn {
    display: inline-block;
    margin-top: 2rem;
    padding: 1.5rem 4rem;
    font-size: 3rem;
    letter-spacing: 1px;
    color: var(--white);
    background: var(--pink);
    border-radius: 0.4rem;
    cursor: pointer;
    text-decoration: none;
    transition: transform .2s ease, opacity .2s ease;
}

.place-order-btn:hover {
    opacity: 0.9;
    transform: translateY(-0.2rem) scale(1.01);
}

/* ===== EMPTY CART ===== */
.empty-cart {
    text-align: center;
    font-size: 3rem;
    margin-top: 6rem;
    color: var(--black);
}
</style>
</head>

<body>

<header>
    <nav class="navbar">
        <a href="index.html">HOME</a>
        <a href="about.html">ABOUT</a>
        <a href="products.html">PRODUCTS</a>
        <a href="contact.html">CONTACT</a>
    </nav>
</header>

<section class="cart-section">
    <h1 class="cart-title">YOUR CART</h1>

    <?php if (!empty($_SESSION['cart'])): ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            TOTAL: $<?= number_format($total, 2) ?>
        </div>

        <form method="POST" action="api/order.php" style="text-align: right;">
            <input type="hidden" name="user_id" value="2">
            <?php foreach ($_SESSION['cart'] as $skuID => $item): ?>
                <input type="hidden" name="items[<?= $skuID ?>][skuID]" value="<?= $skuID ?>">
                <input type="hidden" name="items[<?= $skuID ?>][quantity]" value="<?= $item['quantity'] ?>">
            <?php endforeach; ?>

            <button class="place-order-btn" type="submit">PLACE ORDER</button>
        </form>

    <?php else: ?>

        <div class="empty-cart">YOUR CART IS EMPTY</div>

    <?php endif; ?>

</section>

</body>
</html>
