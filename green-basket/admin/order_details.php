<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/order.php';

$order = new Order($pdo);

$id = (int) ($_GET['id'] ?? 0);
$item = $order->getById($id);

if (!$item) {
    exit('Order not found.');
}

$products = $order->getItems($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details</title>
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
        <a href="order.php">Back to orders</a>
        <h1>Order <?= (int) $item['id'] ?></h1>

        <p>Customer: <?= htmlspecialchars($item['customer_name']) ?></p>
        <p>Phone: <?= htmlspecialchars($item['phone']) ?></p>
        <p>Address: <?= htmlspecialchars($item['address']) ?></p>
        <p>Total: <?= htmlspecialchars($item['total']) ?></p>
        <p>Payment method: <?= htmlspecialchars($item['payment_method']) ?></p>

        <h2>Products in this order</h2>

        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= (int) $product['quantity'] ?></td>
                    <td><?= htmlspecialchars($product['subtotal']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Update order</h2>

        <form action="update_order.php" method="post">
            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">

            <label>Status</label>
            <select name="status">
                <option value="Pending" <?= $item['status'] == 'Pending' ? 'selected' : '' ?>>
                    Pending
                </option>
                <option value="Delivered" <?= $item['status'] == 'Delivered' ? 'selected' : '' ?>>
                    Delivered
                </option>
            </select>

            <label>Payment</label>
            <select name="payment_status">
                <option value="Unpaid" <?= $item['payment_status'] == 'Unpaid' ? 'selected' : '' ?>>
                    Unpaid
                </option>
                <option value="Paid" <?= $item['payment_status'] == 'Paid' ? 'selected' : '' ?>>
                    Paid
                </option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </main>
</body>
</html>