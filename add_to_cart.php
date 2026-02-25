<?php
session_start();
require 'db.php';
if (!isset($_POST['laptop_id']) || !isset($_POST['quantity'])) {
    die("Invalid request.");
}

$laptop_id = intval($_POST['laptop_id']);
$quantity = intval($_POST['quantity']);

if ($quantity < 1) {
    $quantity = 1;
}
$query = $conn->query("SELECT * FROM laptops WHERE id = $laptop_id");
$laptop = $query->fetch_assoc();

if (!$laptop) {
    die("Laptop not found.");
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $laptop_id) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $laptop_id,
        'name' => $laptop['name'],
        'quantity' => $quantity
    ];
}
header("Location: cart.php");
exit;
?>
