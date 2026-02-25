<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty. <a href='products.php'>Go to products</a>");
}

$cart = $_SESSION['cart'];

// calculate total
$total = 0;
foreach ($cart as $item) {
    $laptopId = $item['id'];
    $qty = $item['quantity'];

    $query = $conn->query("SELECT price FROM laptops WHERE id = $laptopId");
    $row = $query->fetch_assoc();
    $price = $row['price'];

    $total += ($price * $qty);
}

$success = "";
$error = "";

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name === "" || $email === "" || $phone === "") {
        $error = "Please fill in all fields.";
    } else {
        // Insert order
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (1, ?)");
        $stmt->bind_param("d", $total);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, laptop_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $item) {
            $laptopId = $item['id'];
            $qty = $item['quantity'];

            $q = $conn->query("SELECT price FROM laptops WHERE id = $laptopId");
            $row = $q->fetch_assoc();
            $price = $row['price'];

            $itemStmt->bind_param("iiid", $orderId, $laptopId, $qty, $price);
            $itemStmt->execute();
        }
        $itemStmt->close();

        $_SESSION['cart'] = []; // clear cart

        $success = "Order placed successfully! Order ID: #" . $orderId;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Windsor Laptops Sellers</title>
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
  <h2>Checkout</h2>

  <p><strong>Total Amount:</strong>  
    <span style="color:#2563eb; font-size:18px;">
      Ksh <?php echo number_format($total, 2); ?>
    </span>
  </p>

  <?php if ($success): ?>
      <p class="success"><?php echo $success; ?></p>
      <a href="products.php" class="btn">Continue Shopping</a>

  <?php else: ?>

    <?php if ($error): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <div id="checkoutError" class="error"></div>

    <form id="checkoutForm" method="post" style="max-width:400px; margin-top:20px;">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" id="name" name="name">
      </div>

      <div class="form-group">
        <label>Email Address</label>
        <input type="email" id="email" name="email">
      </div>

      <div class="form-group">
        <label>Phone Number</label>
        <input type="text" id="phone" name="phone">
      </div>

      <button type="submit" class="btn">Place Order</button>
    </form>

  <?php endif; ?>

</div>

<script src="script.js"></script>
</body>
</html>
