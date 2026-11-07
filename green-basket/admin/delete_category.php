<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/admin_check.php';
require_once __DIR__ . '/../class/Category.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $category = new Category($pdo);

    try {
        $category->delete($id);
    } catch (PDOException $error) {
        exit('Cannot delete a category that has products.');
    }
}

header('Location: categories.php');
exit;