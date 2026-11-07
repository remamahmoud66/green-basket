<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int) ($_POST['product_id'] ?? 0);

if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}

header('Location: indexcart.php');
exit;