<?php
require_once __DIR__ . '/../includes/init.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (empty($_SESSION['cart'])) {
    exit('Your cart is empty.');
}
$page_title = 'Checkout';
require __DIR__ . '/../includes/header.php';
?>
    <h1>Checkout</h1>

    <form action="place_order.php" method="post">
        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Delivery address</label>
        <input type="text" name="address" required>

        <p>Payment method: Cash on Delivery</p>

        <button type="submit">Place order</button>
    </form>
<?php require __DIR__ . '/../includes/footer.php'; ?>
