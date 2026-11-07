<?php
require_once __DIR__ . '/includes/init.php';

$id = (int) ($_GET['id'] ?? 0);
$statement = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$statement->execute([$id]);
$product = $statement->fetch();

if (!$product) {
    exit('Product not found');
}

$page_title = $product['name'];
require __DIR__ . '/includes/header.php';
?>
<a href="products.php">Back to products</a>

<div class="detail-card">
    <div>
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p><?= htmlspecialchars($product['description'] ?? '') ?></p>
        <p>Price: <?= htmlspecialchars($product['price']) ?></p>
        <p>Available quantity: <?= (int) $product['stock'] ?></p>

        <form action="cart/add.php" method="post">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit">Add to cart</button>
        </form>
    </div>

    <div class="detail-image">
        <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <?php else: ?>
            <div class="image-placeholder">Product image</div>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
