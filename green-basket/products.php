<?php
require_once __DIR__ . '/includes/init.php';

$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

$search = $_GET['search'] ?? '';
$category_id = $_GET['category'] ?? '';

$sql = 'SELECT * FROM products WHERE name LIKE ?';
$values = ['%' . $search . '%'];

if ($category_id != '') {
    $sql .= ' AND category_id = ?';
    $values[] = (int) $category_id;
}

$statement = $pdo->prepare($sql);
$statement->execute($values);
$products = $statement->fetchAll();

$page_title = 'Products';
require __DIR__ . '/includes/header.php';
?>

<h1>Products</h1>

<div class="products-layout">
    <aside class="product-filter">
        <h2>Filter products</h2>

        <form method="get">
            <label for="search">Product name</label>
            <input
                id="search"
                type="text"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search"
            >

            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">All categories</option>

                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category_id == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Filter</button>
        </form>
    </aside>

    <section class="product-grid">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <div class="image-placeholder">Product image</div>
                <?php endif; ?>

                <div class="product-info">
                    <h2><?= htmlspecialchars($product['name']) ?></h2>
                    <p>Price: <?= htmlspecialchars($product['price']) ?></p>
                    <a href="product.php?id=<?= $product['id'] ?>">Details</a>
                </div>
            </article>
        <?php endforeach; ?>

        <?php if (empty($products)): ?>
            <p class="empty-message">No products found.</p>
        <?php endif; ?>
    </section>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
