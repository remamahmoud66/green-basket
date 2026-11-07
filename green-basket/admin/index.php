<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/Dashboard.php';

$dashboard = new Dashboard($pdo);
$summary = $dashboard->getSummary();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=6">
</head>
<body class="admin-page">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="index.php">Green Basket<span>ADMIN PANEL</span></a>
        <p class="sidebar-title">MENU</p>
        <nav class="admin-links">
            <a class="active" href="index.php">Dashboard</a>
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
        <p class="dashboard-label">STORE OVERVIEW</p>
        <h1>Dashboard</h1>
        <p class="dashboard-description">A quick look at your store.</p>

        <section class="stats-grid">
            <article class="stat-card">
                <p>Total Revenue</p>
                <h2><?= number_format((float) $summary['revenue'], 2) ?></h2>
            </article>
            <article class="stat-card">
                <p>Total Orders</p>
                <h2><?= (int) $summary['orders'] ?></h2>
            </article>
            <article class="stat-card">
                <p>Total Products</p>
                <h2><?= (int) $summary['products'] ?></h2>
            </article>
            <article class="stat-card">
                <p>Total Customers</p>
                <h2><?= (int) $summary['customers'] ?></h2>
            </article>
        </section>

        <section class="dashboard-note">
            <h2>Manage your store</h2>
            <p>Use the menu on the left to manage products, categories, and orders.</p>
        </section>
    </main>
</body>
</html>
