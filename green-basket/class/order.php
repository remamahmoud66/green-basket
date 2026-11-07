<?php
class Order
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = 'SELECT orders.*, users.name AS customer_name
                FROM orders
                JOIN users ON orders.user_id = users.id
                ORDER BY orders.id DESC';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById($id)
    {
        $statement = $this->pdo->prepare(
            'SELECT orders.*, users.name AS customer_name
             FROM orders
             JOIN users ON orders.user_id = users.id
             WHERE orders.id = ?'
        );

        $statement->execute([$id]);

        return $statement->fetch();
    }

    public function getItems($id): array
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM order_items WHERE order_id = ?'
        );

        $statement->execute([$id]);

        return $statement->fetchAll();
    }

    public function updateStatus($id, $status, $payment_status): bool
    {
        $statement = $this->pdo->prepare(
            'UPDATE orders SET status = ?, payment_status = ? WHERE id = ?'
        );

        return $statement->execute([$status, $payment_status, $id]);
    }
}