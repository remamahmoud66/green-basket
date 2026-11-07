<?php
require_once __DIR__ . '/../includes/init.php';

$error = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $statement->execute([$email]);
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        header('Location: ../index.php');
        exit;
    } else {
        $error = 'Email or password is incorrect.';
    }
}

$page_title = 'Login';
require __DIR__ . '/../includes/header.php';
?>
<section class="auth-layout">
    <div class="auth-intro">
        <p class="eyebrow">Green Basket</p>
        <h1>Good food starts here.</h1>
        <p>Log in to continue shopping for fresh vegetables and fruits.</p>
    </div>

    <div class="auth-card">
        <h2>Welcome back</h2>
        <p>Enter your account details to continue.</p>

        <?php if ($error != ''): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form class="auth-form" method="post">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <p class="auth-link">New here? <a href="register.php">Create an account</a></p>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
