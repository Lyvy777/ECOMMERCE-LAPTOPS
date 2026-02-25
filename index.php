<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Windsor Laptops Sellers</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  <h1>Windsor Laptops Sellers</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="cart.php">
      Cart
      <span id="cartCount" class="cart-badge">
        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
      </span>
    </a>
  </nav>
</header>

<div class="container">
  <div class="hero">
    <h2 id="heroTitle">Welcome to Windsor Laptops Sellers</h2>
    <p id="heroSubtitle"></p>

    <a class="btn" href="products.php">Shop Now</a>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
