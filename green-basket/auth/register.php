<?php
require_once __DIR__ . '/../includes/init.php';

$error = '';

if (isset($_POST['register'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name == '' || $email == '' || $password == '') {
        $error = 'Please fill in all fields.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = 'This email is already registered.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $pdo->prepare(
                'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)'
            );
            $statement->execute([$name, $email, $password_hash]);

            header('Location: login.php');
            exit;
        }
    }
}

$page_title = 'Register';
require __DIR__ . '/../includes/header.php';
?>
<section class="auth-layout">
    <div class="auth-intro">
        <p class="eyebrow">Green Basket</p>
        <h1>Fresh choices, made easy.</h1>
        <p>Create an account to order fresh vegetables and fruits for your home.</p>
    </div>

    <div class="auth-card">
        <h2>Create account</h2>
        <p>It only takes a moment to join.</p>

        <?php if ($error != ''): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form class="auth-form" method="post">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>

            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit" name="register">Create account</button>
        </form>

        <p class="auth-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
