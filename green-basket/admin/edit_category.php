<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/Category.php';

$category = new Category($pdo);

$id = (int) ($_GET['id'] ?? 0);
$item = $category->getById($id);

if (!$item) {
    exit('Category not found.');
}

$message = '';
$image_path = $item['image'];

if (isset($_POST['update_category'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name == '') {
        $message = 'Enter the category name.';
    } else {
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
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

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $message = 'Could not upload the image.';
                    }
                }
            }
        } elseif ($_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            $message = 'Could not upload the image.';
        }

        if ($message == '') {
            $saved = $category->update($id, $name, $description, $image_path);

            if ($saved) {
                header('Location: categories.php');
                exit;
            } else {
                $message = 'Could not update the category.';
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
    <title>Edit Category</title>
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
        <h1>Edit Category</h1>

        <?php if ($message != ''): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label>Name</label>
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($item['name']) ?>"
                required
            >

            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>

            <label>Current image</label>

            <?php if (!empty($item['image'])): ?>
                <img
                    src="../<?= htmlspecialchars($item['image']) ?>"
                    width="100"
                    alt="<?= htmlspecialchars($item['name']) ?>"
                >
            <?php else: ?>
                <p>No image</p>
            <?php endif; ?>

            <label>New image (optional)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">

            <button type="submit" name="update_category">Save Changes</button>
        </form>
    </main>
</body>
</html>