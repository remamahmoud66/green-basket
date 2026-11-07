<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/Category.php';

$category = new Category($pdo);
$categories = $category->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=6">
</head>
<body class="admin-page">
    <aside class="admin-sidebar">
    <a class="admin-brand" href="index.php">Green Basket<span>ADMIN PANEL</span></a>
    <p class="sidebar-title">MENU</p>
    <nav class="admin-links">
        <a href="index.php">Dashboard</a>
        <a href="product.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="order.php">Orders</a>
    </nav>
    <div class="sidebar-bottom">
        <a href="../index.php">View store</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</aside>
    <main class="site-container admin-content">
        <h1>Categories</h1>

        <a class="button" href="add_category.php">Add Category</a>

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>

            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="4">No categories yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $item): ?>
                    <tr>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img
                                    src="../<?= htmlspecialchars($item['image']) ?>"
                                    width="60"
                                    height="60"
                                    alt="<?= htmlspecialchars($item['name']) ?>"
                                >
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['description'] ?? '') ?></td>

                        <td>
                            <a href="edit_category.php?id=<?= $item['id'] ?>">Edit</a>

                            <form action="delete_category.php" method="post">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </main>
</body>
</html>