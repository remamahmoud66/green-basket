<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/order.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $status = $_POST['status'] ?? '';
    $payment_status = $_POST['payment_status'] ?? '';

    if (
        in_array($status, ['Pending', 'Delivered']) &&
        in_array($payment_status, ['Unpaid', 'Paid'])
    ) {
        $order = new Order($pdo);
        $order->updateStatus($id, $status, $payment_status);
    }

    header('Location: order_details.php?id=' . $id);
    exit;
}

header('Location: order.php');
exit;