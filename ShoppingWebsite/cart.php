<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item from POST
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
                'quantity' => $quantity
            ];
        }
    }
}

// Total calculation
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart - Caffeine Shop</title>
<link href='https://fonts.googleapis.com/css?family=Jomhuria' rel='stylesheet'>
<link rel="stylesheet" href="style.css">
<style>
.cart-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Jomhuria';
}

.cart-table th, .cart-table td {
    padding: 1.5rem 1rem;
    text-align: center;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.cart-table th {
    font-size: 2rem;
}

.cart-table td {
    font-size: 1.8rem;
}

.cart-total {
    text-align: right;
    font-size: 2.2rem;
    margin-top: 2rem;
}

.place-order-btn {
    display: inline-block;
    margin-top: 2rem;
    padding: 1.5rem 3rem;
    background: var(--pink);
    color: var(--white);
    font-size: 2rem;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
}
.place-order-btn:hover {
    opacity: 0.9;
    transform: translateY(-0.2rem) scale(1.01);
    transition: all 0.2s ease;
}

.empty-cart {
    text-align: center;
    font-size: 2rem;
    padding: 5rem 0;
}
</style>
</head>
<body>

<header>
<nav class="navbar">
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="products.html">Products</a>
    <a href="contact.html">Contact</a>
</nav>
</header>

<section class="cart-section">
    <h1 style="text-align:center; margin-bottom:3rem;">Your Cart</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            Total: $<?php echo number_format($total, 2); ?>
        </div>

        <form method="post" action="api/order.php" style="text-align:right;">
            <input type="hidden" name="user_id" value="2">
            <?php foreach ($_SESSION['cart'] as $skuID => $item): ?>
                <input type="hidden" name="items[<?php echo $skuID; ?>][skuID]" value="<?php echo $skuID; ?>">
                <input type="hidden" name="items[<?php echo $skuID; ?>][quantity]" value="<?php echo $item['quantity']; ?>">
            <?php endforeach; ?>
            <button type="submit" class="place-order-btn">Place Order</button>
        </form>

    <?php else: ?>
        <div class="empty-cart">Your cart is empty.</div>
    <?php endif; ?>
</section>

</body>
</html>
