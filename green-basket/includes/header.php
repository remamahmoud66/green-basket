<?php
$page_title = $page_title ?? 'Green Basket';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=5">
</head>
<body>
    <header class="site-header">
        <div class="site-container">
            <a class="brand" href="<?= BASE_URL ?>/index.php">Green Basket</a>

            <nav class="main-nav">
                <a href="<?= BASE_URL ?>/index.php">Home</a>
                <a href="<?= BASE_URL ?>/categories.php">Categories</a>
                <a href="<?= BASE_URL ?>/products.php">Products</a>
                <a href="<?= BASE_URL ?>/cart/indexcart.php">Cart</a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?= BASE_URL ?>/auth/profile.php">Profile</a>
                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                        <a href="<?= BASE_URL ?>/admin/index.php">Admin</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/auth/login.php">Login</a>
                    <a href="<?= BASE_URL ?>/auth/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="site-container">