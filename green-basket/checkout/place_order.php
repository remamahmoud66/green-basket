<?php
require_once __DIR__ . '/../includes/init.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: chec.php');
    exit;
}

if (empty($_SESSION['cart'])) {
    exit('Your cart is empty.');
}

$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($phone === '' || $address === '') {
    exit('Please enter your phone and address.');
}

$items = [];
$total = 0;

foreach ($_SESSION['cart'] as $id => $quantity) {
    $statement = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $statement->execute([$id]);
    $product = $statement->fetch();

    if (!$product || $quantity > $product['stock']) {
        exit('A product is not available in this quantity.');
    }

    $subtotal = $product['price'] * $quantity;
    $total += $subtotal;

    $items[] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity,
        'subtotal' => $subtotal
    ];
}

$pdo->beginTransaction();

try {
    $statement = $pdo->prepare(
        'INSERT INTO orders
        (user_id, phone, address, total, payment_method, payment_status, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)'
    );

    $statement->execute([
        $_SESSION['user']['id'], $phone, $address, $total,
        'Cash on Delivery', 'Unpaid', 'Pending'
    ]);

    $order_id = $pdo->lastInsertId();

    foreach ($items as $item) {
        $statement = $pdo->prepare(
            'INSERT INTO order_items
            (order_id, product_id, product_name, price, quantity, subtotal)
            VALUES (?, ?, ?, ?, ?, ?)'
        );

        $statement->execute([
            $order_id, $item['id'], $item['name'], $item['price'],
            $item['quantity'], $item['subtotal']
        ]);

        $statement = $pdo->prepare(
            'UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?'
        );
        $statement->execute([$item['quantity'], $item['id'], $item['quantity']]);

        if ($statement->rowCount() == 0) {
            throw new RuntimeException('Not enough stock.');
        }
    }

    $pdo->commit();
} catch (Throwable $error) {
    $pdo->rollBack();
    exit('Could not place the order. Please try again.');
}

unset($_SESSION['cart']);

header('Location: success.php?id=' . $order_id);
exit;
