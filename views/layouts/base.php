<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? e($pageTitle) . ' — ' : '' ?>Les Passe</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/public/assets/icons/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/icons/favicon-32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/icons/favicon-16.png" />
  <link rel="apple-touch-icon" href="/public/assets/icons/apple-touch-icon.png" />

  <!-- PWA -->
  <link rel="manifest" href="/manifest.json" />
  <meta name="theme-color" content="#0d1117" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="apple-mobile-web-app-title" content="Les Passe" />

  <!-- OG -->
  <meta property="og:title" content="<?= isset($pageTitle) ? e($pageTitle) . ' — Les Passe' : 'Les Passe — Estate Visitor Access System' ?>" />
  <meta property="og:description" content="Smart gate pass system for gated estates. Residents generate time-limited visitor passes. Guards verify instantly." />
  <meta property="og:image" content="<?= APP_URL ?>/public/assets/og-image.png" />
  <meta property="og:url" content="<?= APP_URL ?>" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:image" content="<?= APP_URL ?>/public/assets/og-image.png" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    :root {
      --bg:       #0d1117;
      --bg2:      #161b22;
      --bg3:      #1c2330;
      --border:   rgba(48,220,128,0.10);
      --border-h: rgba(48,220,128,0.28);
      --green:    #30dc80;
      --greend:   #22c55e;
      --greent:   #4ade80;
      --greenbg:  rgba(48,220,128,0.07);
      --muted:    #8b949e;
      --text:     #e6edf3;
      --danger:   #f85149;
      --warn:     #f0883e;
      --r:        10px;
      --rl:       16px;
    }

    /* SPLASH LOADER */
    #splash {
      position: fixed; inset: 0; z-index: 9999;
      background: #0d1117;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      gap: 20px;
      transition: opacity 0.4s ease;
    }
    #splash.hidden { opacity: 0; pointer-events: none; }
    #splash img { width: 80px; height: 80px; animation: splashPulse 1.2s ease-in-out infinite; }
    #splash-text { font-family: 'DM Sans', sans-serif; font-size: 13px; color: rgba(48,220,128,0.6); letter-spacing: 0.08em; }
    .splash-bar { width: 120px; height: 2px; background: rgba(48,220,128,0.15); border-radius: 2px; overflow: hidden; }
    .splash-fill { height: 100%; width: 0%; background: #30dc80; border-radius: 2px; animation: splashLoad 0.8s ease forwards; animation-delay: 0.1s; }
    @keyframes splashPulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(0.92);opacity:0.7} }
    @keyframes splashLoad  { to { width: 100%; } }

    body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; font-size:15px; line-height:1.65; -webkit-font-smoothing:antialiased; min-height:100vh; display:flex; flex-direction:column; }
    a { color:var(--greent); text-decoration:none; }
    a:hover { text-decoration:underline; }
    img { display:block; max-width:100%; }
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:var(--bg); }
    ::-webkit-scrollbar-thumb { background:rgba(48,220,128,0.18); border-radius:3px; }

    /* NAV */
    .topnav { background:rgba(13,17,23,0.92); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:100; }
    .topnav-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; padding:12px 20px; }
    .nav-logo { display:flex; align-items:center; gap:10px; text-decoration:none; }
    .nav-logo img { width:32px; height:32px; }
    .nav-logo-text { font-family:'Syne',sans-serif; font-size:17px; font-weight:800; color:var(--greent); letter-spacing:-0.01em; }
    .nav-user { display:flex; align-items:center; gap:12px; font-size:13px; color:var(--muted); }
    .nav-role { font-size:11px; padding:3px 10px; border-radius:999px; background:var(--greenbg); border:1px solid var(--border); color:var(--greent); text-transform:capitalize; }
    .nav-logout { font-size:13px; color:var(--muted); border:1px solid rgba(255,255,255,0.09); padding:5px 13px; border-radius:var(--r); transition:all 0.2s; text-decoration:none; }
    .nav-logout:hover { color:var(--text); border-color:rgba(255,255,255,0.22); }

    /* LAYOUT */
    .page { max-width:1060px; margin:0 auto; padding:36px 20px 60px; flex:1; }
    .page-title { font-family:'Syne',sans-serif; font-size:clamp(20px,3.5vw,28px); font-weight:700; letter-spacing:-0.02em; margin-bottom:4px; }
    .page-sub { font-size:14px; color:var(--muted); margin-bottom:28px; }

    /* CARDS */
    .card { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:22px; }
    .card+.card { margin-top:16px; }

    /* STAT GRID */
    .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:24px; }
    .stat-card { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:18px 20px; }
    .stat-num { font-family:'Syne',sans-serif; font-size:26px; font-weight:700; margin-bottom:2px; }
    .stat-label { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:0.07em; }

    /* TABLE */
    .tbl { width:100%; border-collapse:collapse; font-size:14px; }
    .tbl th { text-align:left; font-size:11px; font-weight:500; color:var(--muted); text-transform:uppercase; letter-spacing:0.07em; padding:10px 12px; border-bottom:1px solid var(--border); }
    .tbl td { padding:11px 12px; border-bottom:1px solid rgba(255,255,255,0.04); vertical-align:middle; }
    .tbl tr:last-child td { border-bottom:none; }
    .tbl tr:hover td { background:rgba(255,255,255,0.02); }

    /* BADGES */
    .badge { display:inline-block; font-size:11px; font-weight:500; padding:3px 10px; border-radius:999px; }
    .badge-active    { background:rgba(34,197,94,0.12);  color:#4ade80; border:1px solid rgba(34,197,94,0.2);  }
    .badge-used      { background:rgba(96,165,250,0.12); color:#60a5fa; border:1px solid rgba(96,165,250,0.2); }
    .badge-expired   { background:rgba(255,255,255,0.06);color:var(--muted); border:1px solid rgba(255,255,255,0.09); }
    .badge-cancelled { background:rgba(248,81,73,0.1);   color:#f85149; border:1px solid rgba(248,81,73,0.2);  }
    .badge-warn      { background:rgba(240,136,62,0.12); color:#f0883e; border:1px solid rgba(240,136,62,0.2); }
    .badge-granted   { background:rgba(34,197,94,0.12);  color:#4ade80; border:1px solid rgba(34,197,94,0.2);  }
    .badge-denied    { background:rgba(248,81,73,0.1);   color:#f85149; border:1px solid rgba(248,81,73,0.2);  }

    /* BUTTONS */
    .btn { display:inline-flex; align-items:center; gap:7px; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500; padding:10px 18px; border-radius:var(--r); border:none; cursor:pointer; transition:all 0.18s; text-decoration:none; }
    .btn:hover { text-decoration:none; }
    .btn-green   { background:var(--green); color:#0d1117; }
    .btn-green:hover { background:var(--greend); transform:translateY(-1px); }
    .btn-outline { background:transparent; color:var(--text); border:1px solid rgba(255,255,255,0.12); }
    .btn-outline:hover { border-color:rgba(255,255,255,0.26); background:rgba(255,255,255,0.04); }
    .btn-danger  { background:transparent; color:var(--danger); border:1px solid rgba(248,81,73,0.25); }
    .btn-danger:hover { background:rgba(248,81,73,0.08); }
    .btn-sm { font-size:12px; padding:6px 12px; }

    /* FORMS */
    .form-group { margin-bottom:15px; }
    .form-group label { display:block; font-size:12px; color:var(--muted); margin-bottom:5px; }
    .form-input { width:100%; background:var(--bg); border:1px solid rgba(255,255,255,0.10); border-radius:var(--r); color:var(--text); font-family:'DM Sans',sans-serif; font-size:14px; padding:10px 13px; outline:none; transition:border-color 0.2s; }
    .form-input:focus { border-color:rgba(74,222,128,0.4); }
    select.form-input { cursor:pointer; }
    textarea.form-input { resize:vertical; min-height:80px; }

    /* FLASH */
    .flash { padding:12px 16px; border-radius:var(--r); font-size:14px; margin-bottom:18px; }
    .flash-error   { background:rgba(248,81,73,0.10);  border:1px solid rgba(248,81,73,0.25);  color:#f85149; }
    .flash-success { background:rgba(34,197,94,0.10);  border:1px solid rgba(34,197,94,0.25);  color:#4ade80; }
    .flash-warn    { background:rgba(240,136,62,0.10); border:1px solid rgba(240,136,62,0.25); color:#f0883e; }

    hr { border:none; border-top:1px solid var(--border); margin:22px 0; }

    .empty { text-align:center; padding:44px 20px; color:var(--muted); font-size:14px; }
    .empty-icon { font-size:30px; margin-bottom:10px; opacity:0.4; }

    @media (max-width:600px) {
      .page { padding:18px 14px 40px; }
      .stat-grid { grid-template-columns:1fr 1fr; }
      .tbl th,.tbl td { padding:9px 8px; font-size:13px; }
      .hide-mobile { display:none; }
      .topnav-inner { padding:10px 14px; }
      .btn { padding:9px 14px; font-size:13px; }
    }
  </style>
  <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>

<!-- SPLASH LOADER -->
<div id="splash">
  <img src="/public/assets/icons/icon-192.png" alt="Les Passe" />
  <div class="splash-bar"><div class="splash-fill"></div></div>
  <div id="splash-text">Les Passe</div>
</div>

<nav class="topnav">
  <div class="topnav-inner">
    <a href="<?= APP_URL ?>" class="nav-logo">
      <img src="/public/assets/icons/favicon-32.png" alt="Les Passe logo" />
      <span class="nav-logo-text">Les Passe</span>
    </a>
    <?php if (is_logged_in()): ?>
    <div class="nav-user">
      <span class="hide-mobile"><?= e(current_user_name()) ?></span>
      <span class="nav-role"><?= e(current_role()) ?></span>
      <a href="<?= APP_URL ?>/auth/logout" class="nav-logout">Log out</a>
    </div>
    <?php endif; ?>
  </div>
</nav>

<div class="page">
  <?php
    $flash = get_flash();
    if ($flash):
      $cls = $flash['type'] === 'error' ? 'flash-error' : ($flash['type'] === 'warn' ? 'flash-warn' : 'flash-success');
  ?>
  <div class="flash <?= $cls ?>"><?= e($flash['message']) ?></div>
  <?php endif; ?>
  <?php echo $content ?? ''; ?>
</div>

<footer style="text-align:center;padding:18px;font-size:12px;color:var(--muted);border-top:1px solid var(--border);">
  Les Passe &copy; <?= date('Y') ?> &nbsp;·&nbsp; Estate visitor access system
</footer>

<script>
  window.addEventListener('load', () => {
    setTimeout(() => {
      const splash = document.getElementById('splash');
      if (splash) splash.classList.add('hidden');
      setTimeout(() => { if (splash) splash.remove(); }, 450);
    }, 600);
  });
</script>

</body>
</html>