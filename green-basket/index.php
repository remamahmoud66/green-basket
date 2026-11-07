<?php
require_once __DIR__ . '/includes/init.php';

$page_title = 'Home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <h1>Fresh vegetables and fruits</h1>
    <p>Choose fresh products for your home.</p>
    <a class="button" href="<?= BASE_URL ?>/products.php">View products</a>
</section>

<section class="home-section">
    <h2>Shop by category</h2>
    <p>Browse our vegetables and fruits.</p>
    <a class="button" href="<?= BASE_URL ?>/categories.php">View categories</a>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>