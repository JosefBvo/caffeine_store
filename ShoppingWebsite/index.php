<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Caffeine Place</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link href="stylecopy.css" rel="stylesheet">
</head>
<body>
<header>
	<div class="wrapper">
		<div class="logo"><a href="#">The Caffeine Place</a></div>
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
	<!-- hero section -->
<section class="hero-section">
    <div class="section-content">
        <div class="hero-details">
            <h2 class="title">the caffeine place</h2>
            <h3 class="subtitle">number one stop for irrational caffeine</h3>
            <p class="description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
            </p>
        </div>
        <div class="hero-image-wrapper">
            <img src="womanwithitem.jpg" alt="stock image of girl eating yogurt" class="hero-image">
        </div>
    </div>
</section>

	<!-- products section -->
	<div class="products-section-title">
		<h2>OUR PRODUCTS</h2>
		<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
	</div>

	<div class="products-container">

		<!-- Example Product 1 -->
		<div class="single-card">
			<div class="img-area">
				<img src="img/1.jpg" alt="Coffee">
			</div>
			<div class="info">
				<h3>Espresso</h3>
				<p class="price">$15</p>
				<p>Rich and bold espresso shot</p>
				<form method="POST" action="cart.php">
					<input type="hidden" name="skuID" value="espresso">
					<input type="hidden" name="name" value="Espresso">
					<input type="hidden" name="price" value="15">
					<input type="number" name="quantity" value="1" min="1" style="width:60px; padding:0.5rem; margin-right:0.5rem;">
					<button type="submit" class="add-to-cart">Add to Cart</button>
				</form>
			</div>
		</div>

		<!-- Example Product 2 -->
		<div class="single-card">
			<div class="img-area">
				<img src="img/2.jpg" alt="Latte">
			</div>
			<div class="info">
				<h3>Latte</h3>
				<p class="price">$12</p>
				<p>Smooth and creamy latte</p>
				<form method="POST" action="cart.php">
					<input type="hidden" name="skuID" value="latte">
					<input type="hidden" name="name" value="Latte">
					<input type="hidden" name="price" value="12">
					<input type="number" name="quantity" value="1" min="1" style="width:60px; padding:0.5rem; margin-right:0.5rem;">
					<button type="submit" class="add-to-cart">Add to Cart</button>
				</form>
			</div>
		</div>

		<!-- Example Product 3 -->
		<div class="single-card">
			<div class="img-area">
				<img src="img/3.jpg" alt="Cappuccino">
			</div>
			<div class="info">
				<h3>Cappuccino</h3>
				<p class="price">$13</p>
				<p>Classic cappuccino with foam</p>
				<form method="POST" action="cart.php">
					<input type="hidden" name="skuID" value="cappuccino">
					<input type="hidden" name="name" value="Cappuccino">
					<input type="hidden" name="price" value="13">
					<input type="number" name="quantity" value="1" min="1" style="width:60px; padding:0.5rem; margin-right:0.5rem;">
					<button type="submit" class="add-to-cart">Add to Cart</button>
				</form>
			</div>
		</div>

	</div>
</main>
</body>
</html>
