<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int) ($_POST['product_id'] ?? 0);

$statement = $pdo->prepare(
    'SELECT stock FROM products WHERE id = ?'
);
$statement->execute([$id]);
$product = $statement->fetch();

if ($product && $product['stock'] > 0) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }

    if ($_SESSION['cart'][$id] < $product['stock']) {
        $_SESSION['cart'][$id]++;
    }
}

header('Location: indexcart.php');
exit;