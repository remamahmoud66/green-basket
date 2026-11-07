<?php
require_once __DIR__ . '/../includes/init.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$page_title = 'Profile';
require __DIR__ . '/../includes/header.php';
?>
    <div class="profile-card">
    <h1>My Profile</h1>

    <p>Name: <?= htmlspecialchars($user['name']) ?></p>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>

    <a class="button" href="logout.php">Logout</a>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
