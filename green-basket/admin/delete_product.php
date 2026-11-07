<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/product.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $product = new Product($pdo);
    $product->delete($id);
}

header('Location: product.php');
exit;