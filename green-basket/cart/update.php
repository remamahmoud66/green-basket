<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int) ($_POST['product_id'] ?? 0);
$quantity = (int) ($_POST['quantity'] ?? 0);

$statement = $pdo->prepare(
    'SELECT stock FROM products WHERE id = ?'
);
$statement->execute([$id]);
$product = $statement->fetch();

if ($product && $quantity > 0 && $quantity <= $product['stock']) {
    $_SESSION['cart'][$id] = $quantity;
}

header('Location: indexcart.php');
exit;