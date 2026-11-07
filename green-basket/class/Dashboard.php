<?php
class Dashboard
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSummary(): array
    {
        $revenue = $this->pdo->query(
            "SELECT COALESCE(SUM(total), 0) FROM orders WHERE payment_status = 'Paid'"
        )->fetchColumn();

        $orders = $this->pdo->query(
            'SELECT COUNT(*) FROM orders'
        )->fetchColumn();

        $products = $this->pdo->query(
            'SELECT COUNT(*) FROM products'
        )->fetchColumn();

        $customers = $this->pdo->query(
            "SELECT COUNT(*) FROM users WHERE role = 'customer'"
        )->fetchColumn();

        return [
            'revenue' => $revenue,
            'orders' => $orders,
            'products' => $products,
            'customers' => $customers
        ];
    }
}