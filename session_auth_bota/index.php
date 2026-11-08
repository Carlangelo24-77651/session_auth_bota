<?php
// index.php - login page
require 'db.php';


if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }


$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password_hash'])) {
        // Prevent Session Fixation: issue a brand-new session ID after login
        session_regenerate_id(true);


        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];


        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}


$title = 'Login - AuthSystem';
$hideNav = true;
include 'header.php';
?>
<style>
  .auth-wrap { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding:1.5rem;
               background: linear-gradient(160deg, #f5f3ff 0%, #ede9fe 100%); }
  .auth-card { width:100%; max-width:400px; background:#fff; border-radius:1.25rem; padding:2.2rem 2rem;
               box-shadow: 0 15px 40px rgba(91,33,182,.18); animation: fadeUp .5s ease both; }
  .auth-icon { width:64px; height:64px; border-radius:50%; margin:0 auto 1rem; color:#fff; font-size:1.9rem;
               display:flex; align-items:center; justify-content:center;
               background: linear-gradient(135deg,#7c3aed,#a78bfa); box-shadow:0 6px 16px rgba(124,58,237,.4); }
  .auth-card .input-group-text { background:#f5f3ff; border-color:#ddd6fe; color:#7c3aed; }
  .auth-card .form-control { background:#f5f3ff; border-color:#ddd6fe; padding:.65rem .75rem; }
  .auth-card .form-control:focus { background:#fff; }
  .auth-card .btn-primary { padding:.7rem; font-weight:600; border-radius:.6rem; }
  .toggle-pw { cursor:pointer; background:#f5f3ff; border-color:#ddd6fe; color:#7c3aed; }
  @keyframes fadeUp { from{opacity:0; transform:translateY(20px)} to{opacity:1; transform:none} }
</style>


<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-icon"><i class="bi bi-person-fill"></i></div>
    <h3 class="text-center fw-bold mb-1">Welcome Back</h3>
    <p class="text-center text-muted small mb-4">Sign in to your account</p>


    <?php if (isset($_GET['logged_out'])): ?><div class="alert alert-info py-2 small">You have been logged out.</div><?php endif; ?>
    <?php if (isset($_GET['login_required'])): ?><div class="alert alert-warning py-2 small">Please log in first.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-circle"></i> <?= e($error) ?></div><?php endif; ?>


    <form method="post">
      <label class="form-label fw-semibold small">Username or Email</label>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input name="username" class="form-control" placeholder="Enter username or email" required autofocus>
      </div>


      <label class="form-label fw-semibold small">Password</label>
      <div class="input-group mb-4">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" id="pw" class="form-control" placeholder="Enter password" required>
        <span class="input-group-text toggle-pw" onclick="togglePw(this)"><i class="bi bi-eye"></i></span>
      </div>


      <button class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
    </form>


    <hr class="my-4">
    <p class="text-center small mb-0">Don't have an account? <a href="register.php" class="fw-semibold text-decoration-none">Register here</a></p>
  </div>
</div>


<script>
  function togglePw(el) {
    const pw = document.getElementById('pw');
    const show = pw.type === 'password';
    pw.type = show ? 'text' : 'password';
    el.innerHTML = '<i class="bi bi-eye' + (show ? '-slash' : '') + '"></i>';
  }
</script>
</body></html>