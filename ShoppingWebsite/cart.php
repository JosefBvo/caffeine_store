<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle POST: add or remove items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['removeID'])) {
        unset($_SESSION['cart'][$_POST['removeID']]);
    } else {
        $skuID = $_POST['skuID'] ?? null;
        $name = $_POST['name'] ?? '';
        $price = (float)($_POST['price'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

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
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Caffeine Place - Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="stylecopy.css" rel="stylesheet">
    <style>
        main { padding-top: 120px; } /* push content below fixed header */
        .place-order {
            display: inline-block;
            margin: 2rem auto 4rem;
            padding: 1rem 3rem;
            font-size: 1.8rem;
            background-color: var(--yellow);
            color: var(--white);
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .place-order:hover {
            background-color: var(--darkyellow);
        }
    </style>
</head>
<body>
<header>
    <div class="wrapper">
        <div class="logo"><a href="index.php">The Caffeine Place</a></div>
        <nav>
            <a href="index.php">home</a>
            <a href="about.html">about</a>
            <a href="contact.html">contact</a>
            <div class="dropdown">
                <button class="dropbtn">MORE
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="login.html">Login</a>
                    <a href="signup.html">Signup</a>
                    <a href="cart.php">Cart</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<main>
    <div class="products-section-title">
        <h2>YOUR CART</h2>
        <h3>Review your selected products</h3>
    </div>

    <div class="products-container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $skuID => $item): ?>
                <div class="single-card">
                    <div class="img-area">
                        <img src="img/<?php echo htmlspecialchars($skuID); ?>.jpg" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    </div>
                    <div class="info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="price">$<?php echo number_format($item['price'], 2); ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p>Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>

                        <form method="POST">
                            <input type="hidden" name="removeID" value="<?php echo htmlspecialchars($skuID); ?>">
                            <button type="submit" class="add-to-cart">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="font-size: 2rem; margin-top: 4rem; text-align:center;">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div style="text-align:center; margin: 3rem 0; font-size:2rem;">
            <strong>Total: $<?php echo number_format($total, 2); ?></strong>
        </div>
        <a href="order_success.html" class="place-order">Place Order</a>
    <?php endif; ?>
</main>
</body>
</html>

