<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/product.php';
require_once __DIR__ . '/../class/Category.php';

$product = new Product($pdo);
$category = new Category($pdo);
$categories = $category->getAll();

$message = '';

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $category_id = (int) ($_POST['category_id'] ?? 0);

    if ($name == '' || $price == '' || $stock == '' || $category_id == 0) {
        $message = 'Fill in all required fields.';
    } elseif (!is_numeric($price) || $price < 0 || filter_var($stock, FILTER_VALIDATE_INT) === false || $stock < 0) {
        $message = 'Enter a valid price and stock.';
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $message = 'Choose an image.';
    } else {
        $image_info = getimagesize($_FILES['image']['tmp_name']);

        if ($image_info === false || $_FILES['image']['size'] > 2000000) {
            $message = 'Image must be smaller than 2 MB.';
        } else {
            $extension = image_type_to_extension($image_info[2], false);

            if (!in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                $message = 'Use a JPG, PNG, or WEBP image.';
            } else {
                $folder = __DIR__ . '/../uploads/products/';

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                $file_name = uniqid() . '.' . $extension;
                $image_path = 'uploads/products/' . $file_name;
                $destination = __DIR__ . '/../' . $image_path;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $saved = $product->create(
                        $name,
                        $description,
                        $price,
                        $stock,
                        $category_id,
                        $image_path
                    );

                    if ($saved) {
                        header('Location: product.php');
                        exit;
                    } else {
                        $message = 'Could not save the product.';
                    }
                } else {
                    $message = 'Could not upload the image.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
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
        <a href="product.php">Back to products</a>
        <h1>Add Product</h1>

        <?php if ($message != ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Description</label>
            <textarea name="description"></textarea>

            <label>Price</label>
            <input type="number" name="price" min="0" step="0.01" required>

            <label>Stock</label>
            <input type="number" name="stock" min="0" step="1" required>

            <label>Category</label>
            <select name="category_id" required>
                <option value="">Choose category</option>

                <?php foreach ($categories as $item): ?>
                    <option value="<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Image</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>
    </main>
</body>
</html>