<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/order.php';

$order = new Order($pdo);
$orders = $order->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders</title>
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
        <h1>Orders</h1>

        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Details</th>
            </tr>

            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="6">No orders yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $item): ?>
                    <tr>
                        <td><?= (int) $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['customer_name']) ?></td>
                        <td><?= htmlspecialchars($item['total']) ?></td>
                        <td><?= htmlspecialchars($item['status']) ?></td>
                        <td><?= htmlspecialchars($item['payment_status']) ?></td>
                        <td>
                            <a href="order_details.php?id=<?= $item['id'] ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </main>
</body>
</html>