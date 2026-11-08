<?php
// dashboard.php - protected page
require 'db.php';


if (empty($_SESSION['user_id'])) {
    header('Location: index.php?login_required=1');
    exit;
}


// Get extra info for the stat cards
$stmt = $pdo->prepare('SELECT email FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$me = $stmt->fetch();


$hour = (int)date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');


$title = 'Dashboard';
include 'header.php';
?>
<style>
  .hero {
    background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 55%, #a78bfa 100%);
    color: #fff; border-radius: 1.25rem; padding: 2.5rem; position: relative; overflow: hidden;
    box-shadow: 0 12px 30px rgba(124,58,237,.35); animation: fadeUp .6s ease both;
  }
  .hero::before, .hero::after { content:""; position:absolute; border-radius:50%; background:rgba(255,255,255,.1); }
  .hero::before { width:260px; height:260px; top:-90px; right:-60px; }
  .hero::after  { width:160px; height:160px; bottom:-70px; right:140px; }
  .avatar {
    width: 84px; height: 84px; border-radius: 50%; background: #fff; color: #7c3aed;
    font-size: 2.3rem; font-weight: 700; display:flex; align-items:center; justify-content:center;
    box-shadow: 0 0 0 5px rgba(255,255,255,.35);
  }
  .hero .btn-light { color:#5b21b6; font-weight:600; border-radius:2rem; padding:.5rem 1.4rem; }


  .stat-card {
    border: 0; border-radius: 1rem; background:#fff; padding: 1.4rem; height:100%;
    box-shadow: 0 4px 14px rgba(91,33,182,.10); transition: transform .25s, box-shadow .25s;
    animation: fadeUp .6s ease both;
  }
  .stat-card:hover { transform: translateY(-6px); box-shadow: 0 14px 28px rgba(91,33,182,.22); }
  .icon-box {
    width: 48px; height: 48px; border-radius: .9rem; display:flex; align-items:center; justify-content:center;
    font-size: 1.4rem; color:#fff; background: linear-gradient(135deg,#7c3aed,#a78bfa); margin-bottom:.9rem;
  }
  .session-box {
    background:#f5f3ff; border:1px dashed #a78bfa; border-radius:.6rem; padding:.6rem .8rem;
    word-break: break-all; color:#5b21b6; font-size:.85rem;
  }
  .pulse { width:10px; height:10px; border-radius:50%; background:#22c55e; display:inline-block;
           box-shadow:0 0 0 0 rgba(34,197,94,.7); animation:pulse 1.6s infinite; }


  .marquee { overflow:hidden; white-space:nowrap; padding:.7rem 0; background:#ede9fe; border-radius:.75rem; }
  .marquee span { display:inline-block; padding-left:100%; color:#5b21b6; font-weight:500;
                  animation: scroll-left 14s linear infinite; }
  .marquee:hover span { animation-play-state: paused; }


  .d2 { animation-delay:.1s } .d3 { animation-delay:.2s } .d4 { animation-delay:.3s }
  @keyframes scroll-left { from{transform:translateX(0)} to{transform:translateX(-100%)} }
  @keyframes fadeUp { from{opacity:0; transform:translateY(20px)} to{opacity:1; transform:none} }
  @keyframes pulse { 70%{box-shadow:0 0 0 10px rgba(34,197,94,0)} 100%{box-shadow:0 0 0 0 rgba(34,197,94,0)} }
</style>


<div class="container pb-5">


  <!-- HERO -->
  <div class="hero mb-4">
    <div class="d-flex align-items-center flex-wrap gap-4 position-relative" style="z-index:1">
      <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'], 0, 1))) ?></div>
      <div class="flex-grow-1">
        <p class="mb-1 opacity-75"><?= $greeting ?> 👋</p>
        <h1 class="fw-bold mb-1">Welcome, <?= e($_SESSION['username']) ?>!</h1>
        <p class="mb-3 opacity-90">This page is protected and only visible to logged-in users.</p>
        <a href="#details" class="btn btn-light"><i class="bi bi-compass"></i> Explore Dashboard</a>
      </div>
    </div>
  </div>


  <!-- STAT CARDS -->
  <div class="row g-4 mb-4" id="details">
    <div class="col-md-6 col-lg-4 d2">
      <div class="stat-card d2">
        <div class="icon-box"><i class="bi bi-shield-check"></i></div>
        <h6 class="text-muted mb-1">Account Status</h6>
        <h5 class="fw-bold"><span class="pulse"></span> Active</h5>
        <p class="small text-muted mb-0">Protected against Session Fixation using <code>session_regenerate_id(true)</code>.</p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="stat-card d3">
        <div class="icon-box"><i class="bi bi-person-badge"></i></div>
        <h6 class="text-muted mb-1">User Details</h6>
        <p class="small mb-1"><strong>User ID:</strong> <?= (int)$_SESSION['user_id'] ?></p>
        <p class="small mb-1"><strong>Username:</strong> <?= e($_SESSION['username']) ?></p>
        <p class="small mb-0"><strong>Email:</strong> <?= e($me['email'] ?? '') ?></p>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="stat-card d4">
        <div class="icon-box"><i class="bi bi-key"></i></div>
        <h6 class="text-muted mb-2">Active Session ID</h6>
        <div class="session-box" id="sid"><?= e(session_id()) ?></div>
      </div>
    </div>
  </div>


  <div class="marquee">
    <span>This is a demo dashboard. You can log out and log back in to see session regeneration in action.</span>
  </div>
</div>


</body></html>