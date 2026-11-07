<?php
require_once __DIR__ . '/../includes/init.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
$page_title = 'Order Confirmation';
require __DIR__ . '/../includes/header.php';
?>
    <h1>Your order was placed successfully.</h1>
    <p>Order number: <?= $id ?></p>

    <a href="../products.php">Continue shopping</a>
<?php require __DIR__ . '/../includes/footer.php'; ?>
