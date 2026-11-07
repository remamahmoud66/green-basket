<?php
require_once __DIR__ . '/includes/init.php';

$categories = $pdo->query('SELECT * FROM categories')->fetchAll();
$page_title = 'Categories';
require __DIR__ . '/includes/header.php';
?>

<h1>Categories</h1>

<div class="category-grid">
    <?php foreach ($categories as $category): ?>
        <?php
        $image = $category['image'];

        if ($image == '') {
            if ($category['name'] == 'Fruits') {
                $image = 'assets/images/fruits.svg';
            } else {
                $image = 'assets/images/vegetables.svg';
            }
        }
        ?>

        <a class="category-card" href="products.php?category=<?= $category['id'] ?>">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($category['name']) ?>">
            <h2><?= htmlspecialchars($category['name']) ?></h2>
        </a>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
