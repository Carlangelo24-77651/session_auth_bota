<?php /* shared layout top: expects $title */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? 'SessionAuthSystem') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --purple: #7c3aed;
      --purple-dark: #5b21b6;
      --purple-light: #f5f3ff;
      --bs-primary: var(--purple);
      --bs-primary-rgb: 124, 58, 237;
      --bs-link-color: var(--purple);
      --bs-link-hover-color: var(--purple-dark);
    }
    body { background: var(--purple-light) !important; }
    .navbar { background: linear-gradient(90deg, var(--purple-dark), var(--purple)) !important; }
    .btn-primary {
      --bs-btn-bg: var(--purple); --bs-btn-border-color: var(--purple);
      --bs-btn-hover-bg: var(--purple-dark); --bs-btn-hover-border-color: var(--purple-dark);
      --bs-btn-active-bg: var(--purple-dark); --bs-btn-active-border-color: var(--purple-dark);
      --bs-btn-focus-shadow-rgb: 124, 58, 237;
    }
    .text-primary { color: var(--purple) !important; }
    .form-control:focus { border-color: var(--purple); box-shadow: 0 0 0 .25rem rgba(124,58,237,.25); }
    .card, .bg-white { border-color: #ddd6fe !important; }
  </style>
</head>
<body class="bg-light">
<?php if (empty($hideNav)): ?>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">SessionAuthSystem</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a class="nav-link text-white me-auto ms-3" href="dashboard.php">Dashboard</a>
      <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?= e($_SESSION['username']) ?></span>
      <a href="logout.php" class="btn btn-light btn-sm fw-semibold text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    <?php else: ?>
      <div>
        <a href="index.php" class="btn btn-outline-light btn-sm">Login</a>
        <a href="register.php" class="btn btn-primary btn-sm">Register</a>
      </div>
    <?php endif; ?>
  </div>
</nav>
<?php endif; ?>