<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart - Windsor Laptops Sellers</title>
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
  <h2>Your Shopping Cart</h2>

  <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
      <p>Your cart is empty.</p>
      <a href="products.php" class="btn">Go to Products</a>

  <?php else: ?>

  <table class="cart-table">
    <thead>
      <tr>
        <th>Laptop</th>
        <th>Price (Ksh)</th>
        <th>Quantity</th>
        <th>Subtotal (Ksh)</th>
      </tr>
    </thead>
    <tbody>

    <?php
      require 'db.php';
      $grandTotal = 0;
      $stmt = $conn->prepare("SELECT name, price FROM laptops WHERE id = ?");

      foreach ($_SESSION['cart'] as $item):
        $laptop_id = intval($item['id']);
        $qty = intval($item['quantity']);

        $stmt->bind_param("i", $laptop_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $laptop = $result->fetch_assoc();

        if($laptop) {
            $price = $laptop['price'];
            $subtotal = $price * $qty;
            $grandTotal += $subtotal;
    ?>

      <tr>
        <td><?php echo htmlspecialchars($laptop['name']); ?></td>
        <td><?php echo number_format($price, 2); ?></td>
        <td>
          <input type="number" 
                 class="qty-input"
                 value="<?php echo $qty; ?>" 
                 min="1"
                 data-price="<?php echo $price; ?>">
        </td>
        <td class="subtotal"><?php echo number_format($subtotal, 2); ?></td>
      </tr>

    <?php 
        }
      endforeach; 
      $stmt->close();
    ?>

    </tbody>
  </table>

  <div class="cart-summary">
    <h3>Total: Ksh <span id="grandTotal"><?php echo number_format($grandTotal, 2); ?></span></h3>
    <a href="checkout.php" class="btn">Proceed to Checkout</a>
  </div>

  <?php endif; ?>

</div>

<script src="script.js"></script>
</body>
</html>
