<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/Category.php';

$category = new Category($pdo);
$message = '';

if (isset($_POST['add_category'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name == '') {
        $message = 'Enter the category name.';
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
                $folder = __DIR__ . '/../uploads/categories/';

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                $file_name = uniqid() . '.' . $extension;
                $image_path = 'uploads/categories/' . $file_name;
                $destination = __DIR__ . '/../' . $image_path;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $saved = $category->create($name, $description, $image_path);

                    if ($saved) {
                        header('Location: categories.php');
                        exit;
                    } else {
                        $message = 'Could not save the category.';
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
    <title>Add Category</title>
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
        <a href="categories.php">Back to categories</a>
        <h1>Add Category</h1>

        <?php if ($message != ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Description</label>
            <textarea name="description"></textarea>

            <label>Image</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" required>

            <button type="submit" name="add_category">Add Category</button>
        </form>
    </main>
</body>
</html>