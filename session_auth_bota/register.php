<?php
require 'db.php';


if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }


$errors = [];
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';


    if (strlen($username) < 3 || strlen($username) > 50) $errors[] = 'Username must be 3-50 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))       $errors[] = 'Enter a valid email address.';
    if (strlen($password) < 8)                            $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm)                           $errors[] = 'Passwords do not match.';


    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Username or email is already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);   // bcrypt ($2y$...)
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $hash]);
            $success = 'Account created! You can now log in.';
        }
    }
}


$title = 'Register';
include 'header.php';
?>
<div class="container" style="max-width:480px">
  <div class="card shadow-sm"><div class="card-body p-4">
    <h3 class="mb-3">Create account</h3>
    <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2"><?= e($err) ?></div><?php endforeach; ?>
    <?php if ($success): ?><div class="alert alert-success py-2"><?= e($success) ?> <a href="index.php">Login</a></div><?php endif; ?>
    <form method="post" autocomplete="off">
      <div class="mb-3"><label class="form-label">Username</label>
        <input name="username" class="form-control" value="<?= e($_POST['username'] ?? '') ?>" required></div>
      <div class="mb-3"><label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= e($_POST['email'] ?? '') ?>" required></div>
      <div class="mb-3"><label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Confirm password</label>
        <input type="password" name="confirm" class="form-control" required></div>
      <button class="btn btn-primary w-100">Register</button>
    </form>
    <p class="mt-3 mb-0 text-center">Already have an account? <a href="index.php">Login</a></p>
  </div></div>
</div>
</body></html>