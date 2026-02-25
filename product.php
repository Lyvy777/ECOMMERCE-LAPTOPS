<?php
session_start();
require 'db.php';

// Ensure we have an ID in the URL
if (!isset($_GET['id'])) {
    die("Laptop ID is missing in URL.");
}

$id = intval($_GET['id']);

// Fetch laptop from database
$query = "SELECT * FROM laptops WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("Laptop not found.");
}

$laptop = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($laptop['name']); ?> - Details</title>
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
  <h2><?php echo htmlspecialchars($laptop['name']); ?></h2>

  <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
    
    <!-- Laptop Image -->
    <div style="flex: 1; min-width: 250px;">
      <img src="images/<?php echo htmlspecialchars($laptop['image_url']); ?>" 
           alt="<?php echo htmlspecialchars($laptop['name']); ?>" 
           style="width: 100%; max-width: 350px; border-radius: 8px;">
    </div>

    <!-- Laptop Details -->
    <div style="flex: 2; min-width: 260px;">
      <p><strong>Brand:</strong> <?php echo htmlspecialchars($laptop['brand']); ?></p>
      <p><strong>Processor:</strong> <?php echo htmlspecialchars($laptop['processor']); ?></p>
      <p><strong>RAM:</strong> <?php echo htmlspecialchars($laptop['ram']); ?></p>
      <p><strong>Storage:</strong> <?php echo htmlspecialchars($laptop['storage']); ?></p>

      <p><strong>Price:</strong> 
        <span style="color:#2563eb; font-size:18px; font-weight:bold;">
          Ksh <?php echo number_format($laptop['price'], 2); ?>
        </span>
      </p>

      <!-- Add to Cart Form -->
      <form class="add-to-cart-form" method="post" action="add_to_cart.php" style="margin-top: 15px;">
        <input type="hidden" name="laptop_id" value="<?php echo $laptop['id']; ?>">

        <label>Quantity:</label>
        <input type="number" name="quantity" value="1" min="1">

        <button type="submit" class="btn">Add to Cart</button>
      </form>

    </div>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
