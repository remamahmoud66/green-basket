<?php
require_once __DIR__ . '/../includes/init.php';

$cart_products = [];
$total = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $statement = $pdo->prepare(
            'SELECT * FROM products WHERE id = ?'
        );
        $statement->execute([$id]);
        $product = $statement->fetch();

        if ($product) {
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;

            $cart_products[] = $product;
            $total += $product['subtotal'];
        }
    }
}
$page_title = 'Cart';
require __DIR__ . '/../includes/header.php';
?>
    <a href="../products.php">Back to products</a>
    <h1>Shopping Cart</h1>

    <?php if (empty($cart_products)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>

        <?php foreach ($cart_products as $product): ?>
            <div class="cart-item">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p>Price: <?= htmlspecialchars($product['price']) ?></p>
            <p>Subtotal: <?= htmlspecialchars($product['subtotal']) ?></p>

            <form action="update.php" method="post">
                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product['id'] ?>"
                >
                <input
                    type="number"
                    name="quantity"
                    min="1"
                    max="<?= $product['stock'] ?>"
                    value="<?= $product['quantity'] ?>"
                >
                <button type="submit">Update quantity</button>
            </form>

            <form action="remove.php" method="post">
                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product['id'] ?>"
                >
                <button type="submit">Remove</button>
            </form>
            </div>
        <?php endforeach; ?>

        <div class="cart-summary">
            <h2>Total: <?= htmlspecialchars($total) ?></h2>
            <a class="button" href="../checkout/chec.php">Checkout</a>
        </div>
    <?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
